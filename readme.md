# Busca de dados simplificada na API do Starwars (SWAPI)

Busca os dados na api com a opção do retorno normal(default) ou com busca adicional nos atributos que pussem uma url.
## Versão recomendada do PHP:

* `>=8.0`

## Forma de buscar os dados

* url: (`https://swapi.dev/api/starships/5`)
* entidade e id: (`starships`, `5`)
## Retorno dos dados

* JSON (default)
* ARRAY
## Tipo de atributos com url que possuem a possibilidade de busca adicional

* `homeworld`
* `films`
* `people`
* `planets`
* `vehicles`
* `species`
* `starships`
* `characters`
* `pilots`
* `residents`
## Installation

Instalar com **composer**

```bash
composer require jlgomes/swapi-php
```

## Funções Principais
* [Buscar dados pela url](https://github.com/jonasbenti/fetch-swapi-data/#buscar-dados-pela-url)
* [Buscar dados pela entidade e id](https://github.com/jonasbenti/fetch-swapi-data/#buscar-dados-pela-entidade-e-id)

## [Exemplos de utilização](https://github.com/jonasbenti/fetch-swapi-data/blob/master/samples.php)

### Buscar dados pela url:
* parâmetro 1(obrigatório): (string) url para realizar a busca na API
* parâmetro 2(opcional default false): (bool) informa se deve ser realizada a busca adicional nos atributos com url.
* parâmetro 3(opcional default true): (bool) informa se deve retornar um Json ou um Array
* Com os parâmetros utilizados abaixo serão retornados os dados simples da Api em json
```php
use Jlgomes\Swapi\Swapi;

$swapi = new Swapi();
$dataStarships = $swapi->getDataByUrl("https://swapi.dev/api/starships/5");
// Resultado em: https://github.com/jonasbenti/fetch-swapi-data/blob/master/attachment/Sample1.png
echo($dataStarships);
```

### Buscar dados pela entidade e id:
* parâmetro 1(obrigatório): (string) entidade para realizar a busca na API
* parâmetro 2(obrigatório): (int) id para realizar a busca na API
* parâmetro 3(opcional default false): (bool) informa se deve ser realizada a busca adicional nos atributos com url.
* parâmetro 4(opcional default true): (bool) informa se deve retornar um Json ou um Array
* Com os parâmetros utilizados abaixo serão retornados os dados com informações adiconais da Api em json
```php
use Jlgomes\Swapi\Swapi;

$swapi = new Swapi();
$dataPeople = $swapi->getDataByModelAndId('people', 5, true);
// Resultado em: https://github.com/jonasbenti/fetch-swapi-data/blob/master/attachment/Sample2.json
echo($dataPeople);
```

## Licence

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://github.com/jonasbenti/fetch-swapi-data/blob/master/licence)
