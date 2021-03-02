<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

/**
 * Description of RestApiService
 * @author Fernando Costa <fernando@softnex.com.br>
 */
class RestApiService
{
    //Constantes de Erros API
    const TOKEN_INVALIDO      = 'Acesso proibido, token inválido!';
    const TOKEN_NAO_INFORMADO = 'Token não informado!';

    protected $urlApi;
    protected $accessToken;
    protected $client;
    protected $headers;

    public function __construct(Client $client)
    {
        $this->urlApi      = 'http://localhost/php7/carapp/api/';

        $this->client      = $client;
        $this->headers     = [
            'cache-control' => 'no-cache',
            'Content-type'  => 'application/x-www-form-urlencoded',
        ];
    }

    /**
     * Chamada Request GET ApiRest
     * @author Fernando Costa <fernando@softnex.com.br>
     * @param string $uri
     * @param string $token
     * @param array  $query
     * @return Json
     * @throws Exception
     */
    public function getRequest($uri, $token, array $query = [])
    {
        try {
            $url = $this->urlApi . $uri;

            $this->headers['token'] = $token;
            $query['format']        = 'json';

            $request = $this->client->get($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => false,
                'http_errors'     => true,
                'query'           => $query
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200 && $response !== 'null') {
                return (object) json_decode($response);
            }

            return null;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            throw new \Exception($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Chamada Request POST ApiRest
     * @author Fernando Costa <fernando@softnex.com.br>
     * @param string $uri
     * @param string $token
     * @param array  $post_params
     * @return Json
     * @throws Exception
     */
    public function postRequest($uri, $token, array $post_params = [])
    {
        try {
            $url = $this->urlApi . $uri;
            $this->headers['token'] = $token;

            $request = $this->client->post($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => false,
                'http_errors'     => true,
                'form_params'     => $post_params,
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200 && $response !== 'null') {
                return (object) json_decode($response);
            }

            return null;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            throw new \Exception($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Chamada Request PUT ApiRest
     * @author Fernando Costa <fernando@softnex.com.br>
     * @param string $uri
     * @param string $token
     * @param array  $put_params
     * @return Json
     * @throws Exception
     */
    public function putRequest($uri, $token, array $put_params = [])
    {
        try {
            $url = $this->urlApi . $uri;
            $this->headers['token'] = $token;

            $request = $this->client->put($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => false,
                'http_errors'     => true,
                'form_params'     => $put_params,
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200 && $response !== 'null') {
                return (object) json_decode($response);
            }

            return null;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            throw new \Exception($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Recuperando token do Usuário Logado e informações de session
     * @author Fernando Costa <fernando@softnex.com.br>
     * @param array $body
     * @return Json
     * @throws Exception
     */
    public function getLogin(array $body = [])
    {
        try {
            $url = $this->urlLogin;
            $request = $this->client->post($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => false,
                'http_errors'     => true,
                'form_params'     => $body,
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200 && $response !== 'null') {
                return (object) json_decode($response);
            }

            return null;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            throw new \Exception($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
