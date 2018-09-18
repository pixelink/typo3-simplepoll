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
 * All possible answers to the poll.
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The text of the answer
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title = '';

	/**
	 * The count of how many times this answer was chosen
	 *
	 * @var integer
	 */
	protected $counter = 0;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the counter
	 *
	 * @return integer $counter
	 */
	public function getCounter() {
		return $this->counter;
	}

	/**
	 * Sets the counter
	 *
	 * @param integer $counter
	 * @return void
	 */
	public function setCounter($counter) {
		$this->counter = $counter;
	}

}