<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\Validator;

/**
 * Description of ValidatorTest
 *
 * @author adm-gfattori
 */
class ValidatorTest extends TestCase
{
    /**
     * @group sourcerer
     * @coversNothing
     */
    public function validateHostNameProvider(): array
    {
        $data = [
            'domain' => [
                'varName' => 'spt.enas.sardegna.it',
                'expected' => 'spt.enas.sardegna.it'
            ],
            'ipv4' => [
                'varName' => '192.168.30.1',
                'expected' => '192.168.30.1'
            ]
        ];

        return $data;
    }

    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\Validator::validateHostName
     * @dataProvider validateHostNameProvider
     */
    public function testValidateHostNameEquals(string $varName, string $expected): void
    {
        $actual = Validator::validateHostName($varName);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @group sourcerer
     * @coversNothing
     */
    public function validateHostNameExceptionProvider(): array
    {
        $data = [
            'wrong' => [
                'varName' => 'http://'
            ]
        ];

        return $data;
    }

    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\Validator::validateHostName
     * @dataProvider validateHostNameExceptionProvider
     */
    public function testValidateHostNameException(string $varName): void
    {
        $this->expectException(\Exception::class);

        Validator::validateHostName($varName);
    }

    /**
     * @group sourcerer
     * @coversNothing
     */
    public function validateIPv4Provider(): array
    {
        $data = [
            'ipv4' => [
                'varName' => '192.168.30.1',
                'expected' => '192.168.30.1'
            ]
        ];

        return $data;
    }

    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\Validator::validateIPv4
     * @dataProvider validateIPv4Provider
     */
    public function testValidateIPv4Equals(string $varName, string $expected): void
    {
        $actual = Validator::validateIPv4($varName);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @group sourcerer
     * @coversNothing
     */
    public function validateIPv4ExceptionProvider(): array
    {
        $data = [
            'domain' => [
                'varName' => 'spt.enas.sardegna.it'
            ]
        ];

        return $data;
    }

    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\Validator::validateIPv4
     * @dataProvider validateIPv4ExceptionProvider
     */
    public function testValidateIPv4Exception(string $varName): void
    {
        $this->expectException(\Exception::class);

        Validator::validateIPv4($varName);
    }
}
