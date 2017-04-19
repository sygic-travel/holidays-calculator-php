<?php

namespace SygicTravel\HolidaysReader\Loaders;

use SygicTravel\HolidaysReader\Model\HolidayDefinition;


interface ILoader
{
	/**
	 * @return HolidayDefinition[]
	 */
	public function load(string $fileName): array;
}
