<?php

namespace App;

class Flame
{
    /** @var  int */
    private $score;

    /**
     * @param int $pin
     */
    public function recordShot(int $pin)
    {
        $this->score += $pin;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

}