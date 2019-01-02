<?php

namespace Hpolthof\NotaFabriekApi;

use GuzzleHttp\Client;
use Hpolthof\NotaFabriekApi\Models\Customer;
use Hpolthof\NotaFabriekApi\Models\Invoice;
use Hpolthof\NotaFabriekApi\Models\Product;

class NotaFabriek
{
    protected $urlBase = 'https://secure.notafabriek.nl/api/v1';
    protected $testMode = false;
    protected $appId = '';
    protected $apiKey = '';

    /**
     * @return Product
     */
    public function product()
    {
        return new Product($this);
    }

    public function customer()
    {
        return new Customer($this);
    }

    public function invoice()
    {
        return new Invoice($this);
    }

    /**
     * NotaFabriek constructor.
     * @param string $appId
     * @param string $apiKey
     */
    public function __construct($appId, $apiKey)
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
    }

    /**
     * @param $method
     * @param $endpoint
     * @param null $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \HttpException
     */
    public function request($method, $endpoint, $data = null)
    {
        $client = new Client();

        // Authentication
        $headers = [
            'APP-ID' => $this->appId,
            'API-Key' => $this->apiKey,
            'Accept' => 'application/json, text/plain, */*',
            'User-Agent' => 'NotaFabriekApi PHP',
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // Test Mode
        if ($this->testMode) {
            $headers['X-Test'] = '1';
        }

        if (!is_null($data)) {
            $json = $data;
        }

        $options = compact('headers', 'json');
        $request = $client->request($method, $this->urlBase.'/'.$endpoint, $options);

        if ($request->getStatusCode() >= 400) {
            throw new \HttpException($request->getReasonPhrase(), $request->getStatusCode());
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getUrlBase()
    {
        return $this->urlBase;
    }

    /**
     * @param string $urlBase
     * @return NotaFabriek
     */
    public function setUrlBase($urlBase)
    {
        $this->urlBase = $urlBase;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     * @return NotaFabriek
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string $appId
     * @return NotaFabriek
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return NotaFabriek
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function all($type)
    {
        $request = $this->request('get', $type);
        return $this->parseResponse($request);
    }

    public function store($type, $data = [])
    {
        $request = $this->request('post', $type, $data);
        return $this->parseResponse($request);
    }

    public function update($type, $id, $data = [])
    {
        $request = $this->request('put', "{$type}/{$id}", $data);
        return $this->parseResponse($request);
    }

    public function show($type, $id)
    {
        $request = $this->request('get', "{$type}/{$id}");
        return $this->parseResponse($request);
    }

    public function destroy($type, $id)
    {
        $request = $this->request('delete', "{$type}/{$id}");
        return $this->parseResponse($request);
    }

    public function parseResponse($request)
    {
        if ($request->getHeader('Content-type')[0] == 'application/json') {
            $json = json_decode($request->getBody()->getContents(), false);
            if ($json->status === 'OK') {
                return $json->response;
            }
        }
        return false;
    }
}