<?php

namespace Entity;

use Enum\Format;

class Address
{
    public const TYPE_LEGAL    = 'legal';
    public const TYPE_PHYSICAL = 'physical';

    public int $id;

    public string $creator;

    public string $country;

    public string $street;

    public $house_number;

    public string $city;

    public string $state;

    public string $zip;

    public string $type;

    public bool $isValid;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): int
    {
        return $this->house_number;
    }

    public function setHouseNumber($house_number): static
    {
        $this->house_number = $house_number;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip($zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    function __construct($id, $creator, $country, $street, $house_number, $city, $state, $zip, $type, $isValid)
    {
        $this->setId($id);
        $this->setCreator($creator);
        $this->setCountry($country);
        $this->setStreet($street);
        $this->setHouseNumber($house_number);
        $this->setCity($city);
        $this->setState($state);
        $this->setZip($zip);
        $this->setType($type);
        $this->setIsValid($isValid);
    }

    public function render(Format $format)
    {
        $valid = $this->isValid ? 'V' : 'X';

        switch ($format) {
            case Format::US:
                return sprintf(
                    "%s: (%s) %s %s, %s, %s %s, %s | %s",
                    $this->id,
                    $valid,
                    $this->street,
                    $this->house_number,
                    $this->city,
                    $this->state,
                    $this->zip,
                    $this->country,
                    $this->creator
                );

            case Format::UK:
                return sprintf(
                    "%s: (%s) %s %s, %s, %s, %s, %s | %s",
                    $this->id,
                    $valid,
                    $this->street,
                    $this->house_number,
                    $this->city,
                    $this->zip,
                    $this->state,
                    $this->country,
                    $this->creator
                );

            case Format::JP:
                return sprintf(
                    "%s: (%s) %s\n%s %s\n%s, %s\n%s \n%s",
                    $this->id,
                    $valid,
                    $this->zip,
                    $this->state,
                    strtoupper($this->city),
                    $this->street,
                    $this->house_number,
                    $this->country,
                    $this->creator
                );
        }
    }

}
