<?php
declare(strict_types = 1);

namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\Skills\CombinedSkillCode;
use DrdPlus\Skills\WithBonus;

/**
 * @link https://pph.drdplus.info/#zachazeni_se_zviraty
 * @Doctrine\ORM\Mapping\Entity()
 */
class HandlingWithAnimals extends CombinedSkill implements WithBonus
{
    public const HANDLING_WITH_ANIMALS = CombinedSkillCode::HANDLING_WITH_ANIMALS;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::HANDLING_WITH_ANIMALS;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return $this->getCurrentSkillRank()->getValue() * 2;
    }

    /**
     * @return bool
     */
    public function canSootheRunawayAnimal(): bool
    {
        return $this->getCurrentSkillRank()->getValue() >= 2;
    }
}