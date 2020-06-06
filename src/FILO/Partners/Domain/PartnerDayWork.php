<?php

namespace Filo\Partners\Domain;

use src\Shared\Domain\Utils;

class PartnerDayWork
{
    private string $id;
    private string $startTime;
    private string $endTime;
    private string $day;
    private int $dayId;
    public function __construct(string $startTime, string $endTime, string $day, int $dayId, string $id = "0")
    {
        $this->EndTimeLessThanStartTime($startTime, $endTime);
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->day = $day;
        $this->dayId = $dayId;
    }
    public function dayId(): int
    {
        return $this->dayId;
    }
    private function EndTimeLessThanStartTime(string $startTime, string $endTime)
    {
        $startTimeDate = Utils::stringToDate($startTime);
        $endTimeDate = Utils::stringToDate($endTime);
    }
    public function day(): string
    {
        return $this->day;
    }
    public function startTime(): string
    {
        return $this->startTime;
    }
    public function endTime(): string
    {
        return $this->endTime;
    }
    public function id(): string
    {
        return $this->id;
    }
}
