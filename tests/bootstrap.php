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

function convertToTestStructure(array $holidays): array
{
	return array_map(function (Holiday $holiday) {
		if ($holiday->getObserverDate() !== null) {
			return [$holiday->getName(), $holiday->getObserverDate()->format('Y-m-d')];
		}
		return $holiday->getName();
	}, $holidays);
}
