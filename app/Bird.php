<?php

namespace App;

class Bird
{
    /** int **/
    private $hp;

    public function __construct()
    {
        $this->hp = 10;
    }

    public function fly()
    {
        --$this->hp;

        return 'flyAway';
    }

    public function showHp()
    {
        return $this->hp;
    }

}
