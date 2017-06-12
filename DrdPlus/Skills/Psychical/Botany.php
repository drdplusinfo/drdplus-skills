<?php
namespace DrdPlus\Skills\Psychical;

use DrdPlus\Codes\Skills\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Skills\WithBonusToIntelligence;

/**
 * @link https://pph.drdplus.info/#botanika
 * @ORM\Entity()
 */
class Botany extends PsychicalSkill implements WithBonusToIntelligence
{
    const BOTANY = PsychicalSkillCode::BOTANY;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::BOTANY;
    }

    /**
     * @return int
     */
    public function getBonusToIntelligence(): int
    {
        return 3 * $this->getCurrentSkillRank()->getValue();
    }
}