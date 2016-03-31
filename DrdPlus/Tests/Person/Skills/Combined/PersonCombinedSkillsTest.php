<?php
namespace DrdPlus\Tests\Person\Skills\Combined;

use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Person\Skills\Combined\BigHandwork;
use DrdPlus\Person\Skills\Combined\Cooking;
use DrdPlus\Person\Skills\Combined\FirstAid;
use DrdPlus\Person\Skills\Combined\Gambling;
use DrdPlus\Person\Skills\Combined\PersonCombinedSkill;
use DrdPlus\Person\Skills\Combined\PersonCombinedSkills;
use DrdPlus\Person\Skills\Combined\Seduction;
use DrdPlus\Person\Skills\PersonSkill;
use DrdPlus\Person\Skills\PersonSkillRank;
use DrdPlus\Tests\Person\Skills\PersonSameTypeSkillsTest;

class PersonCombinedSkillsTest extends PersonSameTypeSkillsTest
{

    /**
     * @test
     * @dataProvider providePersonSkill
     * @param PersonSkill $personSkill
     * @expectedException \DrdPlus\Person\Skills\Combined\Exceptions\CombinedSkillAlreadySet
     */
    public function I_can_not_replace_skill(PersonSkill $personSkill)
    {
        parent::I_can_not_replace_skill($personSkill);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Person\Skills\Combined\Exceptions\UnknownCombinedSkill
     */
    public function I_can_not_add_unknown_skill()
    {
        $skills = new PersonCombinedSkills();
        /** @var PersonCombinedSkill $strangeCombinedSkill */
        $strangeCombinedSkill = $this->mockery(PersonCombinedSkill::class);
        $skills->addCombinedSkill($strangeCombinedSkill);
    }

    /**
     * @test
     */
    public function I_can_get_unused_skill_points_from_first_level()
    {
        $skills = new PersonCombinedSkills();
        $professionLevels = $this->createProfessionLevels(
            $firstLevelKnack = 123, $firstLevelCharisma = 456, $nextLevelKnack = 321, $nextLevelCharisma = 654
        );

        self::assertSame(
            $firstLevelKnack + $firstLevelCharisma,
            $skills->getUnusedFirstLevelCombinedSkillPointsValue($professionLevels)
        );

        $skills->addCombinedSkill($this->createCombinedSkill($usedRank = 3, 1, BigHandwork::class));
        $skills->addCombinedSkill($this->createCombinedSkill($unusedRank = 2, 2, Cooking::class));
        self::assertSame(
            ($firstLevelKnack + $firstLevelCharisma) - array_sum(range(1, $usedRank)),
            $skills->getUnusedFirstLevelCombinedSkillPointsValue($professionLevels),
            'Expected ' . (($firstLevelKnack + $firstLevelCharisma) - array_sum(range(1, $usedRank)))
        );
    }

    /**
     * @param int $firstLevelKnackModifier
     * @param int $firstLevelCharismaModifier
     * @param int $nextLevelsKnackModifier
     * @param int $nextLevelsCharismaModifier
     * @return \Mockery\MockInterface|ProfessionLevels
     */
    private function createProfessionLevels(
        $firstLevelKnackModifier, $firstLevelCharismaModifier, $nextLevelsKnackModifier, $nextLevelsCharismaModifier
    )
    {
        $professionLevels = $this->mockery(ProfessionLevels::class);
        $professionLevels->shouldReceive('getFirstLevelKnackModifier')
            ->andReturn($firstLevelKnackModifier);
        $professionLevels->shouldReceive('getFirstLevelCharismaModifier')
            ->andReturn($firstLevelCharismaModifier);
        $professionLevels->shouldReceive('getNextLevelsKnackModifier')
            ->andReturn($nextLevelsKnackModifier);
        $professionLevels->shouldReceive('getNextLevelsCharismaModifier')
            ->andReturn($nextLevelsCharismaModifier);

        return $professionLevels;
    }

    /**
     * @param int $finalSkillRankValue
     * @param int $levelValue
     * @param string $skillClass
     * @return \Mockery\MockInterface|PersonCombinedSkill
     */
    private function createCombinedSkill($finalSkillRankValue, $levelValue, $skillClass)
    {
        $combinedSkill = $this->mockery($skillClass);
        $professionLevel = $this->mockery(ProfessionLevel::class);
        $professionLevel->shouldReceive('isFirstLevel')
            ->andReturn($levelValue === 1);
        $professionLevel->shouldReceive('isNextLevel')
            ->andReturn($levelValue > 1);
        /** @var ProfessionLevel $professionLevel */
        $combinedSkill->shouldReceive('getSkillRanks')
            ->andReturn($this->createSkillRanks($finalSkillRankValue, $professionLevel));

        return $combinedSkill;
    }

    private function createSkillRanks($finalSkillRankValue, ProfessionLevel $professionLevel)
    {
        $skillRanks = [];
        for ($value = 1; $value <= $finalSkillRankValue; $value++) {
            $skillRank = $this->mockery(PersonSkillRank::class);
            $skillRank->shouldReceive('getValue')
                ->andReturn($value);
            $skillRank->shouldReceive('getProfessionLevel')
                ->andReturn($professionLevel);
            $skillRanks[] = $skillRank;
        }

        return $skillRanks;
    }

    /**
     * @test
     */
    public function I_can_get_unused_skill_points_from_next_levels()
    {
        $skills = new PersonCombinedSkills();
        $professionLevels = $this->createProfessionLevels(
            $firstLevelKnack = 123, $firstLevelCharisma = 456, $nextLevelsKnack = 321, $nextLevelsCharisma = 654
        );

        self::assertSame($nextLevelsKnack + $nextLevelsCharisma, $skills->getUnusedNextLevelsCombinedSkillPointsValue($professionLevels));
        $skills->addCombinedSkill($this->createCombinedSkill($rankFromFirstLevel = 2, 1, FirstAid::class));
        self::assertSame($nextLevelsKnack + $nextLevelsCharisma, $skills->getUnusedNextLevelsCombinedSkillPointsValue($professionLevels));

        $skills->addCombinedSkill($this->createCombinedSkill($aRankFromNextLevel = 3, 2, Gambling::class));
        $skills->addCombinedSkill($this->createCombinedSkill($anotherRankFromNextLevel = 1, 3, Seduction::class));
        self::assertSame(
            ($nextLevelsKnack + $nextLevelsCharisma) - (array_sum(range(1, $aRankFromNextLevel)) + array_sum(range(1, $anotherRankFromNextLevel))),
            $skills->getUnusedNextLevelsCombinedSkillPointsValue($professionLevels),
            'Expected ' . (($nextLevelsKnack + $nextLevelsCharisma) - (array_sum(range(1, $aRankFromNextLevel)) + array_sum(range(1, $anotherRankFromNextLevel))))
        );
    }

}
