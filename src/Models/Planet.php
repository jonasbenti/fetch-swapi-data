<?php

namespace Jlgomes\Swapi\Models;

class Planet extends ModelMap
{
    public int $id;
    public ?string $name = "";
    public ?string $rotation_period = "";
    public ?string $orbital_period = "";
    public ?string $diameter = "";
    public ?string $climate = "";
    public ?string $gravity = "";
    public ?string $terrain = "";
    public ?string $surface_water = "";
    public ?string $population = "";
    public array $residents = [];
    public array $films = [];
    public ?\DateTime $created = null;
    public ?\DateTime $edited = null;
    public string $url = "";
}
