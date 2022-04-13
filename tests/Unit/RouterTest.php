<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Router;
use vaniacarta74\Sourcerer\tests\classes\Reflections;

/**
 * Description of RouterTest
 *
 * @author adm-gfattori
 */
class RouterTest extends TestCase
{
    private $router;
    
    protected function setUp() : void
    {
        $resource = ROOT . 'api/telecontrollo_classico/';
        $this->router = new Router($resource);
    }
    
    protected function tearDown() : void
    {
        $this->router = null;
    }

    /**
     * @group sourcerer
     * @coversNothing
     */
    public function constructorProvider() : array
    {
        $data = [
            'standard' => [
                'resource' => '/source/api/telecontrollo_classico/',
                'expected' => 'telecontrollo_classico.php'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\api\Router::__construct
     * @covers vaniacarta74\Sourcerer\api\Router::setRoute
     * @dataProvider constructorProvider
     */
    public function testConstructorEquals(string $resource, string $expected) : void
    {
        Reflections::invokeConstructor($this->router, array($resource));
        
        $actual = Reflections::getProperty($this->router, 'route');        
        
        $this->assertEquals($expected, $actual);         
    }
    
    /**
     * @group sourcerer
     * @coversNothing
     */
    public function setRouteProvider() : array
    {
        $data = [
            'standard' => [
                'resource' => '/source/api/telecontrollo_classico/',
                'routes' => [
                    'telecontrollo_classico' => [
                        'route' => 'telecontrollo_classico.php',
                        'params' => [
                            'local' => '/telecontrollo/index.asp?MM_Logoutnow=1',
                            'remote' => '/telecontrollo/index.php'
                        ]
                    ]
                ],
                'expected' => true
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\api\Router::setRoute
     * @dataProvider setRouteProvider
     */
    public function testSetRouteEquals(string $resource, array $routes, bool $expected) : void
    {
        $actual = Reflections::invokeMethod($this->router, 'setRoute', array($resource, $routes));
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group sourcerer
     * @coversNothing
     */
    public function setRouteExceptionProvider() : array
    {
        $data = [
            'route not found' => [
                'resource' => '/source/api/camomilla/',
                'routes' => [
                    'telecontrollo_classico' => [
                        'route' => 'telecontrollo_classico.php',
                        'params' => [
                            'local' => '/telecontrollo/index.asp?MM_Logoutnow=1',
                            'remote' => '/telecontrollo/index.php'
                        ]
                    ]
                ]
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group sourcerer
     * @covers vaniacarta74\Sourcerer\api\Router::setRoute
     * @dataProvider setRouteExceptionProvider
     */
    public function testSetRouteException(string $resource, array $routes) : void
    {
        $this->expectException(\Exception::class);
        
        Reflections::invokeMethod($this->router, 'setRoute', array($resource, $routes));
        
    }
}
