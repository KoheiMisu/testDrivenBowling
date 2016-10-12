<?php

namespace App;

class Flame
{
    /** @var  int */
    private $score=0;

    /** @var  int */
    private $shotCount=0;

    /** @var  int */
    private $bonus=0;

    /** @var  int */
    private $bonusCount=0;


    /**
     * @param int $pin
     */
    public function recordShot(int $pin)
    {
        $this->score += $pin;
        $this->shotCount += 1;
    }

    /**
     * @param int $pin
     */
    public function addBonus(int $pin)
    {
        $this->bonus += $pin;
        $this->bonusCount += 1;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score + $this->bonus;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        if ($this->score >= 10 || $this->shotCount > 1) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSpare(): bool
    {
        if ($this->score === 10 && $this->shotCount > 1) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isStrike(): bool
    {
        if ($this->score === 10 && $this->shotCount === 1) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function needBonus(): bool
    {
        if ($this->isSpare()) {
            return $this->bonusCount < 1;
        }

        if ($this->isStrike()) {
            return $this->bonusCount < 2;
        }

        return false;
    }

}