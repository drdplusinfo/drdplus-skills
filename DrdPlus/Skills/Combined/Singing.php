<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\Codes\Skills\CombinedSkillCode;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Skills\Combined\RollsOnQuality\SingingQuality;
use DrdPlus\Skills\WithBonus;

/**
 * @link https://pph.drdplus.info/#zpev
 * @Doctrine\ORM\Mapping\Entity()
 */
class Singing extends CombinedSkill implements WithBonus
{
    public const SINGING = CombinedSkillCode::SINGING;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::SINGING;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return $this->getCurrentSkillRank()->getValue() * 3;
    }

    /**
     * @return bool
     */
    public function canImitateBirdSong(): bool
    {
        return $this->getCurrentSkillRank()->getValue() >= 3;
    }

    /**
     * @param Knack $knack
     * @param Roll2d6DrdPlus $roll2D6DrdPlus
     * @return SingingQuality
     */
    public function createSingingQuality(Knack $knack, Roll2d6DrdPlus $roll2D6DrdPlus): SingingQuality
    {
        return new SingingQuality($knack, $this, $roll2D6DrdPlus);
    }
}