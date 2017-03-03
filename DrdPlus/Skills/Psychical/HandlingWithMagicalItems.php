<?php
namespace DrdPlus\Skills\Psychical;

use DrdPlus\Codes\Skills\PsychicalSkillCode;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Skills\WithBonusToIntelligence;

/**
 * @ORM\Entity()
 */
class HandlingWithMagicalItems extends PsychicalSkill implements WithBonusToIntelligence
{
    const HANDLING_WITH_MAGICAL_ITEMS = PsychicalSkillCode::HANDLING_WITH_MAGICAL_ITEMS;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::HANDLING_WITH_MAGICAL_ITEMS;
    }

    /**
     * @return int
     */
    public function getBonusToIntelligence(): int
    {
        return 3 * $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return bool
     */
    public function automaticallyRecognizesSameMagicalItemInvestigatedBefore(): bool
    {
        return $this->getCurrentSkillRank()->getValue() >= 2;
    }

    /**
     * @return bool
     */
    public function automaticallyRecognizesCategoryOfMagicalItemInvestigatedBefore(): bool
    {
        return $this->getCurrentSkillRank()->getValue() >= 3;
    }

}