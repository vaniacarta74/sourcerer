<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Tools;


/**
 * Description of AccessorTest
 *
 * @author Vania
 */
class ToolsTest extends TestCase
{
    
    /**
     * @group sanitizer
     * @coversNothing
     */
    public function convertUrlProviderA() : array
    {
        $data = [
            'classic url' => [
                'paramName' => 'file',
                'filterInput' => [
                    'params' => [
                        [
                            'type' => INPUT_GET,
                            'paramName' => 'file',
                            'filter' => FILTER_DEFAULT,
                            'options' => 0
                        ],
                        [
                            'type' => INPUT_SERVER,
                            'paramName' => 'REQUEST_URI',
                            'filter' => FILTER_DEFAULT,
                            'options' => 0
                        ],
                        [
                            'type' => INPUT_SERVER,
                            'paramName' => 'PHP_SELF',
                            'filter' => FILTER_DEFAULT,
                            'options' => 0
                        ]
                    ],
                    'returns' => [
                        'telecontrollo_classico',
                        '/sourcerer/sourcerer.git/public/index.php?file=telecontrollo_classico',
                        '/sourcerer/sourcerer.git/public/index.php'
                    ]
                ],
                'expected' => '/source/api/telecontrollo_classico/'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Tools::convertUrl
     * @dataProvider convertUrlProviderA
     */
    public function testConvertUrlEqualsA(string $paramName, array $filterInput, string $expected) : void
    {
                
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterInput'])
                    ->getMock();                    

        $mock->expects($this->exactly(3))
            ->method('filterInput')
            ->withConsecutive(
                $filterInput['params'][0],
                $filterInput['params'][1],
                $filterInput['params'][2]
            )
            ->willReturnOnConsecutiveCalls(
                $filterInput['returns'][0],
                $filterInput['returns'][1],
                $filterInput['returns'][2]
            );
    
        $actual = Tools::convertUrl($paramName, $mock); 

        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group sanitizer
     * @coversNothing
     */
    public function convertUrlProviderB() : array
    {
        $data = [
            'restful url' => [
                'paramName' => 'file',
                'sanitizer' => [
                    'params' => [
                        'file',
                        'REQUEST_URI'
                    ],
                    'returns' => [
                        null,
                        '/source/api/telecontrollo_classico/'
                    ]
                ],
                'expected' => '/source/api/telecontrollo_classico/'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Tools::convertUrl
     * @dataProvider convertUrlProviderB
     */
    public function testConvertUrlEqualsB(string $paramName, array $sanitizer, string $expected) : void
    {
                
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterGet', 'filterServer'])
                    ->getMock();                    

        $mock->method('filterGet')
            ->with($sanitizer['params'][0])
            ->willReturn($sanitizer['returns'][0]);
        
        $mock->method('filterServer')
            ->with($sanitizer['params'][1])
            ->willReturn($sanitizer['returns'][1]);
    
        $actual = Tools::convertUrl($paramName, $mock); 

        $this->assertEquals($expected, $actual);
    }

    /**
     * @group sanitizer
     * @coversNothing
     */
    public function convertUrlExceptionProvider() : array
    {
        $data = [
            'classic url no param' => [
                'paramName' => 'file',
                'sanitizer' => [
                    'params' => [
                        'file',
                        'REQUEST_URI'
                    ],
                    'returns' => [
                        null,
                        '/source/index.php'
                    ]
                ],
                'expected' => '/source/index.php'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Tools::convertUrl
     * @dataProvider convertUrlExceptionProvider
     */
    public function testConvertUrlException(string $paramName, array $sanitizer, string $expected) : void
    {
        $this->expectException(\Exception::class);
        
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterGet', 'filterServer'])
                    ->getMock();                    

        $mock->method('filterGet')
            ->with($sanitizer['params'][0])
            ->willReturn($sanitizer['returns'][0]);
        
        $mock->method('filterServer')
            ->with($sanitizer['params'][1])
            ->willReturn($sanitizer['returns'][1]);
    
        Tools::convertUrl($paramName, $mock);
    }
}
