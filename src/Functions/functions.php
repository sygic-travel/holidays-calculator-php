<?php

namespace SygicTravel\HolidaysCalculator\Functions;


return [

	'easter(year)' => [['year'], [EasterFunctions::class, 'easter']],
	'orthodox_easter(year)' => [['year'], [EasterFunctions::class, 'orthodoxEaster']],
	'to_monday_if_sunday(date)' => [['date'], [WeekFunctions::class, 'toMondayIfSunday']],
	'to_monday_if_weekend(date)' => [['date'], [WeekFunctions::class, 'toMondayIfWeekend']],
	'to_weekday_if_boxing_weekend(date)' => [['date'], [WeekFunctions::class, 'toWeekdayIfBoxingWeekend']],
	'to_weekday_if_boxing_weekend_from_year(year)' => [['year'], [WeekFunctions::class, 'toWeekdayIfBoxingWeekendFromYear']],
	'to_weekday_if_weekend(date)' => [['date'], [WeekFunctions::class, 'toWeekdayIfWeekend']],

	// custom from definition files
	'closest_monday(date)' => [['date'], [WeekFunctions::class, 'closestMonday']],
	'previous_friday(date)' => [['date'], [WeekFunctions::class, 'previousFriday']],
	'next_week(date)' => [['date'], [WeekFunctions::class, 'nextWeek']],
];
