<?php

namespace SygicTravel\HolidaysCalculator\Loaders;

use SygicTravel\HolidaysCalculator\Model\HolidayDefinition;


interface ILoader
{
	/**
	 * @return HolidayDefinition[]
	 */
	public function load(string $fileName): array;
}
