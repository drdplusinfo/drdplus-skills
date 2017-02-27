<?php
namespace DrdPlus\Skills\Physical;

use DrdPlus\Codes\Skills\PhysicalSkillCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CartDriving extends PhysicalSkill
{
    const CART_DRIVING = PhysicalSkillCode::CART_DRIVING;

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