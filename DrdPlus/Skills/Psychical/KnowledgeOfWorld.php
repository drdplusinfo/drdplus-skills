<?php
namespace DrdPlus\Skills\Psychical;
use DrdPlus\Codes\Skills\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class KnowledgeOfWorld extends PsychicalSkill
{
    const KNOWLEDGE_OF_WORLD = PsychicalSkillCode::KNOWLEDGE_OF_WORLD;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::KNOWLEDGE_OF_WORLD;
    }
}