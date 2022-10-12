<?php

namespace Jlgomes\Swapi\Models;

class Person extends ModelMap
{
    public int $id;
    public ?string $name = "";
    public ?string $height = "";
    public ?string $mass = "";
    public ?string $hair_color = "";
    public ?string $skin_color = "";
    public ?string $eye_color = "";
    public ?string $birth_year = "";
    public ?string $gender = "";
    public ?string $homeworld = "";
    public array $films = [];
    public array $species = [];
    public array $vehicles = [];
    public array $starships = [];
    public ?\DateTime $created = null;
    public ?\DateTime $edited = null;
    public string $url = "";
}
