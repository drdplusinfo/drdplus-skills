<?php
namespace DrdPlus\Skills\Psychical;
use DrdPlus\Codes\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class Technology extends PsychicalSkill
{
    const TECHNOLOGY = PsychicalSkillCode::TECHNOLOGY;

    /**
     * @return string
     */
    public function getName()
    {
        return self::TECHNOLOGY;
    }
}
