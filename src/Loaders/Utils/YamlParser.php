<?php

namespace SygicTravel\HolidaysCalculator\Loaders\Utils;

use SygicTravel\HolidaysCalculator\Model\HolidayDefinition;


class YamlParser
{
	/**
	 * @return HolidayDefinition[]
	 */
	public function parse(array $structure): array
	{
		$definitions = [];

		for ($month = 0; $month <= 12; $month++) {
			if (!isset($structure[$month])) {
				continue;
			}

			foreach ($structure[$month] as $holiday) {
				$definition = new HolidayDefinition();
				$definition->name = $holiday['name'];
				$definition->regions = $holiday['regions'] ?? [];
				$definition->month = $month === 0 ? null : $month;
				$definition->monthDay = $holiday['mday'] ?? null;
				$definition->week = $holiday['week'] ?? null;
				$definition->weekDay = $holiday['wday'] ?? null;
				$definition->functionName = $holiday['function'] ?? null;
				$definition->functionModifier = $holiday['function_modifier'] ?? null;

				$definitions[] = $definition;
			}
		}

		return $definitions;
	}
}
