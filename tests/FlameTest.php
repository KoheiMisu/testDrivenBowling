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
}