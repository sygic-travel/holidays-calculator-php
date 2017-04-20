<?php

namespace SygicTravel\HolidaysCalculator\Model;

use DateTimeImmutable;


class Holiday
{
	/** @var HolidayDefinition */
	private $definition;

	/** @var DateTimeImmutable */
	private $date;

	/** @var DateTimeImmutable|null */
	private $observedDate;


	public function __construct(HolidayDefinition $definition, DateTimeImmutable $date, ?DateTimeImmutable $observerdDate)
	{
		$this->definition = $definition;
		$this->date = $date;
		$this->observedDate = $observerdDate;
	}


	public function getName(): string
	{
		return $this->definition->name;
	}


	public function getRegions(): array
	{
		return $this->definition->regions;
	}


	public function getDate(): DateTimeImmutable
	{
		return $this->date;
	}


	public function getObserverDate(): ?DateTimeImmutable
	{
		return $this->observedDate;
	}


	public function getDefinition(): HolidayDefinition
	{
		return $this->definition;
	}
}
