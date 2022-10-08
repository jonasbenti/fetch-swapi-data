<?php 

namespace Jlgomes\Swapi;

use GuzzleHttp\Client as GuzzleClient;
use Jlgomes\Swapi\Endpoints\Endpoint;
use Jlgomes\Swapi\Helpers\Helper;
use Jlgomes\Swapi\Models\ModelMap;
use JsonMapper;

class Swapi
{
    protected ?Endpoint $films = null;
    protected ?Endpoint $people = null;
    protected ?Endpoint $planets = null;
    protected ?Endpoint $vehicles = null;
    protected ?Endpoint $starships = null;
    protected ?Endpoint $species = null;
    private ?GuzzleClient $http = null;
    private ?JsonMapper $mapper = null;

    public function __construct()
    {
        $this->http = $this->createHttpClient();
        $this->mapper = $this->createMapper();

    }

    /**
     * Criacao do ciente http
     *
     * @return GuzzleClient
     */
    public function createHttpClient(): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri' => Helper::API_URL,
            'verify' => false,
            'default' => ['headers' => ['Accept' => 'application/json']],
        ]);
    }

    /**
     * Retorna a intacia da classe que fara o mapeamento dos atributos
     *
     * @return JsonMapper
     */
    protected function createMapper(): JsonMapper
    {
        return new JsonMapper;
    }

    /**
     * Retorna as informacoes do endpoint films
     *
     * @param bool $fresh
     * @return Endpoint
     */
    public function films($fresh = false): Endpoint
    {
        if (!isset($this->films) || $fresh) {
            $this->films = new Endpoint($this->http, $this->mapper, Helper::FILMS);
        }

        return $this->films;
    }

    /**
     * Retorna as informacoes do endpoint people
     *
     * @param bool $fresh
     * @return Endpoint
     */
    public function people($fresh = false): Endpoint
    {
        if (!isset($this->people) || $fresh) {
            $this->people = new Endpoint($this->http, $this->mapper, Helper::PEOPLE);
        }

        return $this->people;
    }

    /**
     * Retorna as informacoes do endpoint vehicles
     *
     * @param bool $fresh
     * @return Endpoint
     */
    public function vehicles($fresh = false): Endpoint
    {
        if (!isset($this->vehicles) || $fresh) {
            $this->vehicles = new Endpoint($this->http, $this->mapper, Helper::VEHICLES);
        }

        return $this->vehicles;
    }

    /**
     * Retorna as informacoes do endpoint planets
     *
     * @param bool $fresh
     * @return Endpoint
     */
    public function planets($fresh = false): Endpoint
    {
        if (!isset($this->planets) || $fresh) {
            $this->planets = new Endpoint($this->http, $this->mapper, Helper::PLANETS);
        }

        return $this->planets;
    }

    /**
     * Retorna as informacoes do endpoint starships
     *
     * @param bool $fresh
     * @return Endpoint
     */
    public function starships($fresh = false): Endpoint
    {
        if (!isset($this->starships) || $fresh) {
            $this->starships = new Endpoint($this->http, $this->mapper, Helper::STARSHIPS);
        }

        return $this->starships;
    }

    /**
     * Retorna as informacoes do endpoint species
     * @param bool $fresh
     * @return Endpoint
     */
    public function species($fresh = false): Endpoint
    {
        if (!isset($this->species) || $fresh) {
            $this->species = new Endpoint($this->http, $this->mapper, Helper::SPECIES);
        }

        return $this->species;
    }

    /**
     * Retorna uma string html com o um link exibindo apenas o id e o name/title
     *
     * @param integer $id
     * @param string $nameTitle
     * @param string $url
     * @return string
     */
    public function createLinkHtmlWithNameAndId(int $id, string $nameTitle, string $url): string
    {
        return "<a href='$url' target='_blank'>{$nameTitle}(id: {$id}) <br></a>";
    }

    /**
     * Busca as informacoes pela url na API e retorna os dados mapeados na classe ModelMap 
     *
     * @param string $url
     * @return ModelMap
     */
    private function getFromUrl(string $url): ModelMap
    {
        if (preg_match("/\/api\/(\w+)\/(\d+)(\/|$)/", $url, $matches) !== false) {
            return match (strtolower($matches[1])) {
                Helper::FILMS => $this->films()->getObjById($matches[2]),
                Helper::PEOPLE => $this->people()->getObjById($matches[2]),
                Helper::PLANETS => $this->planets()->getObjById($matches[2]),
                Helper::VEHICLES => $this->vehicles()->getObjById($matches[2]),
                Helper::STARSHIPS => $this->starships()->getObjById($matches[2]),
                Helper::SPECIES => $this->species()->getObjById($matches[2]),
            };
        }

        throw new \UnexpectedValueException("Could not match a URL to an endpoint handler for " . $url);
    }

    /**
     * Busca os dados na API e retorna os dados completos ou parciais
     *
     * @param string $url
     * @param bool $allAttributes - Informa se deve retornar todos os atributos da URL ou apenas o id, name|title, url
     * @return ModelMap|null
     */
    public function getDataByUrl(string $url, bool $allAttributes = false): ?ModelMap
    {
        $completeObj = $this->getFromUrl($url);

        if ($completeObj && !$allAttributes) {
            $nameOrTitlePartial = isset($completeObj->name) ? 'name' : 'title';
            $partialObj = new ModelMap();
            $partialObj->id = $completeObj->id;
            $partialObj->$nameOrTitlePartial = $completeObj->$nameOrTitlePartial;
            $partialObj->url = $completeObj->url;

            return $partialObj;
        }

        return $completeObj ?: null;
    }

    /**
     * Retorna as informacoes da API com todos os dados dos atributos,
     * retornado informacoes (completas ou parciais) dos campos que sao urls
     *
     * @param ModelMap $modelData - dados da model
     * @param boolean $inJson - true: retorna um json, false: retorna um array
     * @param boolean $allAttributes - retorna todos os atributos de atributos que o nome consta 
     * no metodo estatico Helper::getAllConstantsAttributeWithUrl()
     * true: retorna todos os atributos
     * false: retorna apenas os atributos id, name|title, url
     * @return array|string
     */
    public function fetchDataWithUrlAttributes(ModelMap $modelData, bool $inJson = true, bool $allAttributes = false): array|string
    {
        $array = [];

        foreach ($modelData as $attr => $data) {
            // Verifica se eh um valor do tipo DateTime
            if (is_object($data) && get_class($data) === "DateTime" && $data) {
                $array[$attr] = $data->format('Y-m-d h:i:s');
                continue;
            }

            // verifica se o atributo eh homeworld(url) e tras seus dados principais
            if ($attr === 'homeworld' && $data) {
                $array[$attr] = $this->getDataByUrl($data, $allAttributes);
                continue;
            }

            // Se for um dos atributos definidos na classe Helper itera todos os itens do array
            if (in_array($attr, Helper::getAllConstantsAttributeWithUrl()) && $data) {
                foreach ($data as $key => $url) {
                    $array[$attr][$key] = $this->getDataByUrl($url, $allAttributes);
                }

                continue;
            }

            //se nao entrar nas regras acima, retorna exatamente o que estava na api
            $array[$attr] = $data;
        }

        return $inJson ? json_encode($array) : $array;
    }
}
