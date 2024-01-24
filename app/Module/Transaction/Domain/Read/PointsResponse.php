<?php

namespace App\Module\Transaction\Domain\Read;

use App\Shared\Application\Query\Response;

class PointsResponse implements Response
{
    private function __construct(private int $points)
    {
    }

    public static function create(int $points):self
    {
        return new self(
            $points
        );
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
