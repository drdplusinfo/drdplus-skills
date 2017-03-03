<?php
namespace DrdPlus\Skills\Psychical;

use DrdPlus\Codes\Skills\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Skills\WithBonusToIntelligence;

/**
 * @ORM\Entity()
 */
class Zoology extends PsychicalSkill implements WithBonusToIntelligence
{
    const ZOOLOGY = PsychicalSkillCode::ZOOLOGY;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::ZOOLOGY;
    }

    /**
     * @return int
     */
    public function getBonusToIntelligence(): int
    {
        return 3 * $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusToAttackNumberAgainstNaturalAnimal(): int
    {
        return $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusToCoverAgainstNaturalAnimal(): int
    {
        return $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusToBaseOfWoundsAgainstNaturalAnimal(): int
    {
        return $this->getCurrentSkillRank()->getValue();
    }
}