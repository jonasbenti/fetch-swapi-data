<?php

namespace Jlgomes\Swapi\Models;

class Film extends ModelMap {
    public int $id;
    public string $title = "";
    public ?int $episode_id = null;
    public string $opening_crawl = "";
    public string $director = "";
    public string $producer = "";
    public ?\DateTime $release_date = null;
    public array $characters = [];
    public array $planets = [];
    public array $starships = [];
    public array $vehicles = [];
    public array $species = [];
    public ?\DateTime $created = null;
    public ?\DateTime $edited = null;
    public string $url = "";
}
