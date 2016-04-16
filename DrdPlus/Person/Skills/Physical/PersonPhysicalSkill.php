<?php
namespace DrdPlus\Person\Skills\Physical;

use Doctrine\Common\Collections\ArrayCollection;
use DrdPlus\Person\Skills\PersonSkill;
use DrdPlus\Person\Skills\PersonSkillRank;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Strength;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="skillName", type="string")
 * @ORM\DiscriminatorMap({
 *  "armorWearing" = "ArmorWearing",
 *  "athletics" = "Athletics",
 *  "blacksmithing" = "Blacksmithing",
 *  "boatDriving" = "BoatDriving",
 *  "cartDriving" = "CartDriving",
 *  "cityMoving" = "CityMoving",
 *  "climbingAndHillwalking" = "ClimbingAndHillwalking",
 *  "fastMarsh" = "FastMarsh",
 *  "fightWithWeapon" = "FightWithWeapon",
 *  "flying" = "Flying",
 *  "forestMoving" = "ForestMoving",
 *  "movingInMountains" = "MovingInMountains",
 *  "riding" = "Riding",
 *  "sailing" = "Sailing",
 *  "shieldUsage" = "ShieldUsage",
 *  "swimming" = "Swimming",
 * })
 */
abstract class PersonPhysicalSkill extends PersonSkill
{

    /**
     * @var PhysicalSkillRank[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="PhysicalSkillRank", mappedBy="personPhysicalSkill", cascade={"persist"})
     */
    private $physicalSkillRanks;

    public function __construct()
    {
        $this->physicalSkillRanks = new ArrayCollection();
    }

    /**
     * @param PhysicalSkillRank|PersonSkillRank $physicalSkillRank
     * @throws \DrdPlus\Person\Skills\Physical\Exceptions\InvalidSkillRankType
     */
    public function addSkillRank(PersonSkillRank $physicalSkillRank)
    {
        if (!$physicalSkillRank instanceof PhysicalSkillRank) {
            throw new Exceptions\InvalidSkillRankType(
                'Expected ' . PhysicalSkillRank::class . ', got ' . get_class($physicalSkillRank)
            );
        }
        parent::addSkillRank($physicalSkillRank);
    }

    /**
     * @return ArrayCollection|PhysicalSkillRank[]
     */
    public function getSkillRanks()
    {
        return $this->physicalSkillRanks;
    }

    /**
     * @return string[]
     */
    public function getRelatedPropertyCodes()
    {
        return [Strength::STRENGTH, Agility::AGILITY];
    }

    /**
     * @return bool
     */
    public function isPhysical()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isPsychical()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isCombined()
    {
        return false;
    }

}
