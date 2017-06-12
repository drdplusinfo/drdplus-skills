<?php
namespace DrdPlus\Skills\Combined;

use DrdPlus\Codes\Skills\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @link https://pph.drdplus.info/#prvni_pomoc
 * @ORM\Entity()
 */
class FirstAid extends CombinedSkill
{
    const FIRST_AID = CombinedSkillCode::FIRST_AID;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::FIRST_AID;
    }

    /**
     * @return int
     */
    public function getMinimalWoundsLeftAfterFirstAidHeal(): int
    {
        $currentSkillRankValue = $this->getCurrentSkillRank()->getValue();
        if ($currentSkillRankValue === 0) {
            return 5;
        }

        return 4 - $currentSkillRankValue;
    }

    /**
     * @link https://pph.drdplus.info/#vypocet_vylecenych_bodu_zraneni
     * @return int negative
     */
    public function getHealingPowerToBasicWounds(): int
    {
        $currentSkillRankValue = $this->getCurrentSkillRank()->getValue();
        if ($currentSkillRankValue === 0) {
            return -20;
        }

        return (2 * $currentSkillRankValue) - 8; // results into negative integer
    }

    /**
     * @link https://pph.drdplus.info/#velikost_postizeni
     * @return int
     */
    public function getBleedingLoweringValue(): int
    {
        $value = 1 - $this->getCurrentSkillRank()->getValue();
        if ($value > -1) { // only 1- is accepted (that means only on skill rank 2+ can be bleeding lowered)
            return 0;
        }

        // lower is better
        return $value;
    }

    /**
     * @link https://pph.drdplus.info/#velikost_postizeni
     * @return int
     */
    public function getPoisonLoweringValue(): int
    {
        $value = 1 - $this->getCurrentSkillRank()->getValue();
        if ($value > -2) { // only 2- is accepted (that means only on skill rank 3 can be poison lowered)
            return 0;
        }

        // lower is better
        return $value;
    }
}