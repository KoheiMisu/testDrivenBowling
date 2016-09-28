<?php

namespace App;

class BowlingGame
{
    /** @var int **/
    private $score;

    /** @var int **/
    private $lastPin;

    /** @var bool **/
    private $isSpare;

    /** @var int **/
    private $shotNo;

    /** @var int **/
    private $strikeBonusCount;

    public function __construct()
    {
        $this->score = 0;
        $this->isSpare = false;
        $this->lastPin = 0;
        $this->shotNo = 0;
        $this->strikeBonusCount = 0;
    }

    /**
     * ボーリングの1投球の計算を実行させる
     *
     * @param  int    $pin [description]
     * @return [type]      [description]
     */
    public function recordShot(int $pin)
    {
        ++$this->shotNo;

        $this->score += $pin;

        $this->calculateSpare($pin);

        $this->calculateStrike($pin);

        $this->setBonusParam($pin);

        $this->lastPin = $pin;
    }

    /**
     * スペアの場合、もう一度ピンの数を足して
     * フラグを下げる
     * @param int $pin
     * @return void [description]
     */
    private function calculateSpare(int $pin)
    {
        if ($this->isSpare) {
            $this->score += $pin;
            $this->isSpare = false;
        }
    }

    /**
     * ストライク時の得点計算
     * @param  int    $pin [description]
     * @return void      [description]
     */
    private function calculateStrike(int $pin)
    {
        if ($this->strikeBonusCount > 0) {
            $this->score += $pin;
            --$this->strikeBonusCount;
        }
    }

    /**
     * ストライク時にボーナス管理の変数をセット
     * @param  int     $pin [description]
     * @return void      [description]
     */
    private function isStrike(int $pin)
    {
        if ($pin === 10) {
            $this->strikeBonusCount = 2;
        }
    }

    /**
     * 2投目のときにスペアかどうか判定
     * 10点とったらフラグを立てる
     *
     * @param  int     $pin [description]
     * @return void      [description]
     */
    private function isSpare(int $pin)
    {
        if ($this->shotNo === 2 && $pin + $this->lastPin === 10) {
            $this->isSpare = true;
        }
    }

    /**
     * 今回の投球がボーナス回として次の投球に影響するか判定
     * @param int $pin [description]
     * @return void
     */
    private function setBonusParam(int $pin)
    {
        $this->isSpare($pin);
        $this->isStrike($pin);
    }

    /**
     * @return int [description]
     */
    public function calculateScore(): int
    {
        return $this->score;
    }
}
