<?php
namespace DrdPlus\Tests\Skills\Psychical;

class KnowledgeOfWorldTest extends WithBonusFromPsychicalTest
{
    /**
     * @param int $skillRankValue
     * @return int
     */
    protected function getExpectedBonus(int $skillRankValue): int
    {
        return 2 * $skillRankValue;
    }

}