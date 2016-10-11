<?php
namespace DrdPlus\Tests\Skills\Physical;

use DrdPlus\Skills\Physical\Flying;
use DrdPlus\Skills\Physical\PhysicalSkillPoint;
use DrdPlus\Tests\Skills\SkillRankTest;

class PhysicalSkillRankTest extends SkillRankTest
{

    /**
     * @param $value
     * @return \Mockery\MockInterface|PhysicalSkillPoint
     */
    protected function createSkillPoint($value = null)
    {
        $physicalSkillPoint = $this->mockery(PhysicalSkillPoint::class);
        $this->addProfessionLevelGetter($physicalSkillPoint);
        if ($value !== null) {
            $physicalSkillPoint->shouldReceive('getValue')
                ->andReturn($value);
        }

        return $physicalSkillPoint;
    }

    protected function createOwningSkill()
    {
        return new Flying($this->createProfessionFirstLevel());
    }

}