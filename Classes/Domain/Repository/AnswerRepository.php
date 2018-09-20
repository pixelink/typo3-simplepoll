<?php
namespace Pixelink\Simplepoll\Domain\Repository;


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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for SimplePolls
 */
class AnswerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * @var array
     */
     protected $defaultOrderings = array('sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

    /**
     * @var string
     */
    protected $answerTable = 'tx_simplepoll_domain_model_answer';

    /**
     * find all language answers
     *
     * for a given array of answers and a simplepoll we check all languages for answers and
     * sum them up.
     * later an array like $allAnswers with the corrected count is returned
     *
     * @param array $allAnswers
     * @return array
     */
     public function findAllLanguageAnswers(array $allAnswers)
     {
         $returnedAnswers = array();
         foreach($allAnswers as $answer)
         {
             $counterDefaultLanguage = $this->getCounterForUidDefaultLanguage($answer->getUid());
             $counterOtherLanguages = $this->getCounterForUidOtherLanguages($answer->getUid());
             
             $answer->setCounter($counterDefaultLanguage + $counterOtherLanguages);
             $returnedAnswers[] = $answer;
         }
         return $returnedAnswers;
     }
     
     /**
      * get counter for uid default language
      * 
      * for any given answer we get the true counter for the default language entry
      * note:
      * for any language typo3 returns the uid of the answer with the default language. 
      * language handling is buggy and about to be changed in version 9 or 10
      * 
      * @param int $uid
      * @return int
      */
    public function getCounterForUidDefaultLanguage($uid)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->answerTable);
        $answer = $queryBuilder
            ->select('counter')
            ->from($this->answerTable)
            ->where(
                $queryBuilder->expr()->eq('uid', $uid),
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute();

        if ($row = $answer->fetch()) {
            return $row['counter'];
        }
        return 0;
    }

     /**
      * get counter for uid other language
      * 
      * for any given answer we get the true counter all other languages combined.
      * note:
      * for any language typo3 returns the uid of the answer with the default language. 
      * language handling is buggy and about to be changed in version 9 or 10
      * 
      * @param int $uid
      * @return int
      */
    public function getCounterForUidOtherLanguages($uid)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->answerTable);
        $answer = $queryBuilder
            ->select('counter')
            ->from($this->answerTable)
            ->where(
                $queryBuilder->expr()->eq('l10n_parent', $uid),
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute();

        // add up answers with other languages
        $languagesSum = 0;
        while ($row = $answer->fetch()) {
            $languagesSum += $row['counter'];
        }
        return $languagesSum;
    }


             
	
}