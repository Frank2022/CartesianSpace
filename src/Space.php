<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 19:54
 */

namespace Frank2022\CartesianSpace;

use Frank2022\CartesianSpace\interfaces\CoordinateInterface;
use Frank2022\CartesianSpace\exceptions\DimensionException;
use Frank2022\CartesianSpace\exceptions\SpaceException;

/**
 * Class Space
 * Represents multidimentional cartesian space
 * @package Frank2022\CartesianSpace
 */
class Space
{
    const VECTOR_ADDITION   = 'vector-addition';
    const VECTOR_DIFFERENCE = 'vector-difference';
    const VECTOR_PRODUCT    = 'vector-product';

    protected $dimensionNumber;

    /**
     * Space constructor.
     * @param int $dimensionNumber
     * @throws DimensionException
     */
    public function __construct(int $dimensionNumber = 2)
    {
        if ($dimensionNumber < 1) {
            throw new DimensionException('Space should have at least one dimension');
        }
        $this->dimensionNumber = $dimensionNumber;
    }

    /**
     * @return int
     */
    public function getDimension(): int
    {
        return $this->dimensionNumber;
    }

    /**
     * @param Point $pointOne
     * @param Point $pointTwo
     * @return float
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getDistance(Point $pointOne, Point $pointTwo): float
    {
        $vectorCoordinates = $this->calculateVectorOperation($pointOne, $pointTwo, self::VECTOR_DIFFERENCE);
        return sqrt(array_reduce($vectorCoordinates, function(float $carry, float $item) {
            $carry += $item**2;
            return $carry;
        }, 0));
    }

    /**
     * @param Point $pointOne
     * @param Point $pointTwo
     * @return Vector
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getVector(Point $pointOne, Point $pointTwo): Vector
    {
        $vectorCoordinates = $this->calculateVectorOperation($pointTwo, $pointOne, self::VECTOR_DIFFERENCE);
        return new Vector(...$vectorCoordinates);
    }

    /**
     * @param Vector $vectorOne
     * @param Vector $vectorTwo
     * @return Vector
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getVectorAddition(Vector $vectorOne, Vector $vectorTwo): Vector
    {
        $vectorCoordinates = $this->calculateVectorOperation($vectorOne, $vectorTwo, self::VECTOR_ADDITION);
        return new Vector(...$vectorCoordinates);
    }

    /**
     * @param Vector $vectorOne
     * @param Vector $vectorTwo
     * @return Vector
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getVectorDifference(Vector $vectorOne, Vector $vectorTwo): Vector
    {
        $vectorCoordinates = $this->calculateVectorOperation($vectorOne, $vectorTwo, self::VECTOR_DIFFERENCE);
        return new Vector(...$vectorCoordinates);
    }

    /**
     * @param Vector $vectorOne
     * @param Vector $vectorTwo
     * @return float
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getVectorProduct(Vector $vectorOne, Vector $vectorTwo): float
    {
        $vectorCoordinates = $this->calculateVectorOperation($vectorOne, $vectorTwo, self::VECTOR_PRODUCT);
        return array_sum($vectorCoordinates);
    }

    /**
     * @param Vector $vectorOne
     * @param Vector $vectorTwo
     * @return float
     * @throws DimensionException
     * @throws SpaceException
     */
    public function getVectorAngle(Vector $vectorOne, Vector $vectorTwo): float
    {
        $numerator = $this->getVectorProduct($vectorOne, $vectorTwo);
        $denominator = $vectorOne->getLength() * $vectorTwo->getLength();
        return acos($numerator / $denominator);

    }

    /**
     * @param CoordinateInterface $coordinateObjectOne
     * @param CoordinateInterface $coordinateObjectTwo
     * @throws DimensionException
     */
    private function checkDimension(CoordinateInterface $coordinateObjectOne, CoordinateInterface $coordinateObjectTwo)
    {
        if ($coordinateObjectOne->getDimension() != $this->getDimension()) {
            throw new DimensionException('coordinateObjectOne has wrong dimension for this space');
        }
        if ($coordinateObjectTwo->getDimension() != $this->getDimension()) {
            throw new DimensionException('coordinateObjectTwo has wrong dimension for this space');
        }
    }

    /**
     * @param CoordinateInterface $coordinateObjectOne
     * @param CoordinateInterface $coordinateObjectTwo
     * @param string $operation
     * @return array
     * @throws DimensionException
     * @throws SpaceException
     */
    private function calculateVectorOperation(CoordinateInterface $coordinateObjectOne, CoordinateInterface $coordinateObjectTwo, string $operation): array
    {
        $this->checkDimension($coordinateObjectOne, $coordinateObjectTwo);
        $vectorCoordinates = [];
        for ($n = 0; $n < $this->getDimension(); $n++) {
            $coordinateOne = $coordinateObjectOne->getCoordinate($n);
            $coordinateTwo = $coordinateObjectTwo->getCoordinate($n);
            switch ($operation) {
                case self::VECTOR_ADDITION:
                    $vectorCoordinates[$n] = $coordinateOne + $coordinateTwo;
                    break;
                case self::VECTOR_DIFFERENCE:
                    $vectorCoordinates[$n] = $coordinateOne - $coordinateTwo;
                    break;
                case self::VECTOR_PRODUCT:
                    $vectorCoordinates[$n] = $coordinateOne * $coordinateTwo;
                    break;
                default:
                    throw new SpaceException('Wrong vector operation');
                    break;
            }
        }
        return $vectorCoordinates;
    }
}