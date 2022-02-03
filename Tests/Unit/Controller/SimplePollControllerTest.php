<?php
declare(strict_types = 1);

namespace Pixelink\Simplepoll\Tests\Unit\Controller;

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
 * Test case for class Pixelink\Simplepoll\Controller\SimplePollController.
 *
 * @author Alex Bigott <support@pixel-ink.de>
 */
class SimplePollControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Pixelink\Simplepoll\Controller\SimplePollController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMock('Pixelink\\Simplepoll\\Controller\\SimplePollController', array('redirect', 'forward', 'addFlashMessage'), array(), '', false);
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllSimplePollsFromRepositoryAndAssignsThemToView()
    {

        $allSimplePolls = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', false);

        $simplePollRepository = $this->getMock('Pixelink\\Simplepoll\\Domain\\Repository\\SimplePollRepository', array('findAll'), array(), '', false);
        $simplePollRepository->expects($this->once())->method('findAll')->will($this->returnValue($allSimplePolls));
        $this->inject($this->subject, 'simplePollRepository', $simplePollRepository);

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->once())->method('assign')->with('simplePolls', $allSimplePolls);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
