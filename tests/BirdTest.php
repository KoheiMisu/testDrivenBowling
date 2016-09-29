<?php

use PHPUnit\Framework\TestCase;
use App\Bird;

class BowlingGameTest extends TestCase
{
    /** @var Bird **/
    public $Bird;

    public function setUp()
    {
        $this->Bird = new Bird();
    }

    public function tearDown()
    {
        unset($this->Bird);
    }

    public function testFly()
    {
        $this->assertTrue('flyAway' === $this->Bird->fly());
    }

    public function testHp()
    {
        $this->Bird->fly();
        $this->Bird->fly();

        $this->assertEquals(8, $this->Bird->showHp());
    }

}
