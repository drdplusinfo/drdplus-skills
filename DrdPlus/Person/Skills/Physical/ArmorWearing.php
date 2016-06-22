<?php
namespace DrdPlus\Person\Skills\Physical;

use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Codes\PhysicalSkillCode;

/**
 * @ORM\Entity()
 */
class ArmorWearing extends PersonPhysicalSkill
{
    const ARMOR_WEARING = PhysicalSkillCode::ARMOR_WEARING;

    /**
     * @return string
     */
    public function getName()
    {
        return self::ARMOR_WEARING;
    }
}
