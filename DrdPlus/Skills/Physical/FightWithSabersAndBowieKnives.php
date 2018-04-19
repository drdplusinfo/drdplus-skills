<?php
namespace DrdPlus\Skills\Physical;


/**
 * @link https://pph.drdplus.info/#boj_se_zbrani
 * @Doctrine\ORM\Mapping\Entity()
 */
class FightWithSabersAndBowieKnives extends FightWithWeaponsUsingPhysicalSkill
{
    public const FIGHT_WITH_SABERS_AND_BOWIE_KNIVES = 'fight_with_sabers_and_bowie_knives';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIGHT_WITH_SABERS_AND_BOWIE_KNIVES;
    }

}