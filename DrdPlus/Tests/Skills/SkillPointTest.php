<?php
namespace DrdPlus\Tests\Skills;

use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\ProfessionLevels\LevelRank;
use DrdPlus\Person\ProfessionLevels\ProfessionFirstLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionNextLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionZeroLevel;
use DrdPlus\Professions\Commoner;
use DrdPlus\Skills\Combined\CombinedSkillPoint;
use DrdPlus\Skills\SkillPoint;
use DrdPlus\Skills\Physical\PhysicalSkillPoint;
use DrdPlus\Skills\Psychical\PsychicalSkillPoint;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Tables\Tables;
use /** @noinspection PhpUnusedAliasInspection because of a bug in PhpStorm */
    Granam\Tests\Tools\TestWithMockery;

abstract class SkillPointTest extends TestWithMockery
{
    protected $paidByFirstLevelBackgroundSkills;
    protected $isPaidByNextLevelPropertyIncrease;
    protected $isPaidByOtherSkillPoints;

    /**
     * @test
     */
    public function I_can_use_skill_point_by_first_level_background_skills()
    {
        $skillPointAndLevel = $this->I_can_create_skill_point_by_first_level_background_skills();

        $this->I_got_null_as_ID_of_non_persisted_skill_point($skillPointAndLevel[0]);
        $this->I_got_always_number_one_on_to_string_conversion($skillPointAndLevel[0]);
        $this->I_can_get_profession_level($skillPointAndLevel[0], $skillPointAndLevel[1]);
        $this->I_can_detect_way_of_payment($skillPointAndLevel[0]);
    }

    /**
     * @return array [SkillPoint, PersonLevel]
     */
    abstract protected function I_can_create_skill_point_by_first_level_background_skills();

    protected function I_got_null_as_ID_of_non_persisted_skill_point(SkillPoint $skillPoint)
    {
        self::assertNull($skillPoint->getId());
    }

    protected function I_got_always_number_one_on_to_string_conversion(SkillPoint $skillPoint)
    {
        self::assertSame('1', (string)$skillPoint);
    }

    protected function I_can_get_profession_level(SkillPoint $skillPoint, ProfessionLevel $expectedLevel)
    {
        self::assertSame($expectedLevel, $skillPoint->getProfessionLevel());
    }

    protected function I_can_detect_way_of_payment(SkillPoint $skillPoint)
    {
        self::assertSame(
            $skillPoint->getBackgroundSkillPoints() !== null,
            $skillPoint->isPaidByFirstLevelBackgroundSkillPoints()
        );
        self::assertSame(
            $skillPoint->getFirstPaidOtherSkillPoint() !== null && $skillPoint->getSecondPaidOtherSkillPoint() !== null,
            $skillPoint->isPaidByOtherSkillPoints()
        );
        self::assertSame(
            !$skillPoint->isPaidByFirstLevelBackgroundSkillPoints()
            && !$skillPoint->isPaidByOtherSkillPoints()
            && $skillPoint->getProfessionNextLevel() !== null,
            $skillPoint->isPaidByNextLevelPropertyIncrease()
        );
        self::assertSame(
            1,
            $skillPoint->isPaidByFirstLevelBackgroundSkillPoints()
            + $skillPoint->isPaidByNextLevelPropertyIncrease()
            + $skillPoint->isPaidByOtherSkillPoints()
        );
    }

    /**
     * @test
     */
    public function I_can_use_skill_point_by_cross_type_skill_points()
    {
        $skillPointsAndLevels = $this->I_can_create_skill_point_by_cross_type_skill_points();

        foreach ($skillPointsAndLevels as $skillPointAndLevel) {
            $this->I_got_null_as_ID_of_non_persisted_skill_point($skillPointAndLevel[0]);
            $this->I_got_always_number_one_on_to_string_conversion($skillPointAndLevel[0]);
            $this->I_can_get_profession_level($skillPointAndLevel[0], $skillPointAndLevel[1]);
            $this->I_can_detect_way_of_payment($skillPointAndLevel[0]);
        }
    }

    /**
     * @return array [SkillPoint, PersonLevel][]
     */
    abstract protected function I_can_create_skill_point_by_cross_type_skill_points();

    /**
     * @test
     */
    public function I_can_use_skill_point_by_related_property_increase()
    {
        $skillPointsAndLevels = $this->I_can_create_skill_point_by_related_property_increase();

        foreach ($skillPointsAndLevels as $skillPointsAndLevel) {
            $this->I_got_null_as_ID_of_non_persisted_skill_point($skillPointsAndLevel[0]);
            $this->I_got_always_number_one_on_to_string_conversion($skillPointsAndLevel[0]);
            $this->I_can_get_profession_level($skillPointsAndLevel[0], $skillPointsAndLevel[1]);
            $this->I_can_detect_way_of_payment($skillPointsAndLevel[0]);
        }
    }

    /**
     * @return SkillPoint[]
     */
    abstract protected function I_can_create_skill_point_by_related_property_increase();

    /**
     * @param string $professionName
     *
     * @return \Mockery\MockInterface|ProfessionFirstLevel
     */
    protected function createProfessionFirstLevel($professionName = '')
    {
        $professionLevel = $this->mockery(ProfessionFirstLevel::class);
        $professionLevel->shouldReceive('getLevelRank')
            ->andReturn($levelRank = $this->mockery(LevelRank::class));
        $levelRank->shouldReceive('getValue')
            ->andReturn(1);
        if ($professionName) {
            $professionLevel->shouldReceive('getProfession')
                ->andReturn($profession = $this->mockery(Profession::class));
            $profession->shouldReceive('getValue')
                ->andReturn($professionName);
        }

        return $professionLevel;
    }

    /**
     * @param int $skillPointsValue
     * @param string $getterName
     *
     * @return \Mockery\MockInterface|BackgroundSkillPoints
     */
    protected function createBackgroundSkills($skillPointsValue, $getterName)
    {
        $backgroundSKills = $this->mockery(BackgroundSkillPoints::class);
        $backgroundSKills->shouldReceive($getterName)
            ->with(\Mockery::type(Profession::class), \Mockery::type(Tables::class))
            ->atLeast()->once()
            ->andReturn($skillPointsValue);

        return $backgroundSKills;
    }

    /**
     * @param bool $paidByBackgroundPoints
     * @param bool $paidByNextLevelPropertyIncrease
     * @param bool $paidByOtherSkillPoints
     *
     * @return \Mockery\MockInterface|PhysicalSkillPoint
     */
    protected function createPhysicalSkillPoint(
        $paidByBackgroundPoints = true, $paidByNextLevelPropertyIncrease = false, $paidByOtherSkillPoints = false
    )
    {
        return $this->createSkillPoint(
            PhysicalSkillPoint::class, 'foo physical', $paidByBackgroundPoints, $paidByNextLevelPropertyIncrease, $paidByOtherSkillPoints
        );
    }

    /**
     * @param $skillPointClass
     * @param $typeName
     * @param $paidByBackgroundPoints
     * @param bool $isPaidByNextLevelPropertyIncrease
     * @param bool $isPaidByOtherSkillPoints
     * @return \Mockery\MockInterface|SkillPoint
     */
    private function createSkillPoint(
        $skillPointClass,
        $typeName,
        $paidByBackgroundPoints,
        $isPaidByNextLevelPropertyIncrease = false,
        $isPaidByOtherSkillPoints = false
    )
    {
        $skillPoint = $this->mockery($skillPointClass);
        $skillPoint->shouldReceive('isPaidByFirstLevelBackgroundSkillPoints')
            ->andReturn($paidByBackgroundPoints);
        $skillPoint->shouldReceive('getTypeName')
            ->andReturn($typeName);
        $skillPoint->shouldReceive('isPaidByNextLevelPropertyIncrease')
            ->andReturn($isPaidByNextLevelPropertyIncrease);
        $skillPoint->shouldReceive('isPaidByOtherSkillPoints')
            ->andReturn($isPaidByOtherSkillPoints);

        return $skillPoint;
    }

    /**
     * @param bool $paidByBackgroundPoints
     * @param bool $paidByNextLevelPropertyIncrease
     * @param bool $paidByOtherSkillPoints
     *
     * @return \Mockery\MockInterface|CombinedSkillPoint
     */
    protected function createCombinedSkillPoint(
        $paidByBackgroundPoints = true, $paidByNextLevelPropertyIncrease = false, $paidByOtherSkillPoints = false
    )
    {
        return $this->createSkillPoint(
            CombinedSkillPoint::class, 'foo combined', $paidByBackgroundPoints, $paidByNextLevelPropertyIncrease, $paidByOtherSkillPoints
        );
    }

    /**
     * @param bool $paidByBackgroundPoints
     * @param bool $paidByNextLevelPropertyIncrease
     * @param bool $paidByOtherSkillPoints
     *
     * @return \Mockery\MockInterface|PsychicalSkillPoint
     */
    protected function createPsychicalSkillPoint(
        $paidByBackgroundPoints = true, $paidByNextLevelPropertyIncrease = false, $paidByOtherSkillPoints = false
    )
    {
        return $this->createSkillPoint(
            PsychicalSkillPoint::class, 'foo psychical', $paidByBackgroundPoints, $paidByNextLevelPropertyIncrease, $paidByOtherSkillPoints
        );
    }

    /**
     * @param $firstPropertyClass
     * @param bool $secondPropertyClass
     * @param bool $withPropertyIncrement
     * @return \Mockery\MockInterface|ProfessionNextLevel
     */
    protected function createProfessionNextLevel(
        $firstPropertyClass, $secondPropertyClass, $withPropertyIncrement = true
    )
    {
        $professionLevel = $this->mockery(ProfessionNextLevel::class);
        $professionLevel->shouldReceive('get' . $this->parsePropertyName($firstPropertyClass) . 'Increment')
            ->andReturn($willIncrement = $this->mockery($firstPropertyClass));
        $willIncrement->shouldReceive('getValue')
            ->andReturn($withPropertyIncrement ? 1 : 0);
        $professionLevel->shouldReceive('get' . $this->parsePropertyName($secondPropertyClass) . 'Increment')
            ->andReturn($intelligenceIncrement = $this->mockery($secondPropertyClass));
        $intelligenceIncrement->shouldReceive('getValue')
            ->andReturn($withPropertyIncrement ? 1 : 0);
        $professionLevel->shouldReceive('getProfession')
            ->andReturn($profession = $this->mockery(Profession::class));
        $profession->shouldReceive('getValue')
            ->andReturn('foo');
        $professionLevel->shouldReceive('getLevelRank')
            ->andReturn($levelRank = $this->mockery(LevelRank::class));
        $levelRank->shouldReceive('getValue')
            ->andReturn(2);

        return $professionLevel;
    }

    private function parsePropertyName($propertyClass)
    {
        return basename(str_replace('\\', '/', $propertyClass));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\EmptyFirstLevelBackgroundSkillPoints
     */
    public function I_can_not_create_skill_point_by_poor_first_level_background()
    {
        DeAbstractedSkillPoint::createFromFirstLevelBackgroundSkillPoints(
            $this->createProfessionFirstLevel('foo'),
            $this->createBackgroundSkills(0, 'getPhysicalSkillPoints'),
            new Tables()
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\ProhibitedOriginOfPaidBySkillPoint
     * @dataProvider provideInvalidPayment
     * @param $firstPaidByBackgroundPoints
     * @param $secondPaidByBackgroundPoints
     */
    public function I_can_not_create_skill_point_by_non_first_level_other_skill_point(
        $firstPaidByBackgroundPoints, $secondPaidByBackgroundPoints
    )
    {
        DeAbstractedSkillPoint::createFromFirstLevelCrossTypeSkillPoints(
            $this->createProfessionFirstLevel('foo'),
            $this->createCombinedSkillPoint($firstPaidByBackgroundPoints, true, true),
            $this->createCombinedSkillPoint($secondPaidByBackgroundPoints, true, true),
            new Tables()
        );
    }

    public function provideInvalidPayment()
    {
        return [
            [true, false],
            [true, false],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\NonSensePaymentBySameType
     */
    public function I_can_not_pay_for_skill_point_by_same_type_skill_point()
    {
        $sameTypeSkillPoint = $this->createSkillPoint(
            DeAbstractedSkillPoint::class,
            DeAbstractedSkillPoint::TYPE_NAME,
            true
        );
        $sameTypeSkillPoint->shouldReceive('getProfessionFirstLevel')
            ->andReturn($this->createProfessionFirstLevel('baz'));
        $sameTypeSkillPoint->shouldReceive('getProfessionNextLevel')
            ->andReturnNull();
        $sameTypeSkillPoint->shouldDeferMissing();

        DeAbstractedSkillPoint::createFromFirstLevelCrossTypeSkillPoints(
            $this->createProfessionFirstLevel('bar'),
            $sameTypeSkillPoint,
            $this->createPhysicalSkillPoint(),
            new Tables()
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\MissingPropertyAdjustmentForPayment
     */
    public function I_can_not_pay_for_skill_point_by_next_level_without_property_increment()
    {
        DeAbstractedSkillPoint::createFromNextLevelPropertyIncrease(
            $this->createProfessionNextLevel(Strength::class, Agility::class, false),
            new Tables()
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\UnknownPaymentForSkillPoint
     */
    public function I_had_to_provide_some_level_to_create_a_point()
    {
        new DeAbstractedSkillPoint(1, $this->createProfessionFirstLevel('foo'), new Tables());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\UnknownPaymentForSkillPoint
     */
    public function I_had_to_provide_some_skill_points_payment_to_create_a_point()
    {
        new DeAbstractedSkillPoint(1, $this->createProfessionFirstLevel('foo'), new Tables());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\UnexpectedSkillPointValue
     * @expectedExceptionMessageRegExp ~2~
     */
    public function I_can_not_create_skill_point_with_higher_value_than_one()
    {
        new DeAbstractedSkillPoint(2, $this->createProfessionFirstLevel('bar'), new Tables());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\UnexpectedSkillPointValue
     * @expectedExceptionMessageRegExp ~-1~
     */
    public function I_can_not_create_skill_point_with_lesser_value_than_zero()
    {
        new DeAbstractedSkillPoint(-1, $this->createProfessionFirstLevel('bar'), new Tables());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\InvalidRelatedProfessionLevel
     */
    public function I_can_not_create_non_zero_skill_point_with_profession_zero_level()
    {
        new DeAbstractedSkillPoint(1, ProfessionZeroLevel::createZeroLevel(Commoner::getIt()), new Tables());
    }

}

/** inner */
class DeAbstractedSkillPoint extends SkillPoint
{
    const TYPE_NAME = 'foo';

    public function __construct(
        $skillPointValue,
        ProfessionLevel $professionLevel,
        Tables $tables = null,
        BackgroundSkillPoints $backgroundSkillPoints = null,
        SkillPoint $firstPaidOtherSkillPoint = null,
        SkillPoint $secondPaidOtherSkillPoint = null
    )
    {
        parent::__construct($skillPointValue, $professionLevel, $tables, $backgroundSkillPoints, $firstPaidOtherSkillPoint, $secondPaidOtherSkillPoint);
    }

    public function getTypeName()
    {
        return self::TYPE_NAME;
    }

    public function getRelatedProperties()
    {
        return [Strength::STRENGTH, Agility::AGILITY];
    }

}