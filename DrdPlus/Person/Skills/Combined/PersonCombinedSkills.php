<?php
namespace DrdPlus\Person\Skills\Combined;

use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Person\Skills\PersonSameTypeSkills;

/**
 * CombinedSkills
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class PersonCombinedSkills extends PersonSameTypeSkills
{
    const COMBINED = SkillCodes::COMBINED;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var BigHandwork|null
     * @ORM\OneToOne(targetEntity="BigHandwork")
     */
    private $bigHandwork;
    /** @var Cooking|null
     * @ORM\OneToOne(targetEntity="Cooking")
     */
    private $cooking;
    /** @var Dancing|null
     * @ORM\OneToOne(targetEntity="Dancing")
     */
    private $dancing;
    /** @var DuskSight|null
     * @ORM\OneToOne(targetEntity="DuskSight")
     */
    private $duskSight;
    /** @var FightWithShootingWeapons|null
     * @ORM\OneToOne(targetEntity="FightWithShootingWeapons")
     */
    private $fightWithShootingWeapons;
    /** @var FirstAid|null
     * @ORM\OneToOne(targetEntity="FirstAid")
     */
    private $firstAid;
    /** @var HandlingWithAnimals|null
     * @ORM\OneToOne(targetEntity="HandingWithAnimals")
     */
    private $handlingWithAnimals;
    /** @var Handwork|null
     * @ORM\OneToOne(targetEntity="Handwork")
     */
    private $handwork;
    /** @var Gambling|null
     * @ORM\OneToOne(targetEntity="Gambling")
     */
    private $gambling;
    /** @var Herbalism|null
     * @ORM\OneToOne(targetEntity="Herbalism")
     */
    private $herbalism;
    /** @var HuntingAndFishing|null
     * @ORM\OneToOne(targetEntity="HuntingAndFishing")
     */
    private $huntingAndFishing;
    /** @var Knotting|null
     * @ORM\OneToOne(targetEntity="Knotting")
     */
    private $knotting;
    /** @var Painting|null
     * @ORM\OneToOne(targetEntity="Painting")
     */
    private $painting;
    /** @var Pedagogy|null
     * @ORM\OneToOne(targetEntity="Pedagogy")
     */
    private $pedagogy;
    /** @var PlayingOnMusicInstrument|null
     * @ORM\OneToOne(targetEntity="PlayingOnMusicInstrument")
     */
    private $playingOnMusicInstrument;
    /** @var Seduction|null
     * @ORM\OneToOne(targetEntity="Seduction")
     */
    private $seduction;
    /** @var Showmanship|null
     * @ORM\OneToOne(targetEntity="Showmanship")
     */
    private $showmanship;
    /** @var Singing|null
     * @ORM\OneToOne(targetEntity="Singing")
     */
    private $singing;
    /** @var Statuary|null
     * @ORM\OneToOne(targetEntity="Statuary")
     */
    private $statuary;

    /**
     * @param ProfessionLevels $professionLevels
     * @return int
     */
    public function getUnusedFirstLevelCombinedSkillPointsValue(ProfessionLevels $professionLevels)
    {
        return $this->getUnusedFirstLevelSkillPointsValue($this->getFirstLevelCombinedPropertiesSum($professionLevels));
    }

    private function getFirstLevelCombinedPropertiesSum(ProfessionLevels $professionLevels)
    {
        return $professionLevels->getFirstLevelKnackModifier() + $professionLevels->getFirstLevelCharismaModifier();
    }

    /**
     * @param ProfessionLevels $professionLevels
     * @return int
     */
    public function getUnusedNextLevelsCombinedSkillPointsValue(ProfessionLevels $professionLevels)
    {
        return $this->getUnusedNextLevelsSkillPointsValue($this->getNextLevelsCombinedPropertiesSum($professionLevels));
    }

    private function getNextLevelsCombinedPropertiesSum(ProfessionLevels $professionLevels)
    {
        return $professionLevels->getNextLevelsKnackModifier() + $professionLevels->getNextLevelsCharismaModifier();
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator(
            array_filter([
                $this->getBigHandwork(),
                $this->getCooking(),
                $this->getDancing(),
                $this->getDuskSight(),
                $this->getFightWithShootingWeapons(),
                $this->getFirstAid(),
                $this->getGambling(),
                $this->getHandlingWithAnimals(),
                $this->getHandwork(),
                $this->getHerbalism(),
                $this->getHuntingAndFishing(),
                $this->getKnotting(),
                $this->getPainting(),
                $this->getPedagogy(),
                $this->getPlayingOnMusicInstrument(),
                $this->getSeduction(),
                $this->getShowmanship(),
                $this->getSinging(),
                $this->getStatuary()
            ])
        );
    }

    /**
     * @return string
     */
    public function getSkillsGroupName()
    {
        return self::COMBINED;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function addCombinedSkill(PersonCombinedSkill $combinedSkill)
    {
        switch (true) {
            case is_a($combinedSkill, BigHandwork::class) :
                if (isset($this->bigHandwork)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Big handwork is already set');
                }
                $this->bigHandwork = $combinedSkill;
                break;
            case is_a($combinedSkill, Cooking::class) :
                if (isset($this->cooking)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Cooking is already set');
                }
                $this->cooking = $combinedSkill;
                break;
            case is_a($combinedSkill, Dancing::class) :
                if (isset($this->dancing)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Dancing is already set');
                }
                $this->dancing = $combinedSkill;
                break;
            case is_a($combinedSkill, DuskSight::class) :
                if (isset($this->duskSight)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Dusk sight is already set');
                }
                $this->duskSight = $combinedSkill;
                break;
            case is_a($combinedSkill, FightWithShootingWeapons::class) :
                if (isset($this->fightWithShootingWeapons)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Fight with shooting weapons is already set');
                }
                $this->fightWithShootingWeapons = $combinedSkill;
                break;
            case is_a($combinedSkill, FirstAid::class) :
                if (isset($this->firstAid)) {
                    throw new Exceptions\CombinedSkillAlreadySet('First aid is already set');
                }
                $this->firstAid = $combinedSkill;
                break;
            case is_a($combinedSkill, HandlingWithAnimals::class) :
                if (isset($this->handlingWithAnimals)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Handling with animals is already set');
                }
                $this->handlingWithAnimals = $combinedSkill;
                break;
            case is_a($combinedSkill, Handwork::class) :
                if (isset($this->handwork)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Handwork is already set');
                }
                $this->handwork = $combinedSkill;
                break;
            case is_a($combinedSkill, Gambling::class) :
                if (isset($this->gambling)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Gambling is already set');
                }
                $this->gambling = $combinedSkill;
                break;
            case is_a($combinedSkill, Herbalism::class) :
                if (isset($this->herbalism)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Herbalism is already set');
                }
                $this->herbalism = $combinedSkill;
                break;
            case is_a($combinedSkill, HuntingAndFishing::class) :
                if (isset($this->huntingAndFishing)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Hunting and fishing is already set');
                }
                $this->huntingAndFishing = $combinedSkill;
                break;
            case is_a($combinedSkill, Knotting::class) :
                if (isset($this->knotting)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Knotting is already set');
                }
                $this->knotting = $combinedSkill;
                break;
            case is_a($combinedSkill, Painting::class) :
                if (isset($this->painting)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Painting is already set');
                }
                $this->painting = $combinedSkill;
                break;
            case is_a($combinedSkill, Pedagogy::class) :
                if (isset($this->pedagogy)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Pedagogy is already set');
                }
                $this->pedagogy = $combinedSkill;
                break;
            case is_a($combinedSkill, PlayingOnMusicInstrument::class) :
                if (isset($this->playingOnMusicInstrument)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Playing on music instrument is already set');
                }
                $this->playingOnMusicInstrument = $combinedSkill;
                break;
            case is_a($combinedSkill, Seduction::class) :
                if (isset($this->seduction)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Seduction is already set');
                }
                $this->seduction = $combinedSkill;
                break;
            case is_a($combinedSkill, Showmanship::class) :
                if (isset($this->showmanship)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Showmanship is already set');
                }
                $this->showmanship = $combinedSkill;
                break;
            case is_a($combinedSkill, Singing::class) :
                if (isset($this->singing)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Singing is already set');
                }
                $this->singing = $combinedSkill;
                break;
            case is_a($combinedSkill, Statuary::class) :
                if (isset($this->statuary)) {
                    throw new Exceptions\CombinedSkillAlreadySet('Statuary is already set');
                }
                $this->statuary = $combinedSkill;
                break;
            default :
                throw new Exceptions\UnknownCombinedSkill(
                    'Unknown combined skill ' . get_class($combinedSkill)
                );
        }
    }

    /**
     * @return BigHandwork|null
     */
    public function getBigHandwork()
    {
        return $this->bigHandwork;
    }

    /**
     * @return Cooking|null
     */
    public function getCooking()
    {
        return $this->cooking;
    }

    /**
     * @return Dancing|null
     */
    public function getDancing()
    {
        return $this->dancing;
    }

    /**
     * @return DuskSight|null
     */
    public function getDuskSight()
    {
        return $this->duskSight;
    }

    /**
     * @return FightWithShootingWeapons|null
     */
    public function getFightWithShootingWeapons()
    {
        return $this->fightWithShootingWeapons;
    }

    /**
     * @return FirstAid|null
     */
    public function getFirstAid()
    {
        return $this->firstAid;
    }

    /**
     * @return HandlingWithAnimals|null
     */
    public function getHandlingWithAnimals()
    {
        return $this->handlingWithAnimals;
    }

    /**
     * @return Handwork|null
     */
    public function getHandwork()
    {
        return $this->handwork;
    }

    /**
     * @return Gambling|null
     */
    public function getGambling()
    {
        return $this->gambling;
    }

    /**
     * @return Herbalism|null
     */
    public function getHerbalism()
    {
        return $this->herbalism;
    }

    /**
     * @return HuntingAndFishing|null
     */
    public function getHuntingAndFishing()
    {
        return $this->huntingAndFishing;
    }

    /**
     * @return Knotting|null
     */
    public function getKnotting()
    {
        return $this->knotting;
    }

    /**
     * @return Painting|null
     */
    public function getPainting()
    {
        return $this->painting;
    }

    /**
     * @return Pedagogy|null
     */
    public function getPedagogy()
    {
        return $this->pedagogy;
    }

    /**
     * @return PlayingOnMusicInstrument|null
     */
    public function getPlayingOnMusicInstrument()
    {
        return $this->playingOnMusicInstrument;
    }

    /**
     * @return Seduction|null
     */
    public function getSeduction()
    {
        return $this->seduction;
    }

    /**
     * @return Showmanship|null
     */
    public function getShowmanship()
    {
        return $this->showmanship;
    }

    /**
     * @return Singing|null
     */
    public function getSinging()
    {
        return $this->singing;
    }

    /**
     * @return Statuary|null
     */
    public function getStatuary()
    {
        return $this->statuary;
    }

}
