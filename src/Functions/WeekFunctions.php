<?php

namespace SygicTravel\HolidaysCalculator\Functions;

use DateTimeImmutable;


class WeekFunctions
{
	public static function toMondayIfSunday(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$weekDay = (int) $dateTime->format('w');
		if ($weekDay === 0) {
			return $dateTime->modify('+1 day');
		} else {
			return $dateTime;
		}
	}


	public static function toMondayIfWeekend(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$weekDay = (int) $dateTime->format('w');
		if ($weekDay === 0) {
			return $dateTime->modify('+1 day');
		} elseif ($weekDay === 6) {
			return $dateTime->modify('+2 day');
		} else {
			return $dateTime;
		}
	}


	public static function toWeekdayIfBoxingWeekend(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$weekDay = (int) $dateTime->format('w');
		if ($weekDay === 6 || $weekDay === 0) {
			return $dateTime->modify('+2 day');
		} elseif ($weekDay === 1) {
			// https://github.com/holidays/holidays/issues/27
			return $dateTime->modify('+1 day');
		} else {
			return $dateTime;
		}
	}


	public static function toWeekdayIfBoxingWeekendFromYear(int $year): DateTimeImmutable
	{
		return self::toWeekdayIfBoxingWeekend(new DateTimeImmutable("$year-12-26"));
	}


	public static function toWeekdayIfWeekend(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$weekDay = (int) $dateTime->format('w');
		if ($weekDay === 0) {
			return $dateTime->modify('+1 day');
		} elseif ($weekDay === 6) {
			return $dateTime->modify('-1 day');
		} else {
			return $dateTime;
		}
	}


	public static function closestMonday(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$weekDay = (int) $dateTime->format('w');
		if (in_array($weekDay, [1, 2, 3, 4], true)) {
			if ($dateTime->format('Y-m-d') === '2017-02-01') {
				dump($dateTime->modify('- ' . ($weekDay - 1) . ' day'));
			}
			return $dateTime->modify('- ' . ($weekDay - 1) . ' day');
		} elseif ($weekDay === 0) {
			return $dateTime->modify('+ 1 day');
		} else {
			return $dateTime->modify('+ ' . (8 - $weekDay) . ' day');
		}
	}


	public static function previousFriday(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		$previousFriday = strtotime('previous friday', $dateTime->getTimestamp());
		return new DateTimeImmutable('@' . $previousFriday);
	}


	public static function nextWeek(DateTimeImmutable $dateTime): DateTimeImmutable
	{
		return $dateTime->modify('+ 7 days');
	}
}
