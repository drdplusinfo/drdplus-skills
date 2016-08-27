<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Showmanship extends CombinedSkill
{
    const SHOWMANSHIP = CombinedSkillCode::SHOWMANSHIP;

    /**
     * @return string
     */
    public function getName()
    {
        return self::SHOWMANSHIP;
    }
}
