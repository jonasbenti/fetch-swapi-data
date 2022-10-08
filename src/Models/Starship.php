<?php

namespace Jlgomes\Swapi\Models;

class Starship extends ModelMap {
    public int $id;
    public ?string $name = "";
    public ?string $model = "";
    public ?string $manufacturer = "";
    public ?string $length = "";
    public ?string $max_atmosphering_speed = "";
    public ?string $crew = "";
    public ?string $passengers = "";
    public ?string $cargo_capacity = "";
    public ?string $consumables = "";
    public ?string $hyperdrive_rating = "";
    public ?string $MGLT = "";
    public ?string $starship_class = "";
    public array $pilots = [];
    public array $films = [];
    public ?\DateTime $created = null;
    public ?\DateTime $edited = null;
    public string $url = "";
}
