<?php
use PHPUnit\Framework\TestCase;
use App\Flame;

class FlameTest extends TestCase
{
    /** @var Flame */
    public $Flame;

    public function setUp()
    {
        $this->Flame = new Flame();
    }

    public function tearDown()
    {
        unset($this->Flame);
    }

    /**
     * @test
     */
    public function _全ての投球がガーター()
    {
        $this->Flame->recordShot(0);
        $this->Flame->recordShot(0);

        $this->assertEquals(0, $this->Flame->getScore());
    }

    /**
     * @test
     */
    public function _全ての投球で1ピン倒した()
    {
        $this->Flame->recordShot(1);
        $this->Flame->recordShot(1);

        $this->assertEquals(2, $this->Flame->getScore());
    }

    /**
     * @test
     */
    public function _2投するとフレームは終了する()
    {
        $this->Flame->recordShot(1);
        $this->assertFalse($this->Flame->isFinished()); //2投目が可能
        $this->Flame->recordShot(1);
        $this->assertTrue($this->Flame->isFinished()); //2投したので完了
    }

    /**
     * @test
     */
    public function _10ピン倒した時点でフレームは終了する()
    {
        $this->Flame->recordShot(10);
        $this->assertTrue($this->Flame->isFinished()); //2投したので完了
    }

    /**
     * @test
     */
    public function _2投目で10ピン倒した場合はスペア()
    {
        $this->Flame->recordShot(5);
        $this->assertFalse($this->Flame->isSpare()); //1投目5ピンなのでスペアでない
        $this->Flame->recordShot(5);
        $this->assertTrue($this->Flame->isSpare()); //2投目合計10ピンなのでスペア
    }

    /**
     * @test
     */
    public function _1投目で10ピン倒した場合はストライク()
    {
        $this->Flame->isStrike(); //投球前はストライクではない
        $this->Flame->recordShot(10);
        $this->assertTrue($this->Flame->isStrike()); //1投目で10ピン倒したのでストライク
    }

    /**
     * @test
     */
    public function _スペア時のボーナス点加算()
    {
        $this->Flame->recordShot(5);
        $this->Flame->recordShot(5);
        $this->Flame->addBonus(5);
        $this->assertEquals(15, $this->Flame->getScore());
    }

    /**
     * @test
     */
    public function _オープンフレームにボーナスは不要()
    {

    }
}