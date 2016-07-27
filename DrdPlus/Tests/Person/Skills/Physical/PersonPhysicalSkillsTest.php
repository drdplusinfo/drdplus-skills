<?php
namespace DrdPlus\Tests\Person\Skills\Physical;

use DrdPlus\Codes\WeaponCategoryCode;
use DrdPlus\Codes\WeaponCode;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Person\Skills\PersonSkill;
use DrdPlus\Person\Skills\PersonSkillRank;
use DrdPlus\Person\Skills\Physical\ArmorWearing;
use DrdPlus\Person\Skills\Physical\Athletics;
use DrdPlus\Person\Skills\Physical\Blacksmithing;
use DrdPlus\Person\Skills\Physical\BoatDriving;
use DrdPlus\Person\Skills\Physical\FightUnarmed;
use DrdPlus\Person\Skills\Physical\FightWithAxes;
use DrdPlus\Person\Skills\Physical\FightWithKnifesAndDaggers;
use DrdPlus\Person\Skills\Physical\FightWithMacesAndClubs;
use DrdPlus\Person\Skills\Physical\FightWithMorningStarsAndMorgensterns;
use DrdPlus\Person\Skills\Physical\FightWithSabersAndBowieKnifes;
use DrdPlus\Person\Skills\Physical\FightWithStaffsAndSpears;
use DrdPlus\Person\Skills\Physical\FightWithSwords;
use DrdPlus\Person\Skills\Physical\FightWithThrowingWeapons;
use DrdPlus\Person\Skills\Physical\FightWithTwoWeapons;
use DrdPlus\Person\Skills\Physical\FightWithVoulgesAndTridents;
use DrdPlus\Person\Skills\Physical\Flying;
use DrdPlus\Person\Skills\Physical\PersonPhysicalSkill;
use DrdPlus\Person\Skills\Physical\PersonPhysicalSkills;
use DrdPlus\Tables\Armaments\Weapons\MissingWeaponSkillsTable;
use DrdPlus\Tests\Person\Skills\PersonSameTypeSkillsTest;

class PersonPhysicalSkillsTest extends PersonSameTypeSkillsTest
{

    /**
     * @test
     * @dataProvider providePersonSkill
     * @param PersonSkill $personSkill
     * @expectedException \DrdPlus\Person\Skills\Physical\Exceptions\PhysicalSkillAlreadySet
     */
    public function I_can_not_replace_skill(PersonSkill $personSkill)
    {
        parent::I_can_not_replace_skill($personSkill);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Person\Skills\Physical\Exceptions\UnknownPhysicalSkill
     */
    public function I_can_not_add_unknown_skill()
    {
        $skills = new PersonPhysicalSkills();
        /** @var PersonPhysicalSkill $strangePhysicalSkill */
        $strangePhysicalSkill = $this->mockery(PersonPhysicalSkill::class);
        $skills->addPhysicalSkill($strangePhysicalSkill);
    }

    /**
     * @test
     */
    public function I_can_get_unused_skill_points_from_first_level()
    {
        $skills = new PersonPhysicalSkills();
        $professionLevels = $this->createProfessionLevels(
            $firstLevelStrength = 123, $firstLevelAgility = 456, $nextLevelStrength = 321, $nextLevelAgility = 654
        );

        self::assertSame(
            $firstLevelStrength + $firstLevelAgility,
            $skills->getUnusedFirstLevelPhysicalSkillPointsValue($professionLevels)
        );

        $skills->addPhysicalSkill($this->createPhysicalSkill($usedRank = 3, 1, ArmorWearing::class));
        $skills->addPhysicalSkill($this->createPhysicalSkill($unusedRank = 2, 2, Athletics::class));
        self::assertSame(
            ($firstLevelStrength + $firstLevelAgility) - array_sum(range(1, $usedRank)),
            $skills->getUnusedFirstLevelPhysicalSkillPointsValue($professionLevels),
            'Expected ' . (($firstLevelStrength + $firstLevelAgility) - array_sum(range(1, $usedRank)))
        );
    }

    /**
     * @param int $firstLevelStrengthModifier
     * @param int $firstLevelAgilityModifier
     * @param int $nextLevelsStrengthModifier
     * @param int $nextLevelsAgilityModifier
     * @return \Mockery\MockInterface|ProfessionLevels
     */
    private function createProfessionLevels(
        $firstLevelStrengthModifier, $firstLevelAgilityModifier, $nextLevelsStrengthModifier, $nextLevelsAgilityModifier
    )
    {
        $professionLevels = $this->mockery(ProfessionLevels::class);
        $professionLevels->shouldReceive('getFirstLevelStrengthModifier')
            ->andReturn($firstLevelStrengthModifier);
        $professionLevels->shouldReceive('getFirstLevelAgilityModifier')
            ->andReturn($firstLevelAgilityModifier);
        $professionLevels->shouldReceive('getNextLevelsStrengthModifier')
            ->andReturn($nextLevelsStrengthModifier);
        $professionLevels->shouldReceive('getNextLevelsAgilityModifier')
            ->andReturn($nextLevelsAgilityModifier);

        return $professionLevels;
    }

    /**
     * @param int $finalSkillRankValue
     * @param int $levelValue
     * @param string $skillClass
     * @return \Mockery\MockInterface|PersonPhysicalSkill
     */
    private function createPhysicalSkill($finalSkillRankValue, $levelValue, $skillClass)
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
        $skills = new PersonPhysicalSkills();
        $professionLevels = $this->createProfessionLevels(
            $firstLevelStrength = 123, $firstLevelAgility = 456, $nextLevelsStrength = 321, $nextLevelsAgility = 654
        );

        self::assertSame($nextLevelsStrength + $nextLevelsAgility, $skills->getUnusedNextLevelsPhysicalSkillPointsValue($professionLevels));
        $skills->addPhysicalSkill($this->createPhysicalSkill($rankFromFirstLevel = 2, 1, Blacksmithing::class));
        self::assertSame($nextLevelsStrength + $nextLevelsAgility, $skills->getUnusedNextLevelsPhysicalSkillPointsValue($professionLevels));

        $skills->addPhysicalSkill($this->createPhysicalSkill($aRankFromNextLevel = 3, 2, BoatDriving::class));
        $skills->addPhysicalSkill($this->createPhysicalSkill($anotherRankFromNextLevel = 1, 3, Flying::class));
        self::assertSame(
            ($nextLevelsStrength + $nextLevelsAgility) - (array_sum(range(1, $aRankFromNextLevel)) + array_sum(range(1, $anotherRankFromNextLevel))),
            $skills->getUnusedNextLevelsPhysicalSkillPointsValue($professionLevels),
            'Expected ' . (($nextLevelsStrength + $nextLevelsAgility) - (array_sum(range(1, $aRankFromNextLevel)) + array_sum(range(1, $anotherRankFromNextLevel))))
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_fight_with_melee_weapon_skills_at_once()
    {
        $skills = new PersonPhysicalSkills();
        $skills->addPhysicalSkill($fightUnarmed = new FightUnarmed());
        $skills->addPhysicalSkill($fightWithAxes = new FightWithAxes());
        $skills->addPhysicalSkill($fightWithKnifesAndDaggers = new FightWithKnifesAndDaggers());
        $skills->addPhysicalSkill($fightWithMacesAndClubs = new FightWithMacesAndClubs());
        $skills->addPhysicalSkill($fightWithMorningStarsAndMorgensterns = new FightWithMorningStarsAndMorgensterns());
        $skills->addPhysicalSkill($fightWithSabersAndBowieKnifes = new FightWithSabersAndBowieKnifes());
        $skills->addPhysicalSkill($fightWithStaffsAndSpears = new FightWithStaffsAndSpears());
        $skills->addPhysicalSkill($fightWithSwords = new FightWithSwords());
        $skills->addPhysicalSkill($fightWithThrowingWeapons = new FightWithThrowingWeapons());
        $skills->addPhysicalSkill($fightWithTwoWeapons = new FightWithTwoWeapons());
        $skills->addPhysicalSkill($fightWithVoulgesAndTridents = new FightWithVoulgesAndTridents());

        self::assertSame(
            [
                $fightUnarmed,
                $fightWithAxes,
                $fightWithKnifesAndDaggers,
                $fightWithMacesAndClubs,
                $fightWithMorningStarsAndMorgensterns,
                $fightWithSabersAndBowieKnifes,
                $fightWithStaffsAndSpears,
                $fightWithSwords,
                $fightWithThrowingWeapons,
                $fightWithTwoWeapons,
                $fightWithVoulgesAndTridents
            ],
            $skills->getFightWithMeleeWeaponSkills()
        );
    }

    /**
     * @test
     * @dataProvider provideWeaponCategories
     * @param string $weaponCategory
     */
    public function I_can_get_malus_for_every_type_of_weapon($weaponCategory)
    {
        $skills = new PersonPhysicalSkills();
        self::assertSame(
            $expectedMalus = 'foo',
            $skills->getMalusToFightNumber(
                $this->createWeaponCode($weaponCategory),
                $this->createMissingWeaponSkillsTable('fightNumber', 0 /* expected skill value */, $expectedMalus)
            )
        );
        self::assertSame(
            $expectedMalus = 'bar',
            $skills->getMalusToAttackNumber(
                $this->createWeaponCode($weaponCategory),
                $this->createMissingWeaponSkillsTable('attackNumber', 0 /* expected skill value */, $expectedMalus)
            )
        );
        self::assertSame(
            $expectedMalus = 'baz',
            $skills->getMalusToCover(
                $this->createWeaponCode($weaponCategory),
                $this->createMissingWeaponSkillsTable('cover', 0 /* expected skill value */, $expectedMalus)
            )
        );
        self::assertSame(
            $expectedMalus = 'qux',
            $skills->getMalusToBaseOfWounds(
                $this->createWeaponCode($weaponCategory),
                $this->createMissingWeaponSkillsTable('baseOfWounds', 0 /* expected skill value */, $expectedMalus)
            )
        );
    }

    /**
     * @return array|string[][]
     */
    public function provideWeaponCategories()
    {
        return array_map(
            function ($code) {
                return [$code];
            },
            WeaponCategoryCode::getWeaponCategoryCodes()
        );
    }

    /**
     * @param $weaponCategory
     * @return \Mockery\MockInterface|WeaponCode
     */
    private function createWeaponCode($weaponCategory)
    {
        $code = $this->mockery(WeaponCode::class);
        $code->shouldReceive('is' . ucfirst($weaponCategory))
            ->andReturn('true');
        $code->shouldIgnoreMissing(false /* return value for non-mocked methods */);

        return $code;
    }

    /**
     * @param string $weaponParameterName
     * @param $expectedSkillValue
     * @param $result
     * @return \Mockery\MockInterface|MissingWeaponSkillsTable
     */
    private function createMissingWeaponSkillsTable($weaponParameterName, $expectedSkillValue, $result)
    {
        $missingWeaponSkillsTable = $this->mockery(MissingWeaponSkillsTable::class);
        $missingWeaponSkillsTable->shouldReceive('get' . ucfirst($weaponParameterName) . 'ForWeaponSkill')
            ->with($expectedSkillValue)
            ->andReturn($result);

        return $missingWeaponSkillsTable;
    }

}
