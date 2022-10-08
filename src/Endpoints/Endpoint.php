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
        protected string $entityType
    ) {}

    public function setClient(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param object $data
     * @param ModelMap $modelInstance
     * @return ModelMap
     */
    protected function hydrateOne(object $data, ModelMap $modelInstance): ModelMap
    {
        return $this->mapper->map($data, $modelInstance);
    }

    /**
     * Busca as informacoes de acordo com o id passado por parametro
     * e o tipo de entidade (ex: people, films) definido no construtor da classe
     *
     * @param int $id
     * @return ModelMap
     */
    public function getObjById(int $id): ModelMap
    {
        try {
            $response = $this->http->request("GET", "{$this->entityType}/{$id}/");
            $obj = json_decode($response->getBody());
            $obj->id = $id;
            $model = Helper::getModel($this->entityType);

            return $this->hydrateOne($obj, $model);
        } catch (\UnexpectedValueException $e) {
            die($e->getMessage() . $e->getTraceAsString());
        } catch (\Exception $e) {
            die($e->getMessage() . $e->getTraceAsString());
        }
    }

    // /**
    //  * Busca as informacoes de acordo com a url
    //  *
    //  * @param int $url
    //  * @return ModelMap
    //  */
    // public function getObjByUrl(string $url): ModelMap
    // {
    //     try {
    //         $response = $this->http->request("GET", $url);
    //         $obj = json_decode($response->getBody());
    //         $obj->id = $id;
    //         $model = Helper::getModel($this->entityType);

    //         return $this->hydrateOne($obj, $model);
    //     } catch (\UnexpectedValueException $e) {
    //         die($e->getMessage() . $e->getTraceAsString());
    //     } catch (\Exception $e) {
    //         die($e->getMessage() . $e->getTraceAsString());
    //     }
    // }
}