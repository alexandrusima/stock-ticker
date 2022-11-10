<?php

namespace Tests\Unit\Services\Communication\Mapping;

use PHPUnit\Framework\TestCase;
use App\Services\Communication\Mapping\Mapper;
use App\Services\Communication\Mapping\MappingInterface;

class MapperTest extends TestCase
{
    /**
     * @test
     * @testdox Mapper::class implements Mapper .
     */
    public function implementsInterface(): void
    {
        $int = class_implements(Mapper::class, true) ?? [];

        $this->assertContains(MappingInterface::class, $int);
    }

    /**
     * @test
     * @testdox Sending empty config array thorws \InvalidArgumentException.
     */
    public function noConfigureRetunsExpected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $mapper = new Mapper([]);
    }

    
    /**
     * @test 
     * @testdox Configured works as expected.
     */
    public function configureRetunsExpected(): void
    {
        $mapper = new Mapper(
            [
                0 => 1, 
                1 => 0
            ]
        );


         $ret = $mapper->map([0 => 'apple', 1 => 'bannana']);

         $this->assertEquals('bannana', $ret[0]);
         $this->assertEquals('apple', $ret[1]);

         $ret = $mapper->map([0 => 'apple']);
        
         $this->assertNull($ret[0]);
         $this->assertEquals('apple', $ret[1]);
    }
}
