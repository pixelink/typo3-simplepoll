<?php
namespace Pixelink\Simplepoll\Domain\Model;


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

/**
 * SimplePoll
 */
class SimplePoll extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The question of the poll
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $question = '';

	/**
	 * Optional image of the poll
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image = NULL;

	/**
	 * End time of the poll
	 *
	 * @var \DateTime
	 */
	protected $endTime = NULL;

	/**
	 * Whether or not to display the show results button
	 *
	 * @var boolean
	 */
	protected $showResultLink = FALSE;

	/**
	 * Show the result after voting
	 *
	 * @var boolean
	 */
	protected $showResultAfterVote = FALSE;

	/**
	 * If a user is allowed to vote several times
	 *
	 * @var boolean
	 */
	protected $allowMultipleVote = FALSE;

	/**
	 * answers
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\Answer>
	 * @cascade remove
	 * @lazy
	 */
	protected $answers = NULL;

	/**
	 * Holds the IP addresses of the voters of the poll
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\IpLock>
	 * @cascade remove
	 * @lazy
	 */
	protected $ipLocks = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->answers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ipLocks = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the question
	 *
	 * @return string $question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * Sets the question
	 *
	 * @param string $question
	 * @return void
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image = $image;
	}

	/**
	 * Returns the endTime
	 *
	 * @return \DateTime $endTime
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * Sets the endTime
	 *
	 * @param \DateTime $endTime
	 * @return void
	 */
	public function setEndTime(\DateTime $endTime) {
		$this->endTime = $endTime;
	}

	/**
	 * Returns the showResultLink
	 *
	 * @return boolean $showResultLink
	 */
	public function getShowResultLink() {
		return $this->showResultLink;
	}

	/**
	 * Sets the showResultLink
	 *
	 * @param boolean $showResultLink
	 * @return void
	 */
	public function setShowResultLink($showResultLink) {
		$this->showResultLink = $showResultLink;
	}

	/**
	 * Returns the boolean state of showResultLink
	 *
	 * @return boolean
	 */
	public function isShowResultLink() {
		return $this->showResultLink;
	}

	/**
	 * Returns the showResultAfterVote
	 *
	 * @return boolean $showResultAfterVote
	 */
	public function getShowResultAfterVote() {
		return $this->showResultAfterVote;
	}

	/**
	 * Sets the showResultAfterVote
	 *
	 * @param boolean $showResultAfterVote
	 * @return void
	 */
	public function setShowResultAfterVote($showResultAfterVote) {
		$this->showResultAfterVote = $showResultAfterVote;
	}

	/**
	 * Returns the boolean state of showResultAfterVote
	 *
	 * @return boolean
	 */
	public function isShowResultAfterVote() {
		return $this->showResultAfterVote;
	}

	/**
	 * Returns the allowMultipleVote
	 *
	 * @return boolean $allowMultipleVote
	 */
	public function getAllowMultipleVote() {
		return $this->allowMultipleVote;
	}

	/**
	 * Sets the allowMultipleVote
	 *
	 * @param boolean $allowMultipleVote
	 * @return void
	 */
	public function setAllowMultipleVote($allowMultipleVote) {
		$this->allowMultipleVote = $allowMultipleVote;
	}

	/**
	 * Returns the boolean state of allowMultipleVote
	 *
	 * @return boolean
	 */
	public function isAllowMultipleVote() {
		return $this->allowMultipleVote;
	}

	/**
	 * Adds a Answer
	 *
	 * @param \Pixelink\Simplepoll\Domain\Model\Answer $answer
	 * @return void
	 */
	public function addAnswer(\Pixelink\Simplepoll\Domain\Model\Answer $answer) {
		$this->answers->attach($answer);
	}

	/**
	 * Removes a Answer
	 *
	 * @param \Pixelink\Simplepoll\Domain\Model\Answer $answerToRemove The Answer to be removed
	 * @return void
	 */
	public function removeAnswer(\Pixelink\Simplepoll\Domain\Model\Answer $answerToRemove) {
		$this->answers->detach($answerToRemove);
	}

	/**
	 * Returns the answers
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\Answer> $answers
	 */
	public function getAnswers() {
            return $this->answers;
	}

	/**
	 * Sets the answers
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\Answer> $answers
	 * @return void
	 */
	public function setAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers) {
		$this->answers = $answers;
	}

	/**
	 * Adds a IpLock
	 *
	 * @param \Pixelink\Simplepoll\Domain\Model\IpLock $ipLock
	 * @return void
	 */
	public function addIpLock(\Pixelink\Simplepoll\Domain\Model\IpLock $ipLock) {
		$this->ipLocks->attach($ipLock);
	}

	/**
	 * Removes a IpLock
	 *
	 * @param \Pixelink\Simplepoll\Domain\Model\IpLock $ipLockToRemove The IpLock to be removed
	 * @return void
	 */
	public function removeIpLock(\Pixelink\Simplepoll\Domain\Model\IpLock $ipLockToRemove) {
		$this->ipLocks->detach($ipLockToRemove);
	}

	/**
	 * Returns the ipLocks
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\IpLock> $ipLocks
	 */
	public function getIpLocks() {
		return $this->ipLocks;
	}

	/**
	 * Sets the ipLocks
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelink\Simplepoll\Domain\Model\IpLock> $ipLocks
	 * @return void
	 */
	public function setIpLocks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ipLocks) {
		$this->ipLocks = $ipLocks;
	}

}