<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\Skills\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Singing extends CombinedSkill
{
    const SINGING = CombinedSkillCode::SINGING;

    /**
     * @return string
     */
    public function getName()
    {
        return self::SINGING;
    }
}