<?php
namespace DrdPlus\Skills\Physical;


/**
 * @link https://pph.drdplus.info/#boj_se_zbrani
 * @Doctrine\ORM\Mapping\Entity()
 */
class FightWithKnivesAndDaggers extends FightWithWeaponsUsingPhysicalSkill
{
    public const FIGHT_WITH_KNIVES_AND_DAGGERS = 'fight_with_knives_and_daggers';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIGHT_WITH_KNIVES_AND_DAGGERS;
    }

}