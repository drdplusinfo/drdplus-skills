<?php
namespace DrdPlus\Skills\Combined;

use Drd\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\Codes\Skills\CombinedSkillCode;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Skills\Combined\RollsOnQuality\PlayingOnMusicInstrumentGameQuality;
use DrdPlus\Skills\WithBonus;

/**
 * @ORM\Entity()
 */
class PlayingOnMusicInstrument extends CombinedSkill implements WithBonus
{
    const PLAYING_ON_MUSIC_INSTRUMENT = CombinedSkillCode::PLAYING_ON_MUSIC_INSTRUMENT;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::PLAYING_ON_MUSIC_INSTRUMENT;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return 3 * $this->getCurrentSkillRank()->getValue();
    }

    /**
     * @param Knack $knack
     * @param Roll2d6DrdPlus $roll2D6DrdPlus
     * @return PlayingOnMusicInstrumentGameQuality
     */
    public function getPlayingOnMusicInstrumentGameQuality(Knack $knack, Roll2d6DrdPlus $roll2D6DrdPlus)
    {
        return new PlayingOnMusicInstrumentGameQuality($knack, $this, $roll2D6DrdPlus);
    }
}