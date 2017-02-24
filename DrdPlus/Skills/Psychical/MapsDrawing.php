<?php
namespace DrdPlus\Skills\Psychical;
use DrdPlus\Codes\Skills\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class MapsDrawing extends PsychicalSkill
{
    const MAPS_DRAWING = PsychicalSkillCode::MAPS_DRAWING;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::MAPS_DRAWING;
    }
}