<?php
namespace DrdPlus\Skills;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrineum\Entity\Entity;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Skill extends StrictObject implements Entity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @param ProfessionLevel $professionLevel
     */
    protected function __construct(ProfessionLevel $professionLevel)
    {
        $this->getInnerSkillRanks()->add($this->createZeroSkillRank($professionLevel));
    }

    /**
     * @param SkillRank $personSkillRank
     * @throws \DrdPlus\Skills\Exceptions\UnexpectedRankValue
     * @throws \DrdPlus\Skills\Exceptions\CanNotVerifyOwningSkill
     */
    protected function addTypeVerifiedSkillRank(SkillRank $personSkillRank)
    {
        $this->guardSkillRankSequence($personSkillRank);
        $this->guardRelatedSkillOfRank($personSkillRank);
        $this->getInnerSkillRanks()->offsetSet($personSkillRank->getValue(), $personSkillRank);
    }

    /**
     * @param SkillRank $personSkillRank
     * @throws \DrdPlus\Skills\Exceptions\UnexpectedRankValue
     */
    private function guardSkillRankSequence(SkillRank $personSkillRank)
    {
        if (($this->getMaxSkillRankValue() + 1) !== $personSkillRank->getValue()) {
            throw new Exceptions\UnexpectedRankValue(
                'New skill rank has to follow rank sequence, expected '
                . ($this->getMaxSkillRankValue() + 1) . ", got {$personSkillRank->getValue()}"
            );
        }
    }

    /**
     * @param SkillRank $personSkillRank
     * @throws \DrdPlus\Skills\Exceptions\CanNotVerifyOwningSkill
     */
    private function guardRelatedSkillOfRank(SkillRank $personSkillRank)
    {
        if ($this !== $personSkillRank->getSkill()) {
            if (static::class !== get_class($personSkillRank->getSkill())) {
                throw new Exceptions\CanNotVerifyOwningSkill(
                    'New skill rank belongs to different skill class. Expected ' . static::class . ', got '
                    . get_class($personSkillRank->getSkill())
                );
            } else {
                throw new Exceptions\CanNotVerifyOwningSkill(
                    'New skill rank belongs to different instance of skill class ' . static::class
                );
            }
        }
    }

    /**
     * @return int
     */
    private function getMaxSkillRankValue()
    {
        return $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gives cloned original skill ranks
     *
     * @return SkillRank[]|ArrayCollection
     */
    public function getSkillRanks()
    {
        return clone $this->getInnerSkillRanks();
    }

    /**
     * @return SkillRank[]|ArrayCollection
     */
    abstract protected function getInnerSkillRanks();

    /**
     * @return SkillRank
     */
    public function getCurrentSkillRank()
    {
        return $this->getSkillRanks()->last();
    }

    /**
     * @param ProfessionLevel $professionLevel
     * @return SkillRank
     */
    abstract protected function createZeroSkillRank(ProfessionLevel $professionLevel);

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return string[]
     */
    abstract public function getRelatedPropertyCodes();

    /**
     * @return bool
     */
    abstract public function isPhysical();

    /**
     * @return bool
     */
    abstract public function isPsychical();

    /**
     * @return bool
     */
    abstract public function isCombined();

}