<?php
use PHPUnit\Framework\TestCase;
use App\BowlingGame;

class BowlingGameTest extends TestCase
{

    public $BowlingGame;

    public function setUp()
    {
    }

    public function tearDown()
    {
        unset($this->BowlingGame);
    }

    public function testCreateInstance()
    {
        $this->BowlingGame = new BowlingGame();
    }
}
