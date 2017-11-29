<?php
namespace DrdPlus\Skills\Physical;


/**
 * @link https://pph.drdplus.info/#boj_se_zbrani
 * @Doctrine\ORM\Mapping\Entity()
 */
class FightWithVoulgesAndTridents extends FightWithWeaponsUsingPhysicalSkill
{
    public const FIGHT_WITH_VOULGES_AND_TRIDENTS = 'fight_with_voulges_and_tridents';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIGHT_WITH_VOULGES_AND_TRIDENTS;
    }

}