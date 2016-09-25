<?php
use PHPUnit\Framework\TestCase;
use App\BowlingGame;

class BowlingGameTest extends TestCase
{

    public $BowlingGame;

    public function setUp()
    {
        $this->BowlingGame = new BowlingGame();
    }

    public function tearDown()
    {
        unset($this->BowlingGame);
    }

    /**
     * 全投球がガーター
     */
    public function testAllGarter()
    {
        $this->BowlingGame = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $this->BowlingGame->recordShot(0);
        }

        $this->assertTrue(0 === $this->BowlingGame->calculateScore());
    }
}
