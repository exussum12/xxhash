<?php
namespace exussum12\xxhash\tests;

use PHPUnit\Framework\TestCase;
use exussum12\xxhash\Ffi\V32;

class FFIHashTest extends TestCase
{
    protected V32 $hash;

    public function setUp()
    {
        $this->hash = new V32(0);
    }
    public function testSingleByte()
    {
        $this->assertSame(
            '3e2023cf',
            $this->hash->hash('test')
        );
    }

    public function testLeftOverBytes()
    {
        $this->assertSame(
            'a490f2c5',
            $this->hash->hash('test1')
        );
    }

    public function test16Byes()
    {
        $this->assertSame(
            'd935be16',
            $this->hash->hash('testtesttesttest')
        );
    }

    public function test17Byes()
    {
        $this->assertSame(
            '93180678',
            $this->hash->hash('testtesttesttest1')
        );
    }

    public function testDifferntSeed()
    {
        $hash = new V32(3);

        $this->assertSame(
            '340dc2d3',
            $hash->hash('test')
        );
    }
    public function testStaticCall()
    {
        $this->assertSame(
            '3e2023cf',
            V32::hash('test')
        );
    }
}
