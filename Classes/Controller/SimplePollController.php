<?php
namespace Pixelink\Simplepoll\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Alex Bigott <support@pixel-ink.de>, Pixel Ink
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Pixelink\Simplepoll\Domain\Model\Answer;
use Pixelink\Simplepoll\Domain\Model\IpLock;
use Pixelink\Simplepoll\Domain\Model\SimplePoll;
use Pixelink\Simplepoll\Domain\Repository\AnswerRepository;
use Pixelink\Simplepoll\Domain\Repository\IpLockRepository;
use Pixelink\Simplepoll\Domain\Repository\SimplePollRepository;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * SimplePollController
 */
class SimplePollController extends ActionController
{
    /**
     * @var SimplePollRepository
     */
    protected $simplePollRepository = null;

    /**
     * @var AnswerRepository
     */
    protected $answerRepository = null;

    /**
     * @var IpLockRepository
     */
    protected $ipLockRepository = null;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @param SimplePollRepository $simplePollRepository
     * @param AnswerRepository $answerRepository
     * @param IpLockRepository $ipLockRepository
     * @param PersistenceManager $persistenceManager
     */
    public function __construct(
        SimplePollRepository $simplePollRepository,
        AnswerRepository $answerRepository,
        IpLockRepository $ipLockRepository,
        PersistenceManager $persistenceManager
    ) {
        $this->simplePollRepository = $simplePollRepository;
        $this->answerRepository = $answerRepository;
        $this->ipLockRepository = $ipLockRepository;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * list action
     *
     * display the poll
     *
     * @return void
     */
    public function listAction(): void
    {
        // Use stdWrap for settings.simplepoll.uid
        if (isset($this->settings['simplepoll']['useStdWrap']) && !empty($this->settings['simplepoll']['useStdWrap'])) {
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $typoScriptArray = $typoScriptService->convertPlainArrayToTypoScriptArray($this->settings);
            $typoScriptArray = $typoScriptArray['simplepoll.'];

            $this->settings['simplepoll']['uid'] = $this->configurationManager->getContentObject()->stdWrap(
                $typoScriptArray['uid'],
                $typoScriptArray['uid.']
            );
        }

        //this selects the poll given in the plugin itself
        $simplePoll = $this->simplePollRepository->findByUid($this->settings['simplepoll']['uid']);

        if (!$simplePoll) {
            $message = LocalizationUtility::translate('tx_simplepoll.pollNotFound', 'Simplepoll');
            $this->forward('message', null, null, ['message' => $message]);
        }

        //first check the end time of the poll. if it has already passed, we only show the results.
        if ($simplePoll->getEndTime() !== '') {
            $endTime = (int)$simplePoll->getEndTime()->format('U');
            $currentTime = time();

            if ($currentTime > $endTime) {
                $this->forward('seeVotes', 'SimplePoll', null, ['simplePoll' => $simplePoll]);
            }
        }

        // if a user already voted and currently is not allowed to do so again, we forward him directly to the result
        // this can only happen, if showResultAfterVote is set to true, otherwise we have to stick to the old behaviour and display the question.
        // get the settings for show results after vote either global or local
        $showResultAfterVote = $simplePoll->getShowResultAfterVote();

        if ($this->settings['useTyposcriptSettings'] == 'true' || $this->settings['useTyposcriptSettings'] == '1') {
            $showResultAfterVote = $this->settings['showResultAfterVote'];
        }

        if (strtolower($showResultAfterVote) == 'true' || $showResultAfterVote === '1') {
            $showResultIfNotAllowedToVote = $this->settings['showResultIfNotAllowedToVote'];

            if (strtolower($showResultIfNotAllowedToVote) == 'true' || $showResultIfNotAllowedToVote == '1') {
                // check if a vote is allowed by the users IP
                // IP check always overrules cookie check
                $checkVoteOkFromIp = $this->checkVoteOkFromIp($simplePoll, true);

                if ($checkVoteOkFromIp !== true) {
                    $this->forward('seeVotes', 'SimplePoll', null, ['simplePoll' => $simplePoll]);
                }

                // check if a vote is allowed by the users cookies
                $checkVoteOkFromCookie = $this->checkVoteOkFromCookie($simplePoll, true);

                if ($checkVoteOkFromCookie !== true) {
                    $this->forward('seeVotes', 'SimplePoll', null, ['simplePoll' => $simplePoll]);
                }
            }
        }

        $answers = $simplePoll->getAnswers();

        $this->view->assignMultiple([
            'simplePoll' => $simplePoll,
            'answers' => $answers
        ]);
    }

    /**
     * message action
     *
     * output messages belonging to the poll
     * @param string $message
     */
    public function messageAction(string $message): void
    {
        $this->view->assign('message', $message);
    }

    /**
     * vote action
     *
     * count the votes if the vote is allowed by the settings and the current state of the user concerning his last vote
     *
     * @param SimplePoll $simplePoll
     */
    public function voteAction(SimplePoll $simplePoll): void
    {
        $voteId = null;

        if ($this->request->hasArgument('simplePollRadio')) {
            $voteId = $this->request->getArgument('simplePollRadio');
        } else {
            $this->redirectWithPageType('list');
        }

        $checkVoteOkFromIp = $this->checkVoteOkFromIp($simplePoll);

        // check if a vote is allowed by the users IP
        // IP check always overrules cookie check
        if ($checkVoteOkFromIp !== true) {
            $this->redirectWithPageType('message', null, null, ['message' => $checkVoteOkFromIp]);
        }

        // check if a vote is allowed by the users cookies
        $checkVoteOkFromCookie = $this->checkVoteOkFromCookie($simplePoll);

        if ($checkVoteOkFromCookie !== true) {
            $this->redirectWithPageType('message', null, null, ['message' => $checkVoteOkFromCookie]);
        }

        if ($voteId !== null) {
            $currentAnswer = $this->answerRepository->findByUid($voteId);

            if ($currentAnswer) {
                $currentAnswer->setCounter($currentAnswer->getCounter() + 1);
            }

            $this->answerRepository->update($currentAnswer);
        }

        $showResultAfterVote = $simplePoll->getShowResultAfterVote();

        // get the settings for show results after vote either global or local
        if ($this->settings['useTyposcriptSettings'] == 'true' || $this->settings['useTyposcriptSettings'] == '1') {
            $showResultAfterVote = $this->settings['showResultAfterVote'];
        }

        if ($showResultAfterVote) {
            $this->redirectWithPageType('seeVotes', 'SimplePoll', null, ['simplePoll' => $simplePoll]);
        } else {
            $message = LocalizationUtility::translate('tx_simplepoll.votedDontSeeResultsMessage', 'Simplepoll');
            $this->redirectWithPageType('message', null, null, ['message' => $message]);
        }
    }

    /**
     * check vote ok from cookie
     *
     * checks against the settings if cookie block is used. if so checks if a cookie exists
     * for the current simplePoll. if so, checks the timestamp in the cookie to decide if the
     * user can vote again. if he votes and cookies are used, a cookie with the current timstamp is written
     *
     * @param SimplePoll $simplePoll
     * @param boolean $onlyCheck
     *
     * @return mixed true if the user is allowed to vote, string with the error message if not
     */
    protected function checkVoteOkFromCookie(
        SimplePoll $simplePoll,
        bool $onlyCheck = false
    ) {
        // get the settings for cookie blocking
        $cookieBlock = $this->settings['cookieBlock'];

        if (!(strtolower($cookieBlock) == 'true' || $cookieBlock == '1')) {
            // cookies are not blocked, so the user can vote
            return true;
        }

        $allowMultipleVote = $simplePoll->getAllowMultipleVote();

        // get the settings for multiple votes either global or local
        if ($this->settings['useTyposcriptSettings'] == 'true' || $this->settings['useTyposcriptSettings'] == '1') {
            $allowMultipleVote = $this->settings['allowMultipleVote'];
        }

        // check if there already is a cookie. that would mean the user is not allowed to vote right now.
        $cookieExists = isset($_COOKIE['simplePoll-' . $simplePoll->getUid()]);

        if ($cookieExists) {

            if ($allowMultipleVote) {
                return LocalizationUtility::translate('tx_simplepoll.voteNotNow', 'Simplepoll');
            } else {
                return LocalizationUtility::translate('tx_simplepoll.voteOnlyOnce', 'Simplepoll');
            }
        }

        if (!$onlyCheck) {

            // set the cookie for the current poll, so other polls won't be affected.
            // if multiple votes are not allowed we set the cookie valid for one month
            if ($allowMultipleVote) {
                setcookie('simplePoll-' . $simplePoll->getUid(), time(), time() + $this->settings['garbageCollectorInterval'], '/');
            } else {
                setcookie('simplePoll-' . $simplePoll->getUid(), time(), time() + 60 * 60 * 24 * 30, '/');
            }
        }

        return true;
    }


    /**
     * check vote ok from ip
     *
     * checks if the current user is allowed to vote with his ip. also writes the ip to the lock list
     * and calls the garbage collector if the ipBlock is activated via typoscript.
     *
     * @param SimplePoll $simplePoll
     * @param boolean $onlyCheck
     *
     * @return mixed true if the user is allowed to vote, string with the error message if not
     */
    protected function checkVoteOkFromIp(
        SimplePoll $simplePoll,
        bool $onlyCheck = false
    ) {
        $ipBlock = $this->settings['ipBlock'];

        if (!(strtolower($ipBlock) == 'true' || $ipBlock == '1')) {
            // IPs are not blocked, so the user can vote
            return true;
        }

        $allowMultipleVote = $simplePoll->getAllowMultipleVote();

        // get the settings for multiple votes either global or local
        if ($this->settings['useTyposcriptSettings'] == 'true' || $this->settings['useTyposcriptSettings'] == '1') {
            $allowMultipleVote = $this->settings['allowMultipleVote'];
        }

        //call the garbage collector on the ip locks.
        $this->cleanupIpLocks($simplePoll);

        $userIp = $_SERVER['REMOTE_ADDR'];
        $lockedIp = $this->ipLockRepository->getIpInPoll($simplePoll, $userIp);

        if ($lockedIp) {

            // in here we know that the user already voted for this poll.
            // now we need to check if mutliple votes are allowed and if so, if enough time passed since the last vote.
            if ($allowMultipleVote) {

                //if the timestamp in the ip lock is not null, he is not allowed to vote again (yet)
                $lockedIpTimestamp = $lockedIp->getTimestamp();

                if ($lockedIpTimestamp !== null) {
                    return LocalizationUtility::translate('tx_simplepoll.voteNotNow', 'Simplepoll');
                } else {
                    // vote is allowed, so we simply remove the current lock and let it create again down below
                    $simplePoll->removeIpLock($lockedIp);
                }
            } else {
                //voted before and not allowed to vote again, because no multiple votes
                return LocalizationUtility::translate('tx_simplepoll.voteOnlyOnce', 'Simplepoll');
            }
        }

        if (!$onlyCheck) {
            // first or allowed vote from this IP, so add the user to the ip lock list. return true because he is allowed to vote
            $ipLock = $this->objectManager->get(IpLock::class);
            $ipLock->setAddress($userIp);
            $ipLock->setTimestamp(new \DateTime);
            $simplePoll->addIpLock($ipLock);
            $this->simplePollRepository->update($simplePoll);
        }

        return true;
    }


    /**
     * cleanup IP locks
     *
     * this is run, if we allow multiple votes and use IP blocking. the method gets called every time a new vote under
     * these circumstances is done
     *
     * @param SimplePoll $simplePoll
     */
    protected function cleanupIpLocks(SimplePoll $simplePoll): void
    {
        // get the interval from the settigs which tell how long a user is not allowed to vote again
        $garbageCollectorInterval = $this->settings['garbageCollectorInterval'];
        $currentTime = new \DateTime;

        // get all ip locks, which belong to the poll
        $ipLocks = $simplePoll->getIpLocks();

        foreach ($ipLocks as $ipLock) {
            $ipLockTime = $ipLock->getTimestamp();

            if ($ipLockTime !== null) {
                $timeDelta = (int)$currentTime->format('U') - (int)$ipLockTime->format('U');

                // if the iplock is older than the given setting value, we remove it
                if ($timeDelta > $garbageCollectorInterval) {
                    $simplePoll->removeIpLock($ipLock);
                }
            }
        }

        $this->simplePollRepository->update($simplePoll);
        $this->persistenceManager->persistAll();
    }

    /**
     * see votes action
     *
     * display the voting result
     *
     * @param SimplePoll $simplePoll
     */
    public function seeVotesAction(SimplePoll $simplePoll): void
    {
        $allAnswers = $simplePoll->getAnswers();

        // if all languages are meant to be added up, we get the needed counters here
        if (!$this->settings['countLanguagesSeperately']) {
            $allAnswers = $this->answerRepository->findAllLanguageAnswers($allAnswers);
        }

        $answerCount = 0;
        $answersCountArray = [];

        /** @var Answer $answer */
        foreach ($allAnswers as $answer) {
            $answerCount += $answer->getCounter();
        }

        /** @var Answer $answer */
        foreach ($allAnswers as $answer) {
            //prevent division by zero for new polls.
            $answerCount = ($answerCount === 0) ? 1 : $answerCount;
            $answersCountArray[$answer->getUid()] = round((float)($answer->getCounter() / $answerCount) * 100, 2);
        }

        $answersArray = $this->reformatAnswers($allAnswers, $answersCountArray);
        $this->view->assignMultiple([
            'allAnswersCount' => $answerCount,
            'answersArray' => $answersArray,
            'simplePoll' => $simplePoll,
        ]);
    }

    /**
     * reformat answers
     *
     * returns a single array which holds all the needed informations to output the result in fluid
     *
     * @param array $allAnswers
     * @param array $answersCountArray array of the answers with their perventage numbers
     *
     * @return array array an array in which the key is the UID and the array items are title, percent and iteration (last is needed for the CSS class)
     */
    protected function reformatAnswers(array $allAnswers, array $answersCountArray): array
    {
        $answersArrayUnsorted = [];
        $iteration = 1;

        foreach ($allAnswers as $answer) {
            $answersArrayUnsorted[$answer->getUid()]['title'] = $answer->getTitle();
            $answersArrayUnsorted[$answer->getUid()]['counter'] = $answer->getCounter();
            $answersArrayUnsorted[$answer->getUid()]['percent'] = $answersCountArray[$answer->getUid()];
            $answersArrayUnsorted[$answer->getUid()]['iteration'] = $iteration++;
        }

        return $answersArrayUnsorted;
    }

    /**
     * redirect with page type
     *
     * a redirect wich respects the page type that was used before.
     * without this the ajax calls which are called with a $this->redirect() will return the complete
     * page with all header data no matter what is set in typoscript
     *
     * @param string $action
     * @param string|null $controller
     * @param null $extension
     * @param array|null $arguments
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    protected function redirectWithPageType(
        string $action,
        string $controller = null,
        $extension = null,
        array $arguments = null
    ): void {
        $pageType = GeneralUtility::_GP("type");

        if ($pageType) {
            $this->uriBuilder->setRequest($this->request);
            $this->uriBuilder->setTargetPageType($pageType);
            $uri = $this->uriBuilder->uriFor($action, $arguments, $controller, $extension);
            $this->redirectToURI($uri);
        }

        // no page type so we do a normal redirect
        $this->redirect($action, $controller, $extension, $arguments);
    }
}
