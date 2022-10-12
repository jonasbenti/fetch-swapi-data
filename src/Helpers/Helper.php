<?php

namespace Jlgomes\Swapi\Helpers;

use Jlgomes\Swapi\Models\Film;
use Jlgomes\Swapi\Models\ModelMap;
use Jlgomes\Swapi\Models\Person;
use Jlgomes\Swapi\Models\Planet;
use Jlgomes\Swapi\Models\Specie;
use Jlgomes\Swapi\Models\Starship;
use Jlgomes\Swapi\Models\Vehicle;

class Helper
{
    const API_URL = 'https://swapi.dev/api/';
    const FILMS = "films";
    const PEOPLE = "people";
    const PLANETS = "planets";
    const VEHICLES = "vehicles";
    const STARSHIPS = "starships";
    const SPECIES = "species";
    const CHARACTERS= "characters";
    const PILOTS = "pilots";
    const RESIDENTS = "residents";

    /**
     * Metodo usado para informar quais atributos possuem um array com uma lista de URLs
     *
     * @return array
     */
    public static function getAllConstantsAttributeWithUrl(): array
    {
        return [
            static::FILMS,
            static::PEOPLE,
            static::PLANETS,
            static::VEHICLES,
            static::STARSHIPS,
            static::SPECIES,
            static::CHARACTERS,
            static::PILOTS,
            static::RESIDENTS,
        ];
    }

    /**
     * Retorna a classe de acordo com a tipo de entidade passados por parametro
     *
     * @param string $entityType - films, people, vehicles, planets, starships, species
     * @return ModelMap
     */
    private static function getModel(string $entityType): ModelMap|string
    {
        return match (strtolower($entityType)) {
            Helper::FILMS => new Film(),
            Helper::PEOPLE => new Person(),
            Helper::VEHICLES => new Vehicle(),
            Helper::PLANETS => new Planet(),
            Helper::STARSHIPS => new Starship(),
            Helper::SPECIES => new Specie(),
            default => $entityType
        };
    }

    /**
     * Retorna qual a entidade e o id que esta na url
     *
     * @param string $url
     * @return array
     */
    public static function getModelAndIdByUrl(string $url): array
    {
        if (preg_match("/\/api\/(\w+)\/(\d+)(\/|$)/", $url, $matches) !== false) {
            error_log(print_r($matches, 1));
            $data = [
                'model' => static::getModel($matches[1]),
                'id' => $matches[2]
            ];
        }

        return $data ?: [];
    }
}
