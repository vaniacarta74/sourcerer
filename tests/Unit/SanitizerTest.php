<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;


/**
 * Description of AccessorTest
 *
 * @author Vania
 */
class SanitizerTest extends TestCase
{
    
    /**
     * @group sanitizer
     * @coversNothing
     */
    public function filterGetProvider() : array
    {
        $data = [
            'telecontrollo_classico' => [
                'paramName' => 'file',
                'filter' => FILTER_DEFAULT,
                'option' => 0,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterGet
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterInput
     * @dataProvider filterGetProvider
     */
    public function testFilterGetEquals(string $paramName, int $filterRaw, int $optionsRaw, string $paramValue, string $expected) : void
    {
                
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterInput'])
                    ->getMock();
        
        $mock->method('filterInput')
            ->with(INPUT_GET, $paramName, $filterRaw, $optionsRaw)
            ->willReturnCallback(function() use ($paramName, $filterRaw, $optionsRaw) {
                if (!isset($_GET[$paramName])) {
                    return null;
                }
                $filter = $filterRaw ?? FILTER_DEFAULT;
                $options = $optionsRaw ?? 0;
                return filter_var($_GET[$paramName], $filter, $options);
            });

        $_GET[$paramName] = $paramValue;
        $actual = $mock->filterGet($paramName, $filterRaw, $optionsRaw); 

        $this->assertEquals($expected, $actual);
    }

    /**
     * @group sanitizer
     * @coversNothing
     */
    public function filterGetExceptionProvider() : array
    {
        $data = [
            'option out of range' => [
                'paramName' => 'file',
                'filter' => FILTER_DEFAULT,
                'option' => -1,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ],
            'return null' => [
                'paramName' => 'file',
                'filter' => FILTER_DEFAULT,
                'option' => 0,
                'paramValue' => null,
                'expected' => 'telecontrollo_classico'
            ],
            'return false' => [
                'paramName' => 'file',
                'filter' => FILTER_VALIDATE_BOOL,
                'option' => 0,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterGet
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterInput
     * @dataProvider filterGetExceptionProvider
     */
    public function testFilterGetExceptionEquals(string $paramName, int $filterRaw, int $optionsRaw, ?string $paramValue) : void
    {
        $this->expectException(\Exception::class);
        
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterInput'])
                    ->getMock();
        
        $mock->method('filterInput')
            ->with(INPUT_GET, $paramName, $filterRaw, $optionsRaw)
            ->willReturnCallback(function() use ($paramName, $filterRaw, $optionsRaw) {
                if (!isset($_GET[$paramName])) {
                    return null;
                }
                $filter = $filterRaw ?? FILTER_DEFAULT;
                $options = $optionsRaw ?? 0;
                return filter_var($_GET[$paramName], $filter, $options);
            });

        $_GET[$paramName] = $paramValue;
        $mock->filterGet($paramName, $filterRaw, $optionsRaw); 
    }

    /**
     * @group sanitizer
     * @coversNothing
     */
    public function filterServerProvider() : array
    {
        $data = [
            'request_uri' => [
                'paramName' => 'REQUEST_URI',
                'filter' => FILTER_DEFAULT,
                'option' => 0,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ],
            'php_self' => [
                'paramName' => 'PHP_SELF',
                'filter' => FILTER_DEFAULT,
                'option' => 0,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterServer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterInput
     * @dataProvider filterServerProvider
     */
    public function testFilterServerEquals(string $paramName, int $filterRaw, int $optionsRaw, string $paramValue, string $expected) : void
    {
                
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterInput'])
                    ->getMock();
        
        $mock->method('filterInput')
            ->with(INPUT_SERVER, $paramName, $filterRaw, $optionsRaw)
            ->willReturnCallback(function() use ($paramName, $filterRaw, $optionsRaw) {
                if (!isset($_SERVER[$paramName])) {
                    return null;
                }
                $filter = $filterRaw ?? FILTER_DEFAULT;
                $options = $optionsRaw ?? 0;
                return filter_var($_SERVER[$paramName], $filter, $options);
            });

        $_SERVER[$paramName] = $paramValue;
        $actual = $mock->filterServer($paramName, $filterRaw, $optionsRaw); 

        $this->assertEquals($expected, $actual);
    }

    /**
     * @group sanitizer
     * @coversNothing
     */
    public function filterServerExceptionProvider() : array
    {
        $data = [
            'option out of range' => [
                'paramName' => 'PHP_SELF',
                'filter' => FILTER_DEFAULT,
                'option' => -1,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ],
            'return null' => [
                'paramName' => 'PHP_SELF',
                'filter' => FILTER_DEFAULT,
                'option' => 0,
                'paramValue' => null,
                'expected' => 'telecontrollo_classico'
            ],
            'return false' => [
                'paramName' => 'PHP_SELF',
                'filter' => FILTER_VALIDATE_BOOL,
                'option' => 0,
                'paramValue' => 'telecontrollo_classico',
                'expected' => 'telecontrollo_classico'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sanitizer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterServer
     * @covers \vaniacarta74\Sourcerer\api\Sanitizer::filterInput
     * @dataProvider filterServerExceptionProvider
     */
    public function testFilterServerExceptionEquals(string $paramName, int $filterRaw, int $optionsRaw, ?string $paramValue) : void
    {
        $this->expectException(\Exception::class);
        
        $mock = $this->getMockBuilder('\vaniacarta74\Sourcerer\api\Sanitizer')
                    ->setMethods(['filterInput'])
                    ->getMock();
        
        $mock->method('filterInput')
            ->with(INPUT_SERVER, $paramName, $filterRaw, $optionsRaw)
            ->willReturnCallback(function() use ($paramName, $filterRaw, $optionsRaw) {
                if (!isset($_SERVER[$paramName])) {
                    return null;
                }
                $filter = $filterRaw ?? FILTER_DEFAULT;
                $options = $optionsRaw ?? 0;
                return filter_var($_SERVER[$paramName], $filter, $options);
            });

        $_SERVER[$paramName] = $paramValue;
        $mock->filterServer($paramName, $filterRaw, $optionsRaw); 
    }
}
