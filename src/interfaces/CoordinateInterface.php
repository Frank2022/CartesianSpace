<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 21:15
 */

namespace Frank2022\CartesianSpace\interfaces;

/**
 * Interface CoordinateInterface
 * @package Frank2022\CartesianSpace\interfaces
 */
interface CoordinateInterface extends DimensionInterface
{
    /**
     * @param int $n
     * @return float
     */
    public function getCoordinate(int $n): float;
}