<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit(), "Błąd dla temperatury {$celsius}°C");
    }

    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['-0.5', 31.1],
            ['37', 98.6],
            ['25', 77],
            ['-10', 14],
            ['-5', 23],
            ['22.3', 72.1],
        ];
    }
}
