<?php

namespace SygicTravelTests\HolidaysCalculator;

use Tester\Environment;
use Tracy\Debugger;


require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT);
Environment::setup();

if (getenv(Environment::RUNNER) === '1') {
	header('Content-type: text/plain');
	putenv('ANSICON=TRUE');
}
