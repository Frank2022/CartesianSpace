<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 09.01.19
 * Time: 20:11
 */

namespace Frank2022\CartesianSpace;

use Frank2022\CartesianSpace\interfaces\CoordinateInterface;

/**
 * Class Point
 * @package Frank2022\CartesianSpace
 */
class Point implements CoordinateInterface
{
    use CoordinateTrait;
}