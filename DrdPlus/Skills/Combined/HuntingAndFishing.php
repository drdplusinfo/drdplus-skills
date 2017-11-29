<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\Skills\CombinedSkillCode;
use DrdPlus\HuntingAndFishing\WithBonusFromHuntingAndFishingSkill;
use DrdPlus\Skills\WithBonus;

/**
 * @link https://pph.drdplus.info/#lov_a_rybolov
 * @Doctrine\ORM\Mapping\Entity()
 */
class HuntingAndFishing extends CombinedSkill implements WithBonus, WithBonusFromHuntingAndFishingSkill
{
    public const HUNTING_AND_FISHING = CombinedSkillCode::HUNTING_AND_FISHING;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::HUNTING_AND_FISHING;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return 2 * $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusFromSkill(): int
    {
        return $this->getBonus();
    }

}