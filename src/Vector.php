<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 20:34
 */

namespace Frank2022\CartesianSpace;

use Frank2022\CartesianSpace\interfaces\CoordinateInterface;

/**
 * Class Vector
 * @package Frank2022\CartesianSpace
 */
class Vector implements CoordinateInterface
{
    use CoordinateTrait;

    /**
     * @param float $factor
     * @return Vector
     */
    public function scalarMultiply(float $factor): self
    {
        foreach ($this->coordinates as $n => $coordinate) {
            $this->coordinates[$n] *= $factor;
        }
        return $this;
    }

    /**
     * @param float $divider
     * @return Vector
     */
    public function scalarDivide(float $divider): self
    {
        foreach ($this->coordinates as $n => $coordinate) {
            $this->coordinates[$n] /= $divider;
        }
        return $this;
    }

    /**
     * @return float
     */
    public function getLength(): float
    {
        return sqrt(array_sum(array_map(function(float $coordinate) {
            return $coordinate ** 2;
        }, $this->coordinates)));
    }
}