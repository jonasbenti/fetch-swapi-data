<?php

namespace Jlgomes\Swapi\Models;

class Specie extends ModelMap
{
    public int $id;
    public ?string $name = "";
    public ?string $classification = "";
    public ?string $designation = "";
    public ?string $average_height = "";
    public ?string $skin_colors = "";
    public ?string $hair_colors = "";
    public ?string $eye_colors = "";
    public ?string $average_lifespan = "";
    public ?string $homeworld = "";
    public ?string $language = "";
    public array $people = [];
    public array $films = [];
    public ?\DateTime $created = null;
    public ?\DateTime $edited = null;
    public string $url = "";
    // public function __construct(
    //     int $id,
    //     \DateTime $created,
    //     string $url,
    //     public string $name,
    //     public string $homeworld = "",
    //     public array $films = [],
    //     public array $vehicles = []
    // ) {
    //     parent::__construct($id, $created, $url);
    // }
}
