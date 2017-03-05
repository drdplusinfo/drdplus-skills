<?php
namespace DrdPlus\Skills\Combined\RollsOn;

use Drd\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\RollsOn\QualityAndSuccess\RollOnQuality;
use DrdPlus\Skills\Combined\Painting;

/**
 * @method Roll2d6DrdPlus getRoll()
 */
class PaintingQuality extends RollOnQuality
{
    /**
     * @param Knack $knack
     * @param Painting $painting
     * @param Roll2d6DrdPlus $roll2D6DrdPlus
     */
    public function __construct(
        Knack $knack,
        Painting $painting,
        Roll2d6DrdPlus $roll2D6DrdPlus
    )
    {
        parent::__construct($knack->getValue() + $painting->getBonus(), $roll2D6DrdPlus);
    }
}