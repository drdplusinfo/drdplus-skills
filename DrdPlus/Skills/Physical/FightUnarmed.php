<?php
namespace DrdPlus\Skills\Physical;


/**
 * @link https://pph.drdplus.info/#boj_se_zbrani
 * @Doctrine\ORM\Mapping\Entity()
 */
class FightUnarmed extends FightWithWeaponsUsingPhysicalSkill
{
    public const FIGHT_UNARMED = 'fight_unarmed';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIGHT_UNARMED;
    }

}