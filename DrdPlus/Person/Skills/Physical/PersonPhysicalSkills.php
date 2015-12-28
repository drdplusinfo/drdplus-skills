<?php
namespace DrdPlus\Person\Skills\Physical;

use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Skills\PersonSameTypeSkills;

/**
 * PhysicalSkills
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class PersonPhysicalSkills extends PersonSameTypeSkills
{
    const PHYSICAL = SkillCodes::PHYSICAL;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @var ArmorWearing|null
     * @ORM\OneToOne(targetEntity="ArmorWearing")
     */
    private $armorWearing;
    /** @var Athletics|null
     * @ORM\OneToOne(targetEntity="Athletics")
     */
    private $athletics;
    /** @var Blacksmithing|null
     * @ORM\OneToOne(targetEntity="Blacksmithing")
     */
    private $blacksmithing;
    /** @var BoatDriving|null
     * @ORM\OneToOne(targetEntity="BoatDriving")
     */
    private $boatDriving;
    /** @var CartDriving|null
     * @ORM\OneToOne(targetEntity="CartDriving")
     */
    private $cartDriving;
    /** @var CityMoving|null
     * @ORM\OneToOne(targetEntity="CityMoving")
     */
    private $cityMoving;
    /** @var ClimbingAndHillwalking|null
     * @ORM\OneToOne(targetEntity="ClimbingAndHillwalking")
     */
    private $climbingAndHillwalking;
    /** @var FastMarsh|null
     * @ORM\OneToOne(targetEntity="FastMarsh")
     */
    private $fastMarsh;
    /** @var FightWithWeapon|null
     * @ORM\OneToOne(targetEntity="FightWithWeapon")
     */
    private $fightWithWeapon;
    /** @var Flying|null
     * @ORM\OneToOne(targetEntity="Flying")
     */
    private $flying;
    /** @var ForestMoving|null
     * @ORM\OneToOne(targetEntity="ForestMoving")
     */
    private $forestMoving;
    /** @var MovingInMountains|null
     * @ORM\OneToOne(targetEntity="MovingInMountains")
     */
    private $movingInMountain;
    /** @var Riding|null
     * @ORM\OneToOne(targetEntity="Riding")
     */
    private $riding;
    /** @var Sailing|null
     * @ORM\OneToOne(targetEntity="Sailing")
     */
    private $sailing;
    /** @var ShieldUsage|null
     * @ORM\OneToOne(targetEntity="ShieldUsage")
     */
    private $shieldUsage;
    /** @var Swimming|null
     * @ORM\OneToOne(targetEntity="Swimming")
     */
    private $swimming;

    protected function createSkillsIterator()
    {
        return new \ArrayIterator(
            array_filter([
                $this->getArmorWearing(),
                $this->getAthletics(),
                $this->getBlacksmithing(),
                $this->getBoatDriving(),
                $this->getCartDriving(),
                $this->getCityMoving(),
                $this->getClimbingAndHillwalking(),
                $this->getFastMarsh(),
                $this->getFightWithWeapon(),
                $this->getFlying(),
                $this->getForestMoving(),
                $this->getMovingInMountains(),
                $this->getRiding(),
                $this->getSailing(),
                $this->getShieldUsage(),
                $this->getSwimming(),
            ])
        );
    }

    /**
     * @return string
     */
    public function getSkillsGroupName()
    {
        self::PHYSICAL;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArmorWearing|null
     */
    public function getArmorWearing()
    {
        return $this->armorWearing;
    }

    /**
     * @return Athletics|null
     */
    public function getAthletics()
    {
        return $this->athletics;
    }

    /**
     * @return Blacksmithing|null
     */
    public function getBlacksmithing()
    {
        return $this->blacksmithing;
    }

    /**
     * @return BoatDriving|null
     */
    public function getBoatDriving()
    {
        return $this->boatDriving;
    }

    /**
     * @return CartDriving|null
     */
    public function getCartDriving()
    {
        return $this->cartDriving;
    }

    /**
     * @return CityMoving|null
     */
    public function getCityMoving()
    {
        return $this->cityMoving;
    }

    /**
     * @return ClimbingAndHillwalking|null
     */
    public function getClimbingAndHillwalking()
    {
        return $this->climbingAndHillwalking;
    }

    /**
     * @return FastMarsh|null
     */
    public function getFastMarsh()
    {
        return $this->fastMarsh;
    }

    /**
     * @return FightWithWeapon|null
     */
    public function getFightWithWeapon()
    {
        return $this->fightWithWeapon;
    }

    /**
     * @return Flying|null
     */
    public function getFlying()
    {
        return $this->flying;
    }

    /**
     * @return ForestMoving|null
     */
    public function getForestMoving()
    {
        return $this->forestMoving;
    }

    /**
     * @return MovingInMountains|null
     */
    public function getMovingInMountains()
    {
        return $this->movingInMountain;
    }

    /**
     * @return Riding|null
     */
    public function getRiding()
    {
        return $this->riding;
    }

    /**
     * @return Sailing|null
     */
    public function getSailing()
    {
        return $this->sailing;
    }

    /**
     * @return ShieldUsage|null
     */
    public function getShieldUsage()
    {
        return $this->shieldUsage;
    }

    /**
     * @return Swimming|null
     */
    public function getSwimming()
    {
        return $this->swimming;
    }
}