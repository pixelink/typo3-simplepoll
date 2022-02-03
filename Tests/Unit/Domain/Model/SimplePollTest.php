<?php
declare(strict_types = 1);

namespace Pixelink\Simplepoll\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alex Bigott <support@pixel-ink.de>, Pixel Ink
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \Pixelink\Simplepoll\Domain\Model\SimplePoll.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Alex Bigott <support@pixel-ink.de>
 */
class SimplePollTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Pixelink\Simplepoll\Domain\Model\SimplePoll
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new \Pixelink\Simplepoll\Domain\Model\SimplePoll();
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getQuestion()
        );
    }

    /**
     * @test
     */
    public function setQuestionForStringSetsQuestion()
    {
        $this->subject->setQuestion('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'question',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        $this->assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImage($fileReferenceFixture);

        $this->assertAttributeEquals(
            $fileReferenceFixture,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEndTimeReturnsInitialValueForDateTime()
    {
        $this->assertEquals(
            null,
            $this->subject->getEndTime()
        );
    }

    /**
     * @test
     */
    public function setEndTimeForDateTimeSetsEndTime()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setEndTime($dateTimeFixture);

        $this->assertAttributeEquals(
            $dateTimeFixture,
            'endTime',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getShowResultLinkReturnsInitialValueForBoolean()
    {
        $this->assertSame(
            false,
            $this->subject->getShowResultLink()
        );
    }

    /**
     * @test
     */
    public function setShowResultLinkForBooleanSetsShowResultLink()
    {
        $this->subject->setShowResultLink(true);

        $this->assertAttributeEquals(
            true,
            'showResultLink',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getShowResultAfterVoteReturnsInitialValueForBoolean()
    {
        $this->assertSame(
            false,
            $this->subject->getShowResultAfterVote()
        );
    }

    /**
     * @test
     */
    public function setShowResultAfterVoteForBooleanSetsShowResultAfterVote()
    {
        $this->subject->setShowResultAfterVote(true);

        $this->assertAttributeEquals(
            true,
            'showResultAfterVote',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAllowMultipleVoteReturnsInitialValueForBoolean()
    {
        $this->assertSame(
            false,
            $this->subject->getAllowMultipleVote()
        );
    }

    /**
     * @test
     */
    public function setAllowMultipleVoteForBooleanSetsAllowMultipleVote()
    {
        $this->subject->setAllowMultipleVote(true);

        $this->assertAttributeEquals(
            true,
            'allowMultipleVote',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnswersReturnsInitialValueForAnswer()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->subject->getAnswers()
        );
    }

    /**
     * @test
     */
    public function setAnswersForObjectStorageContainingAnswerSetsAnswers()
    {
        $answer = new \Pixelink\Simplepoll\Domain\Model\Answer();
        $objectStorageHoldingExactlyOneAnswers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAnswers->attach($answer);
        $this->subject->setAnswers($objectStorageHoldingExactlyOneAnswers);

        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOneAnswers,
            'answers',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAnswerToObjectStorageHoldingAnswers()
    {
        $answer = new \Pixelink\Simplepoll\Domain\Model\Answer();
        $answersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', false);
        $answersObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($answer));
        $this->inject($this->subject, 'answers', $answersObjectStorageMock);

        $this->subject->addAnswer($answer);
    }

    /**
     * @test
     */
    public function removeAnswerFromObjectStorageHoldingAnswers()
    {
        $answer = new \Pixelink\Simplepoll\Domain\Model\Answer();
        $answersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', false);
        $answersObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($answer));
        $this->inject($this->subject, 'answers', $answersObjectStorageMock);

        $this->subject->removeAnswer($answer);
    }

    /**
     * @test
     */
    public function getIpLocksReturnsInitialValueForIpLock()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->subject->getIpLocks()
        );
    }

    /**
     * @test
     */
    public function setIpLocksForObjectStorageContainingIpLockSetsIpLocks()
    {
        $ipLock = new \Pixelink\Simplepoll\Domain\Model\IpLock();
        $objectStorageHoldingExactlyOneIpLocks = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneIpLocks->attach($ipLock);
        $this->subject->setIpLocks($objectStorageHoldingExactlyOneIpLocks);

        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOneIpLocks,
            'ipLocks',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addIpLockToObjectStorageHoldingIpLocks()
    {
        $ipLock = new \Pixelink\Simplepoll\Domain\Model\IpLock();
        $ipLocksObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', false);
        $ipLocksObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($ipLock));
        $this->inject($this->subject, 'ipLocks', $ipLocksObjectStorageMock);

        $this->subject->addIpLock($ipLock);
    }

    /**
     * @test
     */
    public function removeIpLockFromObjectStorageHoldingIpLocks()
    {
        $ipLock = new \Pixelink\Simplepoll\Domain\Model\IpLock();
        $ipLocksObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', false);
        $ipLocksObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($ipLock));
        $this->inject($this->subject, 'ipLocks', $ipLocksObjectStorageMock);

        $this->subject->removeIpLock($ipLock);
    }
}
