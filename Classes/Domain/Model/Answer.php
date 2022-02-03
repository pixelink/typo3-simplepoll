<?php
declare(strict_types = 1);

namespace Pixelink\Simplepoll\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * All possible answers to the poll.
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
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
     * @var int
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
     * @return int $counter
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * Sets the counter
     *
     * @param int $counter
     *
     * @return void
     */
    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }
}
