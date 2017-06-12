<?php
namespace DrdPlus\Skills\Physical;

use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Codes\Skills\PhysicalSkillCode;
use DrdPlus\Skills\WithBonus;
use Granam\Integer\PositiveInteger;

/**
 * @link https://pph.drdplus.info/#atletika
 * @ORM\Entity()
 */
class Athletics extends PhysicalSkill implements WithBonus, \DrdPlus\Properties\Derived\Athletics
{
    const ATHLETICS = PhysicalSkillCode::ATHLETICS;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::ATHLETICS;
    }

    /**
     * @return PhysicalSkillRank|PositiveInteger
     */
    public function getAthleticsBonus(): PositiveInteger
    {
        // bonus is equal to current rank (0 -> 3)
        return $this->getCurrentSkillRank();
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @link https://pph.drdplus.info/#vypocet_pohybove_rychlosti
     * @link https://pph.drdplus.info/#vypocet_delky_a_vysky_skoku
     * @return int
     */
    public function getBonusToSpeedOnRunSprintAndJump(): int
    {
        return $this->getBonus();
    }

    /**
     * @link https://pph.drdplus.info/#vypocet_zraneni_pri_padu
     * @return int
     */
    public function getBonusToAgilityOnFall(): int
    {
        return $this->getBonus();
    }

    /**
     * @link https://pph.drdplus.info/#vypocet_maximalniho_nakladu
     * @link https://pph.drdplus.info/#tabulka_unavy_za_nalozeni
     * @return int
     */
    public function getBonusToMaximalLoad(): int
    {
        return $this->getBonus();
    }

}