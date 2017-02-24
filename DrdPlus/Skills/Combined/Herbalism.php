<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\Skills\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Herbalism extends CombinedSkill
{
    const HERBALISM = CombinedSkillCode::HERBALISM;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::HERBALISM;
    }
}