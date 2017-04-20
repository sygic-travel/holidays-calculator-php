<?php

namespace SygicTravel\HolidaysCalculator\Model;


class HolidayDefinition
{
	/** @var string */
	public $name;

	/** @var array */
	public $regions = [];

	/** @var int|null */
	public $month;

	/** @var int|null */
	public $monthDay;

	/** @var int|null */
	public $week;

	/** @var int|null */
	public $weekDay;

	/** @var string|null */
	public $functionName;

	/** @var int|null */
	public $functionModifier;

	/** @var string|null */
	public $observerFunctionName;
}
