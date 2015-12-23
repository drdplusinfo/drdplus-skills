<?php
namespace DrdPlus\Person\Skills;

use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Person\Background\BackgroundSkillPoints;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tables\Tables;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

abstract class PersonSkillPoint extends StrictObject implements IntegerInterface
{
    const SKILL_POINT_VALUE = 1;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ProfessionLevel
     * @ORM\OneToOne(target="\DrdPlus\Person\ProfessionLevels\ProfessionLevel")
     */
    private $professionLevel;
    /**
     * @var BackgroundSkillPoints|null
     * @ORM\OneToOne(targetEntity="\DrdPlus\Person\Background\BackgroundSkillPoints", nullable=true)
     */
    private $backgroundSkillPoints;
    /**
     * @var PersonSkillPoint|null
     * @ORM\OneToOne(targetEntity="PersonSkillPoint", nullable=true)
     */
    private $firstPaidOtherSkillPoint;
    /**
     * @var PersonSkillPoint|null
     * @ORM\OneToOne(targetEntity="PersonSkillPoint", nullable=true)
     */
    private $secondPaidOtherSkillPoint;

    /**
     * @return string
     */
    abstract public function getTypeName();
    /**
     * @return string[]
     */
    abstract public function getRelatedProperties();

    /**
     * @param ProfessionLevel $professionLevel
     * @param BackgroundSkillPoints $backgroundSkillPoints
     * @param Tables $tables
     *
     * @return static
     */
    public static function createByFirstLevelBackgroundSkills(
        ProfessionLevel $professionLevel,
        BackgroundSkillPoints $backgroundSkillPoints,
        Tables $tables
    )
    {
        return new static($professionLevel, $tables, $backgroundSkillPoints);
    }

    /**
     * @param ProfessionLevel $professionLevel
     * @param PersonSkillPoint $firstPaidSkillPoint
     * @param PersonSkillPoint $secondPaidSkillPoint
     * @param Tables $tables
     *
     * @return static
     */
    public static function createFromCrossTypeSkillPoints(
        ProfessionLevel $professionLevel,
        PersonSkillPoint $firstPaidSkillPoint,
        PersonSkillPoint $secondPaidSkillPoint,
        Tables $tables
    )
    {
        return new static(
            $professionLevel, $tables, null /* background skills */, $firstPaidSkillPoint, $secondPaidSkillPoint
        );
    }

    /**
     * @param ProfessionLevel $professionLevel
     * @param Tables $tables
     *
     * @return static
     */
    public static function createByRelatedPropertyIncrease(ProfessionLevel $professionLevel, Tables $tables)
    {
        return new static($professionLevel, $tables);
    }

    /**
     * You can pay by a level (by its property adjustment respectively) or by two another skill points (as combined and psychical for a new physical)
     *
     * @param ProfessionLevel $professionLevel
     * @param Tables $tables
     * @param BackgroundSkillPoints $backgroundSkillPoints = null
     * @param PersonSkillPoint $firstPaidOtherSkillPoint = null
     * @param PersonSkillPoint $secondPaidOtherSkillPoint = null
     */
    protected function __construct(
        ProfessionLevel $professionLevel,
        Tables $tables,
        BackgroundSkillPoints $backgroundSkillPoints = null,
        PersonSkillPoint $firstPaidOtherSkillPoint = null,
        PersonSkillPoint $secondPaidOtherSkillPoint = null
    )
    {
        $this->checkPayment(
            $professionLevel,
            $tables,
            $backgroundSkillPoints,
            $firstPaidOtherSkillPoint,
            $secondPaidOtherSkillPoint
        );
        $this->professionLevel = $professionLevel;
        $this->backgroundSkillPoints = $backgroundSkillPoints;
        $this->firstPaidOtherSkillPoint = $firstPaidOtherSkillPoint;
        $this->secondPaidOtherSkillPoint = $secondPaidOtherSkillPoint;
    }

    private function checkPayment(
        ProfessionLevel $professionLevel,
        Tables $tables,
        BackgroundSkillPoints $backgroundSkillPoints = null,
        PersonSkillPoint $firstPaidSkillPoint = null,
        PersonSkillPoint $secondPaidSkillPoint = null
    )
    {
        if ($professionLevel->isFirstLevel() && $backgroundSkillPoints) {
            $this->checkPayByFirstLevelBackgroundSkills($professionLevel, $tables, $backgroundSkillPoints);
        } else if ($professionLevel->isFirstLevel() && $firstPaidSkillPoint && $secondPaidSkillPoint) {
            $this->checkPayByOtherSkillPoints($firstPaidSkillPoint, $secondPaidSkillPoint);
        } else if ($professionLevel->isNextLevel()) {
            $this->checkPayByLevelPropertyIncrease($professionLevel);
        } else {
            throw new \LogicException(
                'Unknown payment for skill-point of profession level of ID ' . $professionLevel->getId()
            );
        }
    }

    /**
     * @param ProfessionLevel $professionLevel
     * @param Tables $tables
     * @param BackgroundSkillPoints $backgroundSkillPoints
     *
     * @return bool
     */
    private function checkPayByFirstLevelBackgroundSkills(
        ProfessionLevel $professionLevel,
        Tables $tables,
        BackgroundSkillPoints $backgroundSkillPoints
    )
    {
        $relatedProperties = $this->sortAlphabetically($this->getRelatedProperties());
        $firstLevelSkillPoints = 0;
        switch ($relatedProperties) {
            case $this->sortAlphabetically([Strength::STRENGTH, Agility::AGILITY]) :
                $firstLevelSkillPoints = $backgroundSkillPoints->getPhysicalSkillPoints(
                    $professionLevel->getProfession(), $tables
                );
                break;
            case $this->sortAlphabetically([Will::WILL, Intelligence::INTELLIGENCE]) :
                $firstLevelSkillPoints = $backgroundSkillPoints->getPsychicalSkillPoints(
                    $professionLevel->getProfession(), $tables
                );
                break;
            case $this->sortAlphabetically([Knack::KNACK, Charisma::CHARISMA]) :
                $firstLevelSkillPoints = $backgroundSkillPoints->getCombinedSkillPoints(
                    $professionLevel->getProfession(), $tables
                );
                break;
        }
        if ($firstLevelSkillPoints < 1) {
            throw new \LogicException(
                "First level skill point has to come from the background. No skill point for properties " . implode(',', $relatedProperties) . " is available"
            );
        }

        return true;
    }

    private function checkPayByOtherSkillPoints(PersonSkillPoint $firstPaidSkillPoint, PersonSkillPoint $secondPaidSkillPoint)
    {
        $this->checkPaidSkillPoint($firstPaidSkillPoint);
        $this->checkPaidSkillPoint($secondPaidSkillPoint);
    }

    private function checkPaidSkillPoint(PersonSkillPoint $paidSkillPoint)
    {
        if (!$paidSkillPoint->isPaidByFirstLevelBackgroundSkills()) {
            $message = 'Skill points to pay with has to origin from first level background skills.';
            if ($paidSkillPoint->isPaidByNextLevelPropertyIncrease()) {
                $message .= ' Next level skill point is not allowed to trade.';
            }
            if ($paidSkillPoint->isPaidByOtherSkillPoints()) {
                $message .= ' There is no sense to trade first level skill point multiple times.';
            }
            throw new \LogicException($message);
        }
        if ($paidSkillPoint->getTypeName() === $this->getTypeName()) {
            throw new \LogicException(
                "There is no sense to pay for skill point by another one of the very same type ({$this->getTypeName()})."
                . ' Got paid skill point of ID ' . $paidSkillPoint->getId()
            );
        }
    }

    protected function checkPayByLevelPropertyIncrease(ProfessionLevel $professionLevel)
    {
        if ($professionLevel->isFirstLevel()) {
            throw new \LogicException(
                'Skill point can not be obtained by a level property increase for first level.' .
                ' Did you want to use different creation?'
            );
        }
        $relatedProperties = $this->sortAlphabetically($this->getRelatedProperties());
        $missingPropertyAdjustment = false;
        switch ($relatedProperties) {
            case $this->sortAlphabetically([Strength::STRENGTH, Agility::AGILITY]) :
                $missingPropertyAdjustment = !$professionLevel->getStrengthIncrement()->getValue()
                    && !$professionLevel->getAgilityIncrement()->getValue();
                break;
            case $this->sortAlphabetically([Will::WILL, Intelligence::INTELLIGENCE]) :
                $missingPropertyAdjustment = !$professionLevel->getWillIncrement()->getValue()
                    && !$professionLevel->getIntelligenceIncrement()->getValue();
                break;
            case $this->sortAlphabetically([Knack::KNACK, Charisma::CHARISMA]) :
                $missingPropertyAdjustment = !$professionLevel->getKnackIncrement()->getValue()
                    && !$professionLevel->getCharismaIncrement()->getValue();
                break;
        }

        if ($missingPropertyAdjustment) {
            throw new \LogicException(
                'The profession level of ID ' . $professionLevel->getId() . ' has to have adjustment either ' . implode(' or ', $this->getRelatedProperties())
            );
        }
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function sortAlphabetically(array $array)
    {
        sort($array);

        return $array;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return static::SKILL_POINT_VALUE;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * @return ProfessionLevel
     */
    public function getProfessionLevel()
    {
        return $this->professionLevel;
    }

    /**
     * @return BackgroundSkillPoints|null
     */
    public function getBackgroundSkills()
    {
        return $this->backgroundSkillPoints;
    }

    /**
     * @return PersonSkillPoint|null
     */
    public function getFirstPaidOtherSkillPoint()
    {
        return $this->firstPaidOtherSkillPoint;
    }

    /**
     * @return PersonSkillPoint|null
     */
    public function getSecondPaidOtherSkillPoint()
    {
        return $this->secondPaidOtherSkillPoint;
    }

    /**
     * @return boolean
     */
    public function isPaidByFirstLevelBackgroundSkills()
    {
        return $this->getBackgroundSkills() !== null;
    }

    /**
     * @return boolean
     */
    public function isPaidByOtherSkillPoints()
    {
        return $this->getFirstPaidOtherSkillPoint() && $this->getSecondPaidOtherSkillPoint();
    }

    /**
     * @return boolean
     */
    public function isPaidByNextLevelPropertyIncrease()
    {
        return !$this->isPaidByFirstLevelBackgroundSkills() && !$this->isPaidByOtherSkillPoints();
    }

}
