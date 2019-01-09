<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 19:57
 */

namespace Frank2022\CartesianSpace\tests\unit;

use Frank2022\CartesianSpace\Space;
use Frank2022\CartesianSpace\Vector;
use Frank2022\CartesianSpace\Point;
use Frank2022\CartesianSpace\exceptions\DimensionException;
use Frank2022\CartesianSpace\exceptions\SpaceException;
use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    public function testValidConstruct()
    {
        $this->assertNotNull(new Space());
        $this->assertNotNull(new Space(1));
        $this->assertNotNull(new Space(2));
        $this->assertNotNull(new Space(3));
        $this->assertNotNull(new Space(5));
    }

    public function testInvalidConstructZeroDimension()
    {
        $this->expectException(DimensionException::class);
        (new Space(0));
    }

    public function testInvalidConstructNegativeDimension()
    {
        $this->expectException(DimensionException::class);
        (new Space(-2));
    }

    public function testGetDimension()
    {
        foreach ([1, 2, 3, 5] as $dimensionNumber) {
            $space = new Space($dimensionNumber);
            $this->assertEquals($dimensionNumber, $space->getDimension());
        }
    }

    public function testGetDistance()
    {
        $pointOne = new Point(0, 0);
        $pointTwo = new Point(3, 4);
        $space = new Space(2);
        $this->assertEquals(5, $space->getDistance($pointOne, $pointTwo));

        $pointOne = new Point(0, 0, 0, 0);
        $pointTwo = new Point(0, 3, 4, 0);
        $space = new Space(4);
        $this->assertEquals(5, $space->getDistance($pointOne, $pointTwo));
    }

    public function testGetDistanceWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getDistance', false);
    }

    public function testGetVector()
    {
        $pointOne = new Point(0, 0);
        $pointTwo = new Point(3, 4);
        $space = new Space(2);
        $vector = $space->getVector($pointOne, $pointTwo);
        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertEquals(3, $vector->getCoordinate(0));
        $this->assertEquals(4, $vector->getCoordinate(1));
    }

    public function testGetVectorWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getVector', false);
    }

    public function testGetVectorAddition()
    {
        $vectorOne = new Vector(-3, -4);
        $vectorTwo = new Vector(3, 4);
        $space = new Space(2);
        $vector = $space->getVectorAddition($vectorOne, $vectorTwo);
        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertEquals(0, $vector->getCoordinate(0));
        $this->assertEquals(0, $vector->getCoordinate(1));
    }

    public function testGetVectorAdditionWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getVectorAddition');
    }

    public function testGetVectorDifference()
    {
        $vectorOne = new Vector(-3, -4);
        $vectorTwo = new Vector(3, 4);
        $space = new Space(2);
        $vector = $space->getVectorDifference($vectorOne, $vectorTwo);
        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertEquals(-6, $vector->getCoordinate(0));
        $this->assertEquals(-8, $vector->getCoordinate(1));
    }

    public function testGetVectorDifferenceWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getVectorDifference');
    }

    public function testGetVectorProduct()
    {
        $vectorOne = new Vector(1, 1);
        $vectorTwo = new Vector(3, 4);
        $space = new Space(2);
        $this->assertEquals(7, $space->getVectorProduct($vectorOne, $vectorTwo));
    }

    public function testGetVectorProductWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getVectorProduct');
    }

    public function testGetVectorAngle()
    {
        $vectorOne = new Vector(1, 0);
        $vectorTwo = new Vector(-1, 0);
        $space = new Space(2);
        $this->assertEquals(acos(-1), $space->getVectorAngle($vectorOne, $vectorTwo));
    }

    public function testGetVectorAngleWrongDimensions()
    {
        $this->callExceptionSpaceMethod('getVectorAngle');
    }

    public function testCalculateVectorOperation()
    {
        $class = new \ReflectionClass(Space::class);
        $method = $class->getMethod('calculateVectorOperation');
        $method->setAccessible(true);
        $space = new Space(2);

        $vectorCoordinates = $method->invokeArgs($space, [(new Vector(-3, -4)), (new Vector(3, 4)), Space::VECTOR_ADDITION]);
        $this->assertEquals(0, $vectorCoordinates[0]);
        $this->assertEquals(0, $vectorCoordinates[1]);

        $vectorCoordinates = $method->invokeArgs($space, [(new Vector(-3, -4)), (new Vector(3, 4)), Space::VECTOR_DIFFERENCE]);
        $this->assertEquals(-6, $vectorCoordinates[0]);
        $this->assertEquals(-8, $vectorCoordinates[1]);

        $vectorCoordinates = $method->invokeArgs($space, [(new Vector(1, 1)), (new Vector(3, 4)), Space::VECTOR_PRODUCT]);
        $this->assertEquals(3, $vectorCoordinates[0]);
        $this->assertEquals(4, $vectorCoordinates[1]);
    }

    public function testCalculateVectorOperationWrongOperation()
    {
        $class = new \ReflectionClass(Space::class);
        $method = $class->getMethod('calculateVectorOperation');
        $method->setAccessible(true);
        $space = new Space(2);
        $this->expectException(SpaceException::class);
        $method->invokeArgs($space, [(new Vector(1, 1)), (new Vector(3, 4)), 'wrong-operation']);
    }

    private function callExceptionSpaceMethod(string $method, $isVector = true)
    {
        $objectOne = new Vector(0, 0, 1);
        $objectTwo = new Vector(3, 4);
        if (!$isVector) {
            $objectOne = new Point(0, 0, 1);
            $objectTwo = new Point(3, 4);
        }
        $space = new Space(2);
        $this->expectException(DimensionException::class);
        $space->$method($objectOne, $objectTwo);
    }
}