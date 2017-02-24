<?php
namespace DrdPlus\Skills\Physical;

use DrdPlus\Codes\Skills\PhysicalSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Swimming extends PhysicalSkill
{
    const SWIMMING = PhysicalSkillCode::SWIMMING;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::SWIMMING;
    }
}