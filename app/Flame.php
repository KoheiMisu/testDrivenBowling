<?php

namespace App;

class Flame
{
    /** @var  int */
    private $score=0;

    /** @var  int */
    private $shotCount=0;

    /**
     * @param int $pin
     */
    public function recordShot(int $pin)
    {
        $this->score += $pin;
        $this->shotCount += 1;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return boolean
     */
    public function isFinished()
    {
        if ($this->score >= 10 || $this->shotCount > 1) {
            return true;
        }

        return false;
    }

}