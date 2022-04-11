<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Utility;
use vaniacarta74\Sourcerer\tests\classes\Callback;

/**
 * Description of UtilityTest
 *
 * @author Vania
 */
class UtilityTest extends TestCase
{
    
    private $callbackObj;
    
    protected function setUp() : void
    {
        $this->callbackObj = new Callback();
    }
    
    protected function tearDown() : void
    {
        $this->callbackObj = null;
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::benchmark
     */
    public function testBenchmarkOraEquals() : void
    {
        $dateTimeOra = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
        $dateTimeOra->sub(new \DateInterval('PT2H'));
        $date = $dateTimeOra->format('Y-m-d H:i:s.u');
        
        $actual = Utility::benchmark($date);
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 74) {
            $this->assertMatchesRegularExpression('/^([1-9]\s(ora)[,]\s([1-5]?[0-9])\s(min)\s[e]\s([1-5]?[0-9])\s(sec))$/', $actual);
        } else {
            $this->assertRegExp('/^([1-9]\s(ora)[,]\s([1-5]?[0-9])\s(min)\s[e]\s([1-5]?[0-9])\s(sec))$/', $actual);
        }
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::benchmark
     */
    public function testBenchmarkMinEquals() : void
    {
        $dateTimeMin = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
        $dateTimeMin->sub(new \DateInterval('PT30M'));
        $date = $dateTimeMin->format('Y-m-d H:i:s.u');
        
        $actual = Utility::benchmark($date);
                
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 74) {
            $this->assertMatchesRegularExpression('/^(([1-9]|[1-5][0-9])\s(min)\s[e]\s([1-5]?[0-9])\s(sec))$/', $actual);
        } else {
            $this->assertRegExp('/^(([1-9]|[1-5][0-9])\s(min)\s[e]\s([1-5]?[0-9])\s(sec))$/', $actual);
        }
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::benchmark
     */
    public function testBenchmarkSecEquals() : void
    {
        $dateTimeSec = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
        $dateTimeSec->sub(new \DateInterval('PT10S'));
        $date = $dateTimeSec->format('Y-m-d H:i:s.u');
        
        $actual = Utility::benchmark($date);
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 74) {
            $this->assertMatchesRegularExpression('/^(([1-5]?[0-9])[,][0-9]{3}\s(sec))$/', $actual);
        } else {
            $this->assertRegExp('/^(([1-5]?[0-9])[,][0-9]{3}\s(sec))$/', $actual);
        }
        
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::benchmark
     */
    public function testBenchmarkException() : void
    {
        $date = '31/02/2020';
        
        $this->expectException(\Exception::class);
        
        Utility::benchmark($date);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackFunctionEquals() : void  
    {        
        $funzione = 'testFunction';
        
        $params = 'pippo';        
        
        $expected = 'pippo';
        
        $actual = Utility::callback($funzione, array($params));
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackMethodEqualsA() : void  
    {        
        $method = array($this->callbackObj, 'myStaticMethod');
        
        $expected = 'Hello World Static!';
        
        $actual = Utility::callback($method, array());
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackMethodEqualsB() : void  
    {        
        $method = array($this->callbackObj, 'myPublicMethod');
        
        $expected = 'Hello World Public!';
        
        $actual = Utility::callback($method, array());
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackMethodEqualsC() : void  
    {        
        $method = '\vaniacarta74\Sourcerer\tests\classes\Callback::myStaticMethod';
        
        $expected = 'Hello World Static!';
        
        $actual = Utility::callback($method, array());
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackMethodEqualsD() : void  
    {        
        $method = array($this->callbackObj, 'myPublicMethodWithParams');
        
        $param = 'Hello World Param!';
        
        $expected = 'Hello World Param!';
        
        $actual = Utility::callback($method, array($param));
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackMethodEqualsE() : void  
    {        
        $method = '\vaniacarta74\Sourcerer\tests\classes\Callback::myStaticMethodWithParams';
        
        $param = 'Hello World Param!';
        
        $expected = 'Hello World Param!';
        
        $actual = Utility::callback($method, array($param));
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group utility
     * @covers \vaniacarta74\Sourcerer\api\Utility::callback
     */
    public function testCallbackException() : void
    {
        
        $funzione = 'pippo';
        
        $params = 'paperino';
        
        $this->expectException(\Exception::class);
        
        Utility::callback($funzione, array($params));
    }
}
