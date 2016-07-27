<?php
namespace DrdPlus\Person\Skills\Physical;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class FightWithVoulgesAndTridents extends FightWithWeaponUsingPhysicalSkill
{
    const FIGHT_WITH_VOULGES_AND_TRIDENTS = 'fight_with_voulges_and_tridents';

    /**
     * @return string
     */
    public function getName()
    {
        return self::FIGHT_WITH_VOULGES_AND_TRIDENTS;
    }

}