<?php
namespace DrdPlus\Skills\Combined\RollsOnQuality\HandworkRollOnSuccess;

use DrdPlus\Skills\Combined\RollsOnQuality\HandworkQuality;

class HandworkSimpleRollOnGreatSuccess extends HandworkSimpleRollOnSuccess
{
    const BRAVURA = 'bravura';

    /**
     * @param HandworkQuality $handworkQuality
     * @param int $difficultyModification
     */
    public function __construct(HandworkQuality $handworkQuality, int $difficultyModification)
    {
        parent::__construct(
            20,
            $difficultyModification,
            $handworkQuality,
            self::BRAVURA,
            HandworkSimpleRollOnModerateSuccess::HANDY
        );
    }

}