<?php
namespace Pixelink\Simplepoll\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade as Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy as Lazy;

/**
 * All possible answers to the poll.
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The text of the answer
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
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
	public function getTitle(): string
    {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
     *
	 * @return void
	 */
	public function setTitle(string $title): void
    {
		$this->title = $title;
	}

	/**
	 * Returns the counter
	 *
	 * @return integer $counter
	 */
	public function getCounter(): int
    {
		return $this->counter;
	}

	/**
	 * Sets the counter
	 *
	 * @param integer $counter
     *
	 * @return void
	 */
	public function setCounter(int $counter): void
    {
		$this->counter = $counter;
	}
}
