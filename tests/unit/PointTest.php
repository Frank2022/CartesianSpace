<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 22:40
 */

namespace Frank2022\CartesianSpace\tests\unit;

use Frank2022\CartesianSpace\Point;
use Frank2022\CartesianSpace\exceptions\DimensionException;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    private $coordinates = [[1], [1, 0], [1, 0, 2], [1, 0, 2, 3]];

    public function testValidConstruct()
    {
        foreach ($this->coordinates as $coordinates) {
            $this->assertNotNull(new Point(...$coordinates));
        }
    }

    public function testInvalidConstructNoCoordinates()
    {
        $this->expectException(DimensionException::class);
        (new Point());
    }

    public function testGetDimension()
    {
        foreach ($this->coordinates as $coordinates) {
            $vector = new Point(...$coordinates);
            $this->assertEquals(count($coordinates), $vector->getDimension());
        }
    }

    public function testGetValidCoordinate()
    {
        $coordinate = [1, 0, 2, 3];
        $vector = new Point(...$coordinate);
        foreach ([0, 1, 2, 3] as $n) {
            $this->assertEquals($coordinate[$n], $vector->getCoordinate($n));
        }
    }

    public function testGetInvalidCoordinate()
    {
        $vector = new Point(1, 0, 2, 3);
        $this->expectException(DimensionException::class);
        $vector->getCoordinate(4);
    }
}