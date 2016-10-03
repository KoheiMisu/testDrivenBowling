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
    public function 全ての投球がガーター()
    {
        $this->Flame->recordShot(0);
        $this->Flame->recordShot(0);

        $this->assertEquals(0, $this->Flame->getScore());
    }

    /**
     * @test
     */
    public function 全ての投球で1ピン倒した()
    {
        $this->Flame->recordShot(1);
        $this->Flame->recordShot(1);

        $this->assertEquals(2, $this->Flame->getScore());
    }
}