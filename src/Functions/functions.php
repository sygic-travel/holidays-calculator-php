<?php

namespace SygicTravel\HolidaysCalculator\Functions;

use DateTimeImmutable;
use SygicTravel\HolidaysCalculator\Exceptions\NotImplementedException;


return [

	'easter(year)' => [
		['year'],
		function (int $year): DateTimeImmutable {
			$days = easter_days($year);
			$base = new DateTimeImmutable("$year-03-21");
			return $base->modify("+{$days} days");
		},
	],


	'orthodox_easter(year)' => [
		['year'],
		function (int $year): DateTimeImmutable {
			// http://php.net/manual/en/function.easter-date.php#83794
			// todo: take a look at https://www.php.de/forum/webentwicklung/php-fortgeschrittene/115655-western-catholic-und-orthodox-easter-date

			$a = $year % 4;
			$b = $year % 7;
			$c = $year % 19;
			$d = (19 * $c + 15) % 30;
			$e = (2 * $a + 4 * $b - $d + 34) % 7;
			$month = floor(($d + $e + 114) / 31);
			$day = (($d + $e + 114) % 31) + 1;
			$timestamp = mktime(0, 0, 0, $month, $day + 13, $year);

			return new DateTimeImmutable('@' . $timestamp);
		},
	],


	'to_monday_if_sunday(date)' => [
		['date'],
		function (DateTimeImmutable $dateTime): DateTimeImmutable {
			if ($dateTime->format('w') === 0) {
				return $dateTime->modify('+1 day');
			} else {
				return $dateTime;
			}
		}
	],


	'to_monday_if_weekend(date)' => [
		['date'],
		function (DateTimeImmutable $dateTime): DateTimeImmutable {
			$weekDay = $dateTime->format('w');
			if ($weekDay === 0 || $weekDay === 6) {
				return $dateTime->modify('+1 day');
			} else {
				return $dateTime;
			}
		}
	],


	'to_weekday_if_boxing_weekend(date)' => [
		['date'],
		function (DateTimeImmutable $dateTime): DateTimeImmutable {
			throw new NotImplementedException();
		}
	],


	'to_weekday_if_boxing_weekend_from_year(year)' => [
		['year'],
		function (int $year): DateTimeImmutable {
			throw new NotImplementedException();
		}
	],


	'to_weekday_if_weekend(date)' => [
		['date'],
		function (DateTimeImmutable $dateTime): DateTimeImmutable {
			$weekDay = $dateTime->format('w');
			if ($weekDay === 0) {
				return $dateTime->modify('+1 day');
			} elseif ($weekDay === 6) {
				return $dateTime->modify('+1 day');
			} else {
				return $dateTime;
			}
		}
	],

];
