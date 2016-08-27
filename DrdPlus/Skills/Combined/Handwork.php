<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Handwork extends CombinedSkill
{
    const HANDWORK = CombinedSkillCode::HANDWORK;

    /**
     * @return string
     */
    public function getName()
    {
        return self::HANDWORK;
    }

}
