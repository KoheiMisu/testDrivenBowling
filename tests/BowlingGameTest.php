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
        $this->loopRecordShot(20, 0);

        $this->assertTrue(0 === $this->BowlingGame->calculateScore());
    }

    /**
     * 全投球で 1 ピンのみ倒す
     */
    public function testKnockedDownAllOne()
    {
        $this->loopRecordShot(20, 1);

        $this->assertEquals(20, $this->BowlingGame->calculateScore());
    }

    /**
     * スペア時の計算
     *
     * 1投目: 3
     * 2投目: 7  //スペア
     * 3投目: 4
     *
     * 4投目以降、ガター
     *
     *
     * @return [type] [description]
     */
    public function testSpareCase()
    {
        $this->BowlingGame->recordShot(3);
        $this->BowlingGame->recordShot(7);
        /** ↑ スペア **/

        $this->BowlingGame->recordShot(4);
        $this->loopRecordShot(17, 0);

        $this->assertEquals(18, $this->BowlingGame->calculateScore());
    }

    /**
     * 直前の投球との合計が10だった場合に
     * スペアではないと判断しているか
     *
     * 1投目: 2
     * 2投目: 5
     * 3投目: 5 //スペア ??
     * 3投目: 8
     *
     * @return [type] [description]
     */
    public function testSpareCaseAtDifferentFlame()
    {
        $this->BowlingGame->recordShot(2);
        $this->BowlingGame->recordShot(5);
        $this->BowlingGame->recordShot(5);
        $this->BowlingGame->recordShot(8);

        $this->loopRecordShot(16, 0);

        $this->assertEquals(20, $this->BowlingGame->calculateScore());
    }


    /**
　　  * @param  int    $loop [description]
　　  * @param  int    $pin  [description]
　　  * @return void       [description]
　　  */
    private function loopRecordShot(int $loop, int $pin)
    {
        for ($i = 0; $i < $loop; $i++) {
            $this->BowlingGame->recordShot($pin);
        }
    }
}
