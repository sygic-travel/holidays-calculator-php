<?php

namespace SygicTravelTests\HolidaysCalculator;

use SygicTravel\HolidaysCalculator\Loaders\YamlSymfonyLoader;
use SygicTravel\HolidaysCalculator\ResolverBuilder;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


$builder = new ResolverBuilder(new YamlSymfonyLoader());

$resolver = $builder
	->addBuiltinFunctions()
	->addBuiltinHolidays('nz')
	->build();

$holidays = $resolver->getHolidays(2007);
$holidays = filterForRegion($holidays, 'nz');
$holidays = convertToTestStructure($holidays);

$expected = [
	'2007-01-01' => 'New Year\'s Day',
	'2007-01-02' => 'Day after New Year\'s Day',
	'2007-02-06' => 'Waitangi Day',
	'2007-04-06' => 'Good Friday',
	'2007-04-07' => 'Easter Saturday',
	'2007-04-09' => 'Easter Monday',
	'2007-04-25' => 'ANZAC Day',
	'2007-06-04' => 'Queen\'s Birthday',
	'2007-10-22' => 'Labour Day',
	'2007-12-25' => 'Christmas Day',
	'2007-12-26' => 'Boxing Day',
];

Assert::same($expected, $holidays);


$holidays2015 = convertToTestStructure($resolver->getHolidays(2015));
$holidays2016 = convertToTestStructure($resolver->getHolidays(2016));

$holidays2015o = convertToTestStructure($resolver->getHolidays(2015), true);
$holidays2016o = convertToTestStructure($resolver->getHolidays(2016), true);
$holidays2017o = convertToTestStructure($resolver->getHolidays(2017), true);
$holidays2018o = convertToTestStructure($resolver->getHolidays(2018), true);
$holidays2019o = convertToTestStructure($resolver->getHolidays(2019), true);

Assert::same('ANZAC Day', $holidays2015['2015-04-25']);
Assert::same('ANZAC Day', $holidays2015o['2015-04-27']);
Assert::same('ANZAC Day', $holidays2016['2016-04-25']);
Assert::same('ANZAC Day', $holidays2016o['2016-04-25']);

Assert::same('Waitangi Day', $holidays2015['2015-02-06']);
Assert::same('Waitangi Day', $holidays2015o['2015-02-06']);
Assert::same('Waitangi Day', $holidays2016['2016-02-06']);
Assert::same('Waitangi Day', $holidays2016o['2016-02-08']);

Assert::same('Nelson Anniversary Day', $holidays2016o['2016-02-01']);
Assert::same('Nelson Anniversary Day', $holidays2017o['2017-01-30']);
Assert::same('Nelson Anniversary Day', $holidays2018o['2018-01-29']);
Assert::same('Nelson Anniversary Day', $holidays2019o['2019-02-04']);

Assert::same('Taranaki Anniversary Day', $holidays2016o['2016-03-14']);
Assert::same('Taranaki Anniversary Day', $holidays2017o['2017-03-13']);
Assert::same('Taranaki Anniversary Day', $holidays2018o['2018-03-12']);
Assert::same('Taranaki Anniversary Day', $holidays2019o['2019-03-11']);
