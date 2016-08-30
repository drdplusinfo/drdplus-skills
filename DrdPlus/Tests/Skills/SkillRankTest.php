<?php
namespace DrdPlus\Tests\Skills;

use DrdPlus\Person\ProfessionLevels\ProfessionFirstLevel;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Skills\Skill;
use DrdPlus\Skills\SkillPoint;
use DrdPlus\Skills\SkillRank;
use Granam\Integer\PositiveInteger;
use Mockery\MockInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class SkillRankTest extends TestWithMockery
{

    /**
     * @test
     * @dataProvider allowedSkillRankValues
     * @param int $skillRankValue
     */
    public function I_can_create_skill_rank($skillRankValue)
    {
        $sutClass = $this->getSutClass();
        /** @var SkillRank $skillRank */
        $skillRank = new $sutClass(
            $this->createOwningSkill(),
            $skillPoint = $this->createSkillPoint(),
            $this->createRequiredRankValue($skillRankValue)
        );

        self::assertNull($skillRank->getId());
        self::assertSame($skillRankValue, $skillRank->getValue());
        self::assertSame("$skillRankValue", (string)$skillRank);
        self::assertSame($skillPoint->getProfessionLevel(), $skillRank->getProfessionLevel());
        self::assertSame($skillPoint, $skillRank->getSkillPoint());
    }

    public function allowedSkillRankValues()
    {
        return [[0], [1], [2], [3]];
    }

    /**
     * @return string|SkillRank
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', static::class);
    }

    /**
     * @return Skill
     */
    abstract protected function createOwningSkill();

    protected function addProfessionLevelGetter(MockInterface $mock)
    {
        $mock->shouldReceive('getProfessionLevel')
            ->andReturn($this->mockery(ProfessionLevel::class));
    }

    /**
     * @return MockInterface|ProfessionFirstLevel
     */
    protected function createProfessionFirstLevel()
    {
        return $this->mockery(ProfessionFirstLevel::class);
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function I_can_not_create_negative_skill_rank()
    {
        /** @var  $sutClass */
        $sutClass = $this->getSutClass();
        new $sutClass(
            $this->createOwningSkill(),
            $this->createSkillPoint(),
            $this->createRequiredRankValue(-1)
        );
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function I_can_not_create_skill_rank_with_value_of_four()
    {
        $sutClass = $this->getSutClass();
        new $sutClass(
            $this->createOwningSkill(),
            $this->createSkillPoint(),
            $this->createRequiredRankValue(4)
        );
    }

    /**
     * @return \Mockery\MockInterface|SkillPoint
     */
    abstract protected function createSkillPoint();

    /**
     * @param int $value
     * @return \Mockery\MockInterface|PositiveInteger
     */
    private function createRequiredRankValue($value)
    {
        $requiredRankValue = $this->mockery(PositiveInteger::class);
        $requiredRankValue->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturn($value);

        return $requiredRankValue;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\CanNotVerifyOwningSkill
     */
    public function Skill_has_to_be_set_in_descendant_constructor_first()
    {
        /** @var PositiveInteger $requiredRankValue */
        $requiredRankValue = $this->mockery(PositiveInteger::class);

        new BrokenBecauseOfSkillNotSetInConstructor(
            $this->createOwningSkill(),
            $this->createSkillPoint(),
            $requiredRankValue
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Skills\Exceptions\CanNotVerifyPaidSkillPoint
     */
    public function Skill_point_has_to_be_set_in_descendant_constructor_first()
    {
        /** @var PositiveInteger $requiredRankValue */
        $requiredRankValue = $this->mockery(PositiveInteger::class);

        new BrokenBecauseOfSkillPointNotSetInConstructor(
            $this->createOwningSkill(),
            $this->createSkillPoint(),
            $requiredRankValue
        );
    }
}

class BrokenBecauseOfSkillNotSetInConstructor extends SkillRank
{
    public function __construct(
        Skill $owningSkill,
        SkillPoint $skillPoint,
        PositiveInteger $requiredRankValue
    )
    {
        parent::__construct($owningSkill, $skillPoint, $requiredRankValue);
    }

    public function getSkillPoint()
    {
    }

    public function getSkill()
    {
    }

}

class BrokenBecauseOfSkillPointNotSetInConstructor extends SkillRank
{
    private $skill;

    public function __construct(
        Skill $owningSkill,
        SkillPoint $skillPoint,
        PositiveInteger $requiredRankValue
    )
    {
        $this->skill = $owningSkill;
        parent::__construct($owningSkill, $skillPoint, $requiredRankValue);
    }

    public function getSkillPoint()
    {
    }

    public function getSkill()
    {
        return $this->skill;
    }

}