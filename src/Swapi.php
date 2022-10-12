<?php

namespace Jlgomes\Swapi;

use GuzzleHttp\Client as GuzzleClient;
use Jlgomes\Swapi\Endpoints\Endpoint;
use Jlgomes\Swapi\Helpers\Helper;
use JsonMapper;

class Swapi
{
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
     * Busca os dados da SWAPI com o nome da model e o id
     *
     * @param string $model
     * @param int $id
     * @param bool $displayChildData
     * @param bool $returnJson
     * @return array|string
     */
    public function getDataByModelAndId(string $model, int $id, $displayChildData = false, bool $returnJson = true): array|string
    {
        $url = Helper::API_URL . "{$model}/$id/";
        $data = $this->fetchEndpointByUrl($url, $displayChildData);

        return $returnJson ? json_encode($data) : $data;
    }

    /**
     * Busca os dados da SWAPI com a url
     *
     * @param string $url
     * @param bool $displayChildData
     * @param bool $returnJson
     * @return array|string
     */
    public function getDataByUrl(string $url, bool $displayChildData = false, bool $returnJson = true): array|string
    {
        $data = $this->fetchEndpointByUrl($url, $displayChildData);

        return $returnJson ? json_encode($data) : $data;
    }

    /**
     * Busca dados no endpoint SWAPI
     *
     * @param string $url
     * @param boolean $displayChildData
     * @return array
     */
    private function fetchEndpointByUrl(string $url, $displayChildData = false): array
    {
        try {
            $endpoint =  new Endpoint($this->http, $this->mapper, $url);

            return $endpoint->getHidrateDataByUrl($url, $displayChildData);
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage(), 'detail' => $e->getTraceAsString()];
        }
    }
}
