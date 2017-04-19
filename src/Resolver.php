<?php

namespace SygicTravel\HolidaysReader;

use DateTimeImmutable;
use SygicTravel\HolidaysReader\Exceptions\InvalidArgumentException;
use SygicTravel\HolidaysReader\Exceptions\NotSupportedException;
use SygicTravel\HolidaysReader\Model\Holiday;
use SygicTravel\HolidaysReader\Model\HolidayDefinition;


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
			$holiday = $this->getHolidayDate($holidayDefinition, $year);
			$holidays[$holiday->format('Y-m-d')] = new Holiday($holidayDefinition, $holiday, null);
		}
		ksort($holidays);
		return $holidays;
	}


	private function getHolidayDate(HolidayDefinition $definition, int $year): DateTimeImmutable
	{
		$date = null;

		if ($definition->month) {
			$date = new DateTimeImmutable("{$year}-{$definition->month}-{$definition->monthDay}");
		}

		if ($definition->week) {
			$date = new DateTimeImmutable();
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

		return $date;
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
