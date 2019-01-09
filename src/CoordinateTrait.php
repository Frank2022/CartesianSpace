<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 21:52
 */

namespace Frank2022\CartesianSpace;

use Frank2022\CartesianSpace\exceptions\DimensionException;

/**
 * Trait CoordinateTrait
 * @package Frank2022\CartesianSpace
 */
trait CoordinateTrait
{
    private $coordinates = [];
    /**
     * CoordinateTrait constructor.
     * @param float ...$coordinates
     * @throws DimensionException
     */
    public function __construct(float ...$coordinates)
    {
        if (count($coordinates) < 1) {
            throw new DimensionException('Coordinate object need at least one dimension');
        }
        foreach ($coordinates as $n => $coordinate) {
            $this->coordinates[$n] = (float)$coordinate;
        }
    }

    /**
     * @return int
     */
    public function getDimension(): int
    {
        return count($this->coordinates);
    }

    /**
     * @param int $n
     * @return float
     * @throws DimensionException
     */
    public function getCoordinate(int $n): float
    {
        if (!isset($this->coordinates[$n])) {
            throw new DimensionException('Coordinate object doesn\'t have such dimension');
        }
        return $this->coordinates[$n];
    }
}