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

    public function __construct()
    {
        $this->score = 0;
        $this->isSpare = false;
        $this->lastPin = 0;
    }

    /**
     * @param  int    $pin [description]
     * @return [type]      [description]
     */
    public function recordShot(int $pin)
    {
        ++$this->shotNo;

        $this->score += $pin;

        /**
         * スペアの場合、もう一度ピンの数を足して
         * フラグを下げる
         */
        if ($this->isSpare) {
            $this->score += $pin;
            $this->isSpare = false;
        }

        /**
         * 2投目のときにスペアかどうか判定
         * 10点とったらフラグを立てる
         */
        if ($this->shotNo === 2 && $pin + $this->lastPin === 10) {
            $this->isSpare = true;
        }

        $this->lastPin = $pin;
    }

    /**
     * @return int [description]
     */
    public function calculateScore()
    {
        return $this->score;
    }
}
