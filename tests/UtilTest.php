<?php
/**
 * @filesource   UtilTest.php
 * @created      08.02.2016
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\QRCodeTest;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Data\QRDataInterface;
use chillerlan\QRCode\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase{

	/**
	 * @var \chillerlan\QRCode\Util
	 */
	protected $util;

	public function setUp(){
		$this->util = new Util;
	}

	public function testIsNumber(){
		$this->assertEquals(true, $this->util->isNumber('1234567890'));
		$this->assertEquals(false, $this->util->isNumber('abc'));
	}

	public function testIsAlphaNum(){
		$this->assertEquals(true, $this->util->isAlphaNum('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 $%*+-./:'));
		$this->assertEquals(false, $this->util->isAlphaNum('#'));
	}

	// http://stackoverflow.com/a/24755772
	public function testIsKanji(){
		$this->assertEquals(true,  $this->util->isKanji('茗荷'));
		$this->assertEquals(false, $this->util->isKanji(''));
		$this->assertEquals(false, $this->util->isKanji('ÃÃÃ')); // non-kanji
		$this->assertEquals(false, $this->util->isKanji('荷')); // kanji forced into byte mode due to length
	}

	// coverage
	public function testGetBCHTypeNumber(){
		$this->assertEquals(7973, $this->util->getBCHTypeNumber(1));
	}

	/**
	 * @expectedException \chillerlan\QRCode\QRCodeException
	 * @expectedExceptionMessage $typeNumber: 1 / $errorCorrectLevel: 42
	 */
	public function testGetRSBlocksException(){
		$this->util->getRSBlocks(1, 42);
	}

	/**
	 * @expectedException \chillerlan\QRCode\QRCodeException
	 * @expectedExceptionMessage Invalid error correct level: 42
	 */
	public function testGetMaxLengthECLevelException(){
		$this->util->getMaxLength(QRCode::TYPE_01, QRDataInterface::MODE_BYTE, 42);
	}

	/**
	 * @expectedException \chillerlan\QRCode\QRCodeException
	 * @expectedExceptionMessage Invalid mode: 1337
	 */
	public function testGetMaxLengthModeException(){
		$this->util->getMaxLength(QRCode::TYPE_01, 1337, QRCode::ERROR_CORRECT_LEVEL_H);
	}

}
