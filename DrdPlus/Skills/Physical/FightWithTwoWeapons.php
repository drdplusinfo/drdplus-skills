<?php
namespace DrdPlus\Skills\Physical;


/**
 * @link https://pph.drdplus.info/#boj_se_zbrani
 * @Doctrine\ORM\Mapping\Entity()
 */
class FightWithTwoWeapons extends FightWithWeaponsUsingPhysicalSkill
{
    public const FIGHT_WITH_TWO_WEAPONS = 'fight_with_two_weapons';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIGHT_WITH_TWO_WEAPONS;
    }

}