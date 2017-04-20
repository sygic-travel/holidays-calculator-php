<?php

namespace SygicTravel\HolidaysCalculator\Loaders;

use SygicTravel\HolidaysCalculator\Loaders\Utils\YamlParser;
use Symfony\Component\Yaml\Yaml;


class YamlSymfonyLoader implements ILoader
{
	/** @var YamlParser */
	private $parser;


	public function load(string $fileName): array
	{
		$definitions = Yaml::parse(file_get_contents($fileName));
		if ($this->parser === null) {
			$this->parser = new YamlParser();
		}
		return $this->parser->parse($definitions['months']);
	}
}
