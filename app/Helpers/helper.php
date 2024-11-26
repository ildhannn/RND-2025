<?php
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\ClientException;

date_default_timezone_set('Asia/Jakarta');
function api_url($end_point)
{
    $auth_url = 'http://127.0.0.1:8001/api/' . $end_point;
    return $auth_url;
}

function api_exadel($param) {
  $url = 'http://localhost:8002/api/v1/recognition/' . $param;
  return $url;
}

function image_url()
{
    $url = 'http://127.0.0.1:8000/images/foto/';
    return $url;
}

function image_fr() {
  $url = 'http://127.0.0.1:8000/images/foto/fr/';
  return $url;
}
function requestGetAPI($url)
{
    $client = new Client();
    $checkToken = Session::get('token');
    try {
        $result = $client->request('GET', $url, [
            'verify' => false,
            'headers' => ['Authorization' => "Bearer {$checkToken}"],
        ]);
        return json_decode($result->getBody());
    } catch (ClientException $e) {
        $response = $e->getResponse();
        $res = $response->getBody()->getContents();
        return json_decode($res);
    }
}

function requestGetAPIExadel($url)
{
    $client = new Client();
    try {
        $result = $client->request('GET', $url, [
            'verify' => false,
            'headers' => ['x-api-key' => "eef6c78b-c094-4413-b3da-9a911f4726ee"],
            // 'query' => [
            //   'subject' => $subject
            // ]
        ]);
        return json_decode($result->getBody());
    } catch (ClientException $e) {
        $response = $e->getResponse();
        $res = $response->getBody()->getContents();
        return json_decode($res);
    }
}

function requestPostAPI($url, $array)
{
    $client = new Client();
    $checkToken = Session::get('token');
    try {
        $result = $client->request('POST', $url, [
            'form_params' => $array,
            'verify' => false,
            'headers' => ['Authorization' => "Bearer {$checkToken}"],
        ]);

        return json_decode($result->getBody());
    } catch (ClientException $e) {
        $response = $e->getResponse();

        $res = $response->getBody()->getContents();

        return json_decode($res);
    }
}
