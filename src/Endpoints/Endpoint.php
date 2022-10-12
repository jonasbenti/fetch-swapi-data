<?php

namespace Jlgomes\Swapi\Endpoints;

use JsonMapper;
use GuzzleHttp\Client;
use Jlgomes\Swapi\Helpers\Helper;
use Jlgomes\Swapi\Models\ModelMap;

class Endpoint
{
    public function __construct(
        protected Client $http,
        protected JsonMapper $mapper,
        protected string $url
    ) {
    }

    /**
     * Altera as informacoes do client http
     *
     * @param Client $http
     * @return void
     */
    public function setClient(Client $http): void
    {
        $this->http = $http;
    }

    /**
     * @param object $data
     * @param ModelMap $modelInstance
     * @return ModelMap
     */
    public function hydrateOne(object $data, ModelMap $modelInstance): ModelMap
    {
        return $this->mapper->map($data, $modelInstance);
    }

    /**
     * Busca as informacoes de acordo com a url
     *
     * @param string $url
     * @return ModelMap
     */
    private function getObj(string $url): ModelMap
    {
        $dataUrl = Helper::getModelAndIdByUrl($url);

        if (!is_object($dataUrl['model']) ) {
            throw new \UnexpectedValueException("Error model ({$dataUrl['model']}) not exists");
        }

        $response = $this->http->request("GET", $url);
        $obj = json_decode($response->getBody());
        $obj->id = $dataUrl['id'];

        return $this->hydrateOne($obj, $dataUrl['model']);
    }

    /**
     * Busca os dados na API e com a opcao de exibir informacoes do registro filho
     * e informacoes de registro que possuem uma url
     *
     * @param string $url
     * @param bool $displayChildData - Informa se deve retornar todos os atributos da URL ou apenas o id, name|title, url
     * @return array
     */
    public function getHidrateDataByUrl(string $url, bool $displayChildData = false): array
    {
        $obj = $this->getObj($url);
        $array = [];

        foreach ($obj as $key => $value) {
            // Verifica se eh um valor do tipo DateTime
            if (is_object($value) && get_class($value) === "DateTime" && $value) {
                $array[$key] = $value->format('Y-m-d h:i:s');
                continue;
            }

            if ($displayChildData) {
                // verifica se o atributo <> url possui uma url(exemplo: homeworld)
                if (!is_array($value) && $key !== 'url' && str_starts_with($value, Helper::API_URL)) {
                    $array[$key] = $this->getHidrateDataByUrl($value);
                    continue;
                }

                // Se for um dos atributos definidos na classe Helper itera todos os itens do array
                if (in_array($key, Helper::getAllConstantsAttributeWithUrl()) && $value) {
                    foreach ($value as $childKey => $url) {
                        $array[$key][$childKey] = $this->getHidrateDataByUrl($url);
                    }
                    continue;
                }
            }

            $array[$key] = $value;
        }

        return $array;
    }
}