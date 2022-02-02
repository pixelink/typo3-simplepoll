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

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * Stores the IPs of the voters with the timestamp of the vote
 */
class IpLock extends AbstractValueObject
{
	/**
	 * the IP of the voter
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $address = '';

	/**
	 * timestamp
	 *
	 * @var \DateTime
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $timestamp = null;

	/**
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress(): string
    {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
     *
	 * @return void
	 */
	public function setAddress($address): void
    {
		$this->address = $address;
	}

	/**
	 * Returns the timestamp
	 *
	 * @return \DateTime $timestamp
	 */
	public function getTimestamp(): ?\DateTime
    {
		return $this->timestamp;
	}

	/**
	 * Sets the timestamp
	 *
	 * @param \DateTime $timestamp
     *
	 * @return void
	 */
	public function setTimestamp(\DateTime $timestamp = null): void
    {
		$this->timestamp = $timestamp;
	}
}
