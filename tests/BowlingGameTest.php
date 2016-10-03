<?php
use PHPUnit\Framework\TestCase;
use App\BowlingGame;

class BowlingGameTest extends TestCase
{
    /** @var BowlingGame  */
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
     * 4投目: 8
     *
     * 残りはガター
     *
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
     * 初球ストライクのケース
     *
     * 1投目: ストライク
     * 2投目: 3
     * 3投目: 3
     * 4投目: 1
     *
     * 残りガター
     *
     */
    public function testStrikeAtFirstFlame()
    {
        $this->BowlingGame->recordShot(10);
        $this->BowlingGame->recordShot(3);
        $this->BowlingGame->recordShot(3);
        $this->BowlingGame->recordShot(1);

        $this->loopRecordShot(15, 0);

        $this->assertEquals(23, $this->BowlingGame->calculateScore());
    }

    /**
     * 2球連続ストライクのケース
     *
     * 1投目: ストライク
     * 2投目: ストライク
     * 3投目: 3
     * 4投目: 1
     *
     * 残りガター
     *
     */
    public function testDoubleStrikeAtFirstFlame()
    {
        $this->BowlingGame->recordShot(10); //10+(10+3)
        $this->BowlingGame->recordShot(10); //10+(3+1)
        $this->BowlingGame->recordShot(3); //3
        $this->BowlingGame->recordShot(1); //1           [計41]

        $this->loopRecordShot(14, 0);

        $this->assertEquals(41, $this->BowlingGame->calculateScore());
    }

    /**
     * 3球連続ストライクのケース
     *
     * 1投目: ストライク
     * 2投目: ストライク
     * 3投目: ストライク
     * 4投目: 3
     * 5投目: 1
     *
     * 残りガター
     *
     */
    public function testTurkeyAtFirstFlame()
    {
        $this->BowlingGame->recordShot(10); //10+(10+10)
        $this->BowlingGame->recordShot(10); //10+(10+3)
        $this->BowlingGame->recordShot(10); //10+(3+1)
        $this->BowlingGame->recordShot(3); //3
        $this->BowlingGame->recordShot(1); //1           [計71]

        $this->loopRecordShot(12, 0);

        $this->assertEquals(71, $this->BowlingGame->calculateScore());
    }

    /**
     * ストライクとスペアが複合した場合のケース
     *
     * 1投目: ストライク
     * 2投目: 5
     * 3投目: 5 (スペア)
     * 4投目: 3
     *
     * 残りガター
     *
     */
    public function testStrikeAndSpare()
    {
        $this->BowlingGame->recordShot(10); //10+(5+5)
        $this->BowlingGame->recordShot(5); //5
        $this->BowlingGame->recordShot(5); //5+(3)
        $this->BowlingGame->recordShot(3); //3

        $this->loopRecordShot(15, 0);

        $this->assertEquals(36, $this->BowlingGame->calculateScore());
    }

    /**
     * ストライクとスペアが複合した場合のケース
     *
     * 1投目: ストライク
     * 2投目: ストライク
     * 3投目: 5
     * 4投目: 5 (スペア)
     * 5投目: 3
     *
     * 残りガター
     *
     */
    public function testDoubleStrikeAndSpare()
    {
        $this->BowlingGame->recordShot(10); //10+(10+5)
        $this->BowlingGame->recordShot(10); //10+(5+5)
        $this->BowlingGame->recordShot(5); //5
        $this->BowlingGame->recordShot(5); //5+(3)
        $this->BowlingGame->recordShot(3); //3

        $this->loopRecordShot(13, 0);

        $this->assertEquals(61, $this->BowlingGame->calculateScore());
    }

    /**
     * 全球ガーター時の1フレーム目の得点
     */
    public function testCalculateFrameScoreAtAllGarter()
    {
        $this->loopRecordShot(20, 0);

        $this->assertEquals(0, $this->BowlingGame->flameScore(1));
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
