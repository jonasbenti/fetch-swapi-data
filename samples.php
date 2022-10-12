<?php

use Jlgomes\Swapi\Helpers\Helper;
use Jlgomes\Swapi\Swapi;

require_once __DIR__ . '/vendor/autoload.php';

$swapi = new Swapi();

/**
 * Buscando dados pela model(starships) e o id(5) e exibindo um array
 * Retornando as informacoes dos atributos filhos de forma detalhada
 * porque o terceiro parametro esta true
 * retornado um array porque o quarto parametro eh false
 * attachment/Screenshot_1.png
 */
$modelSwapiStarships = Helper::STARSHIPS;
$idApiStarships = 5;
$dataStarships = $swapi->getDataByModelAndId($modelSwapiStarships, $idApiStarships, true, false);
print_r($dataStarships);

/**
 * Buscando dados pela url(https://swapi.dev/api/starships/5)
 * Retornando as informacoes sem os atributos filhos de forma NAO detalhada
 * porque o segundo parametro default eh false
 * retornado um json porque o 3 parametro default eh true
 * attachment/Screenshot_2.png
 */
$urlStarships = Helper::API_URL . "$modelSwapiStarships/$idApiStarships/";
$dataStarships = $swapi->getDataByUrl($urlStarships);
echo($dataStarships);


/**
 * Buscando dados pela model(people) e o id(5) e exibindo um json
 * Retornando as informacoes dos atributos filhos de forma detalhada
 * porque o terceiro parametro esta true
 * retornado um json porque o quarto parametro por default eh true
 * image: attachment/Screenshot_3.png
 * json: attachment/Screenshot_3_data.json
 */
$dataPeople = $swapi->getDataByModelAndId(Helper::PEOPLE, 5, true);
echo($dataPeople);
