<?php

namespace SygicTravelTests\HolidaysCalculator;

use SygicTravel\HolidaysCalculator\Loaders\YamlSymfonyLoader;
use SygicTravel\HolidaysCalculator\ResolverBuilder;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


$builder = new ResolverBuilder(new YamlSymfonyLoader());

$resolver = $builder
	->addBuiltinFunctions()
	->addBuiltinHolidays('ar')
	->build();

$holidays = $resolver->getHolidays(2016);
$holidays = convertToTestStructure($holidays);

$expected = [
	'2016-01-01' => 'Año Nuevo',
	'2016-02-08' => 'Carnaval',
	'2016-02-09' => 'Carnaval',
	'2016-03-24' => 'Día Nacional de la Memoria por la Verdad y la Justicia',
	'2016-03-25' => 'Viernes Santo',
	'2016-04-02' => 'Día del Veterano y de los Caídos en la Guerra de Malvinas',
	'2016-05-01' => 'Día del Trabajador',
	'2016-05-25' => 'Día de la Revolución de Mayo',
	'2016-06-20' => 'Día de la Bandera',
	'2016-07-08' => 'Feriado puente turístico',
	'2016-07-09' => 'Día de la Independencia',
	'2016-08-15' => 'Paso a la Inmortalidad del General José de San Martín',
	'2016-10-12' => 'Día del Respeto a la Diversidad Cultural',
	'2016-11-20' => 'Día de la Soberanía Nacional',
	'2016-12-08' => 'Inmaculada Concepción de María',
	'2016-12-09' => 'Feriado puente turístico',
	'2016-12-25' => 'Navidad'
];


Assert::same($expected, $holidays);
