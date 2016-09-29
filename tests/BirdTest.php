<?php

use PHPUnit\Framework\TestCase;
use App\Bird;

class BowlingGameTest extends TestCase
{
    /** @var Bird **/
    public $Bird;

    public function testFly()
    {
        $this->Bird = new Bird();
        $this->assertTrue('flyAway' === $this->Bird->fly());
    }

}
