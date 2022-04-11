<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\Unit;

use PHPUnit\Framework\TestCase;
use vaniacarta74\Sourcerer\api\Curl;

/**
 * Description of CurlTest
 *
 * @author Vania
 */
class CurlTest extends TestCase
{
    /**
     * @group curl
     * @coversNothing
     */
    public function runProvider()
    {
        $data = [            
            'get no params' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php',
                'method' => 'GET',
                'params' => null,
                'json' => null,                
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "GET",
                        "params": null
                    }
                }'
            ],
            'get' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?var=30030&datefrom=01/01/2020',
                'method' => 'GET',
                'params' => null,
                'json' => null,                
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "GET",
                        "params": {
                            "var": "30030",
                            "datefrom": "01/01/2020"
                        }
                    }
                }'
            ],
            'post json' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?json=1',
                'method' => 'POST',
                'params' => [
                    "var" => 10230,
                    "type" => 2,
                    "date" => "01/01/2021",
                    "val" => 3.5
                ],
                'json' => true,
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "POST",
                        "params": {
                            "var": 10230,
                            "type": 2,
                            "date": "01/01/2021",
                            "val": 3.5
                        }
                    }
                }'
            ],
            'post no json' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?json=0',
                'method' => 'POST',
                'params' => [
                    'var' => '10230',
                    'type' => '2',
                    'date' => '01/01/2021',
                    'val' => '3,5'
                ],
                'json' => null,
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "POST",
                        "params": {
                            "var": "10230",
                            "type": "2",
                            "date": "01/01/2021",
                            "val": "3,5"
                        }
                    }
                }'
            ],
            'put' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?val=1.9&date=02/01/2020',
                'method' => 'PUT',
                'params' => null,
                'json' => null,
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "PUT",
                        "params": {
                            "date": "02/01/2020",
                            "val": "1.9"
                        }
                    }
                }'
            ],
            'patch' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?val=0.3&date=03/01/2020',
                'method' => 'PATCH',
                'params' => null,
                'json' => null,
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "PATCH",
                        "params": {
                            "date": "03/01/2020",
                            "val": "0.3"
                        }
                    }
                }'
            ],
            'delete' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?id=999999',
                'method' => 'DELETE',
                'params' => null,
                'json' => null,
                'expected' => '{
                    "ok": true,
                    "response": {
                        "method": "DELETE",
                        "params": {
                            "id": "999999"
                        }
                    }
                }'
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     * @covers \vaniacarta74\Sourcerer\api\Curl::exec
     * @dataProvider runProvider     
     */
    public function testRunEqualsJsonString($url, $method, $params, $json, $expected)
    {
        $actual = Curl::run($url, $method, $params, $json);
        
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     */
    public function testRunPostEquals() : void
    {
        $params = [
            'var' => '30030',
            'datefrom' => '30/12/2019',
            'dateto' => '31/12/2019',
            'field' => 'portata',
            'full' => '0'
        ];
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        $json = false;
        $expected = '{"ok":true,"response":{"method":"POST","params":{"var":"30030","datefrom":"30\/12\/2019","dateto":"31\/12\/2019","field":"portata","full":"0"}}}';
                
        $actual = Curl::run($url, 'POST', $params, $json);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     */
    public function testRunGetEquals() : void
    {
        $url = 'http://localhost/source_tests/providers/curlTest.php?var=30030&datefrom=30/12/2019&dateto=31/12/2019&field=portata&full=0';
        $expected = '{"ok":true,"response":{"method":"GET","params":{"var":"30030","datefrom":"30\/12\/2019","dateto":"31\/12\/2019","field":"portata","full":"0"}}}';
        
        $actual = Curl::run($url);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     */
    public function testRunJsonStringEqualsJsonFile() : void
    {
        $params = [
            'var' => '30030',
            'datefrom' => '23/04/2020',
            'dateto' => '24/04/2020',
            'field' => 'portata',
            'full' => '0'
        ];
        $url = 'http://localhost/source_tests/providers/curlTest.php?json=1';
        $json = true;
        $expected = '{"ok":true,"response":{"method":"POST","params":{"var":"30030","datefrom":"23\/04\/2020","dateto":"24\/04\/2020","field":"portata","full":"0"}}}';
        
        $actual = Curl::run($url, 'POST', $params, $json);
        
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     */
    public function testRunPostException() : void
    {
        $params = [];
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        
        $this->expectException(\Exception::class);
        
        Curl::run($url, 'POST', $params);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::run
     */
    public function testRunException()
    {
        
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        $method = 'POST';
        $params = [];
        
        $this->expectException(\Exception::class);
        
        Curl::run($url, $method, $params);
    }
    
    /**
     * @group curl
     * @coversNothing
     */
    public function setProvider()
    {
        $data = [
            'get no params' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php',
                'method' => 'GET',
                'params' => null,
                'json' => null
            ],
            'get' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?var=30030&datefrom=01/01/2020',
                'method' => 'GET',
                'params' => null,
                'json' => null
            ],
            'post json' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?json=1',
                'method' => 'POST',
                'params' => [
                    "var" => 10230,
                    "type" => 2,
                    "date" => "01/01/2021",
                    "val" => 3.5
                ],
                'json' => true
            ],
            'post no json' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?json=0',
                'method' => 'POST',
                'params' => [
                    "var" => 10230,
                    "type" => 2,
                    "date" => "01/01/2021",
                    "val" => 3.5
                ],
                'json' => null
            ],
            'put' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?val=1.9&date=02/01/2020',
                'method' => 'PUT',
                'params' => null,
                'json' => null
            ],
            'patch' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?val=0.3&date=03/01/2020',
                'method' => 'PATCH',
                'params' => null,
                'json' => null
            ],
            'delete' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php?id=999999',
                'method' => 'DELETE',
                'params' => null,
                'json' => null
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set
     * @dataProvider setProvider     
     */
    public function testSetIsResource($url, $method, $params, $json)
    {
        $ch = Curl::set($url, $method, $params, $json);
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 81) {
            $actual = $ch instanceof \CurlHandle;
        } else {
            $actual = is_resource($ch);
        }
        
        $this->assertTrue($actual);
    }   
        
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set     
     */
    public function testSetPostIsResource()
    {
        $params = [
            'var' => '30030',
            'datefrom' => '30/12/2019',
            'dateto' => '31/12/2019',
            'field' => 'portata',
            'full' => '0'
        ];
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        
        $actual = Curl::set($url, 'POST', $params);
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 81) {
            $this->assertIsObject($actual);
        } else {
            $this->assertIsResource($actual);
        }
        
        return $actual;
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set     
     */
    public function testSetGetIsResource()
    {
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        
        $actual = Curl::set($url, 'GET');
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 81) {
            $this->assertIsObject($actual);
        } else {
            $this->assertIsResource($actual);
        }
        
        return $actual;
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set     
     */
    public function testSetIsJsonIsResource()
    {
        $params = [
            'var' => '30030',
            'datefrom' => '30/12/2019',
            'dateto' => '31/12/2019',
            'field' => 'portata',
            'full' => '0'
        ];
        $url = 'http://localhost/scarichi/tojson.php';
        
        $actual = Curl::set($url, 'POST', $params, true);
        
        if ((PHP_MAJOR_VERSION * 10 + PHP_MINOR_VERSION)>= 81) {
            $this->assertIsObject($actual);
        } else {
            $this->assertIsResource($actual);
        }
        
        return $actual;
    }
    
    /**
     * @group curl
     * @coversNothing
     */
    public function setExceptionProvider()
    {
        $data = [            
            'wrong method' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php',
                'method' => 'PIPPO',
                'params' => null,
                'json' => null
            ],
            'post no params' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php',
                'method' => 'POST',
                'params' => null,
                'json' => null
            ],
            'post void params' => [
                'url' => 'http://localhost/source_tests/providers/curlTest.php',
                'method' => 'POST',
                'params' => [],
                'json' => null
            ]
        ];
        
        return $data;
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set
     * @dataProvider setExceptionProvider
     */
    public function testSetException($url, $method, $params, $json)
    {
        $this->expectException(\Exception::class);
        
        Curl::set($url, $method, $params, $json);
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::set
     */
    public function testSetPostException() : void
    {
        $params = [];
        $url = 'http://localhost/source_tests/providers/curlTest.php';
        
        $this->expectException(\Exception::class);
        
        Curl::set($url, 'POST', $params);
    }   
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::exec
     * @depends testSetPostIsResource
     */
    public function testExecContainsString($ch) : void
    {
        $response = '{"ok":true,"response":{"method":"POST","params":{"var":"30030","datefrom":"30\/12\/2019","dateto":"31\/12\/2019","field":"portata","full":"0"}}}';
        
        $expecteds = explode('|', $response);
        
        $actual = Curl::exec($ch);
        
        foreach ($expecteds as $expected) {
            $this->assertStringContainsString($expected, $actual);
        }
    }
    
    /**
     * @group curl
     * @covers \vaniacarta74\Sourcerer\api\Curl::exec
     */
    public function testExecNullException() : void
    {
        $ch = null;
        
        $this->expectException(\Exception::class);
        
        Curl::exec($ch);
    }   
}
