<?php

namespace App;

use App¥Flame;

class BowlingGame
{
    /** @var int **/
    private $strikeBonusCount;

    /** @var int **/
    private $doubleBonusCount;

    /** @var array */
    private $Flames;

    /** @var  int スペアのフレームを記録 */
    private $spareFlameNo;

    /** @var  int ストライクのフレームを記録 */
    private $strikeFlameNo;

    /** @var  int ダブルストライクのフレームを記録 */
    private $strikeDoubleFlameNo;

    public function __construct()
    {
        $this->score = 0;
        $this->strikeBonusCount = 0;
        $this->doubleBonusCount = 0;
        $this->Flames[] = new Flame(); // まずはフレーム一つだけでインスタンス作成
    }

    /**
     * ボーリングの1投球の計算を実行させる
     *
     * @param int    $pin [description]
     * @return void
     */
    public function recordShot(int $pin)
    {
        //配列の一番最後が現在のフレーム
        $this->Flames[count($this->Flames)-1]->recordShot($pin);

        $this->calculateSpare($pin);

        $this->calculateStrikeBonus($pin);

        $this->calculateDoubleBonus($pin);

        $this->setBonusParam();

        //フレームが完了したら新しいフレームを配列に追加
        if ($this->Flames[count($this->Flames)-1]->isFinished()) {
            $this->Flames[] = new Flame();
        }
    }

    /**
     * スペアの場合、もう一度ピンの数を足して
     * フラグを下げる
     * @param int $pin
     * @return void [description]
     */
    private function calculateSpare(int $pin)
    {
        if (isset($this->spareFlameNo) && $this->Flames[$this->spareFlameNo]->needBonus()) {
            //スペアのボーナスをフレーム側に加算
            $this->Flames[$this->spareFlameNo]->addBonus($pin);
            $this->spareFlameNo = null;
        }
    }

    /**
     * ストライク時の得点計算
     * @param  int    $pin [description]
     * @return void      [description]
     */
    private function calculateStrikeBonus(int $pin)
    {
        if ($this->strikeBonusCount > 0) {
            $this->Flames[$this->strikeFlameNo]->addBonus($pin);
            --$this->strikeBonusCount;
        }
    }

    /**
     * ダブル時の得点計算
     * @param  int    $pin [description]
     * @return void      [description]
     */
    private function calculateDoubleBonus(int $pin)
    {
        if ($this->doubleBonusCount > 0) {

            //ダブルの一投目は二つ前のフレームに送る
            if ($this->doubleBonusCount === 2) {
                $this->Flames[$this->strikeDoubleFlameNo-1]->addBonus($pin);
            } else {
                $this->Flames[$this->strikeDoubleFlameNo]->addBonus($pin);
            }

            --$this->doubleBonusCount;

        }
    }

    /**
     * ストライク時にボーナス管理の変数をセット
     * @return void      [description]
     */
    private function isStrike()
    {
        if ($this->Flames[count($this->Flames)-1]->isStrike()) {

            $this->strikeFlameNo = count($this->Flames)-1;

            if ($this->strikeBonusCount !== 0) {
                $this->strikeDoubleFlameNo = count($this->Flames)-1;
                $this->doubleBonusCount = 2;
            }

            if ($this->strikeBonusCount === 0) {
                $this->strikeBonusCount = 2;
            }
        }
    }

    /**
     * 2投目のときにスペアかどうか判定
     * 10点とったらフラグを立てる
     *
     * @return void      [description]
     */
    private function isSpare()
    {
        if ($this->Flames[count($this->Flames)-1]->isSpare()) {
            //スペアをとったフレーム番号を記憶
            $this->spareFlameNo = count($this->Flames)-1;
        }
    }

    /**
     * 今回の投球がボーナス回として次の投球に影響するか判定
     * @return void
     */
    private function setBonusParam()
    {
        $this->isSpare();
        $this->isStrike();
    }

    /**
     * @return int [description]
     */
    public function calculateScore(): int
    {
        $total = 0;
        foreach ($this->Flames as $Flame) {
            $total += $Flame->getScore();
        }

        return $total;
    }

    /**
     * @param int
     * @return int
     */
    public function flameScore(int $flameNo): int
    {
        return $this->Flames[$flameNo]->getScore($flameNo);
    }

}
