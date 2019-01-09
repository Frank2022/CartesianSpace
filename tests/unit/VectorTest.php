<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 22:27
 */

namespace Frank2022\CartesianSpace\tests\unit;

use Frank2022\CartesianSpace\Vector;
use Frank2022\CartesianSpace\exceptions\DimensionException;
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    private $coordinates = [[1], [1, 0], [1, 0, 2], [1, 0, 2, 3]];

    public function testValidConstruct()
    {
        foreach ($this->coordinates as $coordinates) {
            $this->assertNotNull(new Vector(...$coordinates));
        }
    }

    public function testInvalidConstructNoCoordinates()
    {
        $this->expectException(DimensionException::class);
        (new Vector());
    }

    public function testGetDimension()
    {
        foreach ($this->coordinates as $coordinates) {
            $vector = new Vector(...$coordinates);
            $this->assertEquals(count($coordinates), $vector->getDimension());
        }
    }

    public function testGetValidCoordinate()
    {
        $coordinate = [1, 0, 2, 3];
        $vector = new Vector(...$coordinate);
        foreach ([0, 1, 2, 3] as $n) {
            $this->assertEquals($coordinate[$n], $vector->getCoordinate($n));
        }
    }

    public function testGetInvalidCoordinate()
    {
        $vector = new Vector(1, 0, 2, 3);
        $this->expectException(DimensionException::class);
        $vector->getCoordinate(4);
    }

    public function testScalarMultiply()
    {
        $factor = 3;
        foreach ($this->coordinates as $coordinates) {
            $vector = new Vector(...$coordinates);
            $vector->scalarMultiply($factor);
            foreach (range(0, count($coordinates) - 1) as $n) {
                $this->assertEquals($coordinates[$n] * $factor, $vector->getCoordinate($n));
            }
        }
    }

    public function testScalarDivide()
    {
        $divider = 2;
        foreach ($this->coordinates as $coordinates) {
            $vector = new Vector(...$coordinates);
            $vector->scalarDivide($divider);
            foreach (range(0, count($coordinates) - 1) as $n) {
                $this->assertEquals($coordinates[$n] / $divider, $vector->getCoordinate($n));
            }
        }
    }

    public function testGetLength()
    {
        $vector = new Vector(1);
        $this->assertEquals(1, $vector->getLength());
        $vector = new Vector(3, 4);
        $this->assertEquals(5, $vector->getLength());
    }
}