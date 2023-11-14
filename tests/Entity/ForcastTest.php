<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Forcast;

class ForcastTest extends TestCase
{
    public function dataGetFahrenheit(): array {
        return [
            ['0', 32],
            ['0.5', 32.9],
            ['7.2', 44.96],
            ['10.3', 50.54],
            ['-17.5', 0.5],
            ['17.5', 63.5],
            ['-100', -148],
            ['-100.1', -148.18],
            ['100', 212],
            ['100.1', 212.18],
        ];
    }
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $testForcastObj = new Forcast();
        $testForcastObj->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $testForcastObj->getFahrenheit());
    }
}
