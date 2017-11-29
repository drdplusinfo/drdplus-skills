<?php
namespace DrdPlus\Skills\Physical\RollsOnQuality;

use DrdPlus\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\RollsOn\QualityAndSuccess\RollOnQuality;
use DrdPlus\Skills\Physical\Blacksmithing;

/**
 * See PPH page 146 right column top, @link https://pph.drdplus.info/#hod_na_kovarstvi
 * @method Roll2d6DrdPlus getRoll()
 */
class BlacksmithingQuality extends RollOnQuality
{
    /**
     * @param Knack $knack
     * @param Blacksmithing $blacksmithing
     * @param Roll2d6DrdPlus $roll2D6DrdPlus
     */
    public function __construct(Knack $knack, Blacksmithing $blacksmithing, Roll2d6DrdPlus $roll2D6DrdPlus)
    {
        parent::__construct($knack->getValue() + $blacksmithing->getBonusToKnack(), $roll2D6DrdPlus);
    }
}