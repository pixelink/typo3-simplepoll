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

use Pixelink\Simplepoll\Domain\Model\SimplePoll;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for SimplePolls
 */
class IpLockRepository extends Repository
{
    /**
     * @param SimplePoll $simplePoll
     * @param $userIp
     *
     * @return object
     */
    public function getIpInPoll(SimplePoll $simplePoll, $userIp): object
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->equals('simplepoll', $simplePoll->getUid()),
                $query->equals('address', $userIp)
            )
        );

        return $query->execute()->getFirst();
    }


}






















































