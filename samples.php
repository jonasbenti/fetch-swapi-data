<?php

use Jlgomes\Swapi\Helpers\Helper;
use Jlgomes\Swapi\Swapi;

require_once __DIR__ . '/vendor/autoload.php';

$entitySwapiPeople = Helper::PEOPLE;
$entitySwapiStarships = Helper::STARSHIPS;
$idApiPeople = 4;
$idApiStarships = 12;
$swapi = new Swapi();
$urlPeople = Helper::API_URL . "{$entitySwapiPeople}/$idApiPeople/";
$urlStarships = Helper::API_URL . "{$entitySwapiStarships}/$idApiStarships/";

$object = $swapi->getDataByUrl($urlPeople, true);

echo $swapi->fetchDataWithUrlAttributes($object);
