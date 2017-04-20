<?php

namespace SygicTravel\HolidaysCalculator;

use DateTimeImmutable;
use SygicTravel\HolidaysCalculator\Exceptions\InvalidArgumentException;
use SygicTravel\HolidaysCalculator\Exceptions\NotSupportedException;
use SygicTravel\HolidaysCalculator\Model\Holiday;
use SygicTravel\HolidaysCalculator\Model\HolidayDefinition;


class Resolver
{
	/** @var HolidayDefinition[] */
	public $holidayDefinitions = [];

	/** @var array */
	public $functions = [];


	public function __construct(array $holidayDefinitions, array $functions)
	{
		$this->holidayDefinitions = $holidayDefinitions;
		$this->functions = $functions;
	}


	/**
	 * @return Holiday[]
	 */
	public function getHolidays(int $year): array
	{
		$holidays = [];
		foreach ($this->holidayDefinitions as $holidayDefinition) {
			[$date, $observedDate] = $this->getHolidayDate($holidayDefinition, $year);
			$holidays[] = new Holiday($holidayDefinition, $date, $observedDate);
		}
		ksort($holidays);
		return $holidays;
	}


	/**
	 * @return DateTimeImmutable[]
	 */
	private function getHolidayDate(HolidayDefinition $definition, int $year): array
	{
		$date = null;
		$observedDate = null;

		if ($definition->monthDay) {
			$date = new DateTimeImmutable("{$year}-{$definition->month}-{$definition->monthDay}");

		} elseif ($definition->week) {
			static $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
			static $months = [1 => 'Jan', 'Feb', 'Mar', 'May', 'Apr', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			static $nth = [1 => 'first', 'second', 'third', 'fourth'];

			$timestamp = strtotime("{$nth[$definition->week]} {$days[$definition->weekDay]} of {$months[$definition->month]} $year");
			$date = new DateTimeImmutable('@' . $timestamp);
		}

		if ($definition->functionName) {
			$date = $this->callFunction($definition->functionName, $year, $date);
		}

		if (!$date) {
			throw new NotSupportedException();
		}

		if ($definition->functionModifier) {
			$date = $date->modify(($definition->functionModifier ? '+' : '') . $definition->functionModifier . ' days');
		}

		if ($definition->observerFunctionName) {
			$observedDate = $this->callFunction($definition->observerFunctionName, $year, $date);
		}

		return [$date, $observedDate];
	}


	private function callFunction(string $functionName, int $year, ?DateTimeImmutable $dateTime): ?DateTimeImmutable
	{
		if (!isset($this->functions[$functionName])) {
			throw new NotSupportedException("Function $functionName is not supported.");
		}

		[$parameters, $callback] = $this->functions[$functionName];

		$args = [];
		foreach ($parameters as $parameter) {
			if ($parameter === 'year') {
				$args[] = $year;
				continue;
			}

			if (!$dateTime) {
				throw new InvalidArgumentException('Function require specific date as a parameter. Wrong holiday definition.');
			}
			if ($parameter === 'month') {
				$args[] = $dateTime->format('m');
			} elseif ($parameter === 'day') {
				$args[] = $dateTime->format('d');
			} elseif ($parameter === 'date') {
				$args[] = $dateTime;
			} else {
				throw new NotSupportedException("Function parameter $parameter is not supported.");
			}
		}

		return call_user_func_array($callback, $args);
	}
}
