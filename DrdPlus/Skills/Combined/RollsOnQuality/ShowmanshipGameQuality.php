<?php
namespace DrdPlus\Skills\Combined\RollsOnQuality;

use DrdPlus\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\RollsOn\QualityAndSuccess\RollOnQuality;
use DrdPlus\Skills\Combined\Showmanship;

/**
 * See PPH page 153 left column, @link https://pph.drdplus.info/#vypocet_kvality_hry_pri_herectvi
 * @method Roll2d6DrdPlus getRoll()
 */
class ShowmanshipGameQuality extends RollOnQuality
{
    /**
     * @param Charisma $charisma
     * @param Showmanship $showmanship
     * @param Roll2d6DrdPlus $roll2D6DrdPlus
     */
    public function __construct(Charisma $charisma, Showmanship $showmanship, Roll2d6DrdPlus $roll2D6DrdPlus)
    {
        parent::__construct($charisma->getValue() + $showmanship->getBonus(), $roll2D6DrdPlus);
    }

}