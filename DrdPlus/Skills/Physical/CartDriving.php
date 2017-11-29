<?php
namespace DrdPlus\Skills\Physical;

use DrdPlus\Codes\Skills\PhysicalSkillCode;

/**
 * @link https://pph.drdplus.info/#rizeni_vozu
 * @Doctrine\ORM\Mapping\Entity()
 */
class CartDriving extends PhysicalSkill
{
    public const CART_DRIVING = PhysicalSkillCode::CART_DRIVING;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::CART_DRIVING;
    }

    /**
     * @return int
     */
    public function getMalusToMovementSpeed(): int
    {
        return -3 + $this->getCurrentSkillRank()->getValue();
    }
}