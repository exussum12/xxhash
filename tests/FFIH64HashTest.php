<?php
namespace exussum12\xxhash\tests;

use PHPUnit\Framework\TestCase;
use exussum12\xxhash\Ffi\V64;

class FFIH64HashTest extends TestCase
{
    protected V64 $hash;

    public function setUp()
    {
        $this->hash = new V64(0);
    }
    public function testSingleByte()
    {
        $this->assertSame(
            '4fdcca5ddb678139',
            $this->hash->hash('test')
        );
    }

    public function testLeftOverBytes()
    {
        $this->assertSame(
            'b8f97d6e4b71ad0',
            $this->hash->hash('test1')
        );
    }

    public function test16Byes()
    {
        $this->assertSame(
            '539eee07e4f72744',
            $this->hash->hash('testtesttesttest')
        );
    }

    public function test17Byes()
    {
        $this->assertSame(
            'bbcf707044ae361a',
            $this->hash->hash('testtesttesttest1')
        );
    }

    public function testDifferntSeed()
    {
        $hash = new V64(3);

        $this->assertSame(
            '4e75e829de9fa9dd',
            $hash->hash('test')
        );
    }
    public function testStaticCall()
    {
        $this->assertSame(
            '4fdcca5ddb678139',
            V64::hash('test')
        );
    }
}
