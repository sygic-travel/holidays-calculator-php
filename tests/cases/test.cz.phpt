<?php

namespace SygicTravelTests\HolidaysCalculator;

use SygicTravel\HolidaysCalculator\Loaders\YamlSymfonyLoader;
use SygicTravel\HolidaysCalculator\ResolverBuilder;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


$builder = new ResolverBuilder(new YamlSymfonyLoader());

$resolver = $builder
	->addBuiltinFunctions()
	->addBuiltinHolidays('cz')
	->build();

$holidays = $resolver->getHolidays(2017);
$holidays = convertToTestStructure($holidays);


$expected = [
	'2017-01-01' => 'Den obnovy samostatného českého státu',
	'2017-04-14' => 'Velký pátek',
	'2017-04-17' => 'Velikonoční pondělí',
	'2017-05-01' => 'Svátek práce',
	'2017-05-08' => 'Den vítězství',
	'2017-07-05' => 'Den slovanských věrozvěstů Cyrila a Metoděje',
	'2017-07-06' => 'Den upálení mistra Jana Husa',
	'2017-09-28' => 'Den české státnosti',
	'2017-10-28' => 'Den vzniku samostatného československého státu',
	'2017-11-17' => 'Den boje za svobodu a demokracii',
	'2017-12-24' => 'Štědrý den',
	'2017-12-25' => '1. svátek vánoční',
	'2017-12-26' => '2. svátek vánoční',
];


Assert::same($expected, $holidays);
