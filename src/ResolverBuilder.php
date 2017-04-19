<?php

namespace SygicTravel\HolidaysReader;

use SygicTravel\HolidaysReader\Loaders\ILoader;
use SygicTravel\HolidaysReader\Model\HolidayDefinition;


class ResolverBuilder
{
	/** @var HolidayDefinition[] */
	private $holidayDefinitions = [];

	/** @var array */
	private $functions = [];

	/** @var ILoader */
	private $loader;


	public function __construct(ILoader $loader)
	{
		$this->loader = $loader;
	}


	public function addHolidayDefinition(HolidayDefinition $holidayDefinition): self
	{
		$this->holidayDefinitions[] = $holidayDefinition;
		return $this;
	}


	public function addHolidaysFromFile(string $filename): self
	{
		foreach ($this->loader->load($filename) as $holidayDefinition) {
			$this->holidayDefinitions[] = $holidayDefinition;
		}
		return $this;
	}


	public function addBuiltinHolidays(string $countryCode): self
	{
		$this->addHolidaysFromFile(__DIR__ . "/../definitions/$countryCode.yaml");
		return $this;
	}


	public function addFunction(string $functionExpression, array $arguments, callable $callback): self
	{
		$this->functions[$functionExpression] = [$arguments, $callback];
		return $this;
	}


	public function addBuiltinFunctions(): self
	{
		$functions = require __DIR__ . '/Functions/functions.php';
		foreach ($functions as $functionExpression => $functionDefinition) {
			$this->functions[$functionExpression] = $functionDefinition;
		}
		return $this;
	}


	public function build(): Resolver
	{
		return new Resolver($this->holidayDefinitions, $this->functions);
	}
}
