<?php

namespace SygicTravelTests\HolidaysCalculator;

use SygicTravel\HolidaysCalculator\Model\Holiday;
use Tester\Environment;
use Tracy\Debugger;


require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT);
Environment::setup();

if (getenv(Environment::RUNNER) === '1') {
	header('Content-type: text/plain');
	putenv('ANSICON=TRUE');
}

/**
 * @param Holiday[] $holidays
 */
function convertToTestStructure(array $holidays, bool $byObserved = false): array
{
	$out = [];
	if ($byObserved) {
		foreach ($holidays as $holiday) {
			$key = $holiday->getObserverDate() ?: $holiday->getDate();
			$key = $key->format('Y-m-d');
			$out[$key] = $holiday->getName();
		}
	} else {
		foreach ($holidays as $holiday) {
			$key = $holiday->getDate()->format('Y-m-d');
			$out[$key] = $holiday->getName();
		}
	}
	return $out;
}

function filterForRegion(array $holidays, string $region): array
{
	return array_filter($holidays, function (Holiday $holiday) use ($region) {
		return in_array($region, $holiday->getRegions(), true);
	});
}
