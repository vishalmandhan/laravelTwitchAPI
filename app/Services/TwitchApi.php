<?php
/**
 * Created by PhpStorm.
 * User: Vishal
 * Date: 13/03/2019
 * Time: 11:57 AM
 */

namespace App\Services;

use GuzzleHttp\Client;
//use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
//use GuzzleHttp\Psr7\Request;

class TwitchApi
{
    const BASE_URI = 'https://api.twitch.tv/';
    const CHANNEL_URI = 'v5/channels/';
    const STREAMER_INFO_URI = 'kraken/channels/';

    /**
     * Twitch client id
     * @var string
     */
    protected $clientId = null;


    /**
     * Construction
     * @param string $clientId Twitch client id
     */
    public function __construct(string $clientId = null)
    {
        if ($clientId !== null) {
            $this->setClientId($clientId);
        } elseif (env('TWITCH_KEY',null)) {
            $this->setClientId(env('TWITCH_KEY',null));
        }
    }
    /**
     * Set clientId
     * @param string $clientId Twitch client id
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
    /**
     * Get clientId
     * @param  string $clientId  clientId optional
     * @return string clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    public function getTwitchEvents($channel_id = null) {

        if(empty($channel_id)) {
            return false;
        }

        $client = new Client();

        try {
            $res = $client->request('GET', self::BASE_URI . self::CHANNEL_URI . $channel_id . '/events', [
                'headers' => [
                    'Client-ID' => $this->getClientId()
                ]
            ]);
        }
        catch(RequestException $e){
            if ($e->hasResponse()) {
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                return $exception;
            } else {
                //503
                return array(
                    'error' => 'Service Unavailable',
                    'status' => 503,
                    'message' => $e->getMessage()
                );
            }

        }

        return json_decode($res->getBody()->getContents())->events;
    }

    public function getStreamerInfo($streamer_name = null) {

        if(empty($streamer_name)) {
            return false;
        }

        $client = new Client();

        try {
        $res = $client->request('GET', self::BASE_URI.self::STREAMER_INFO_URI.$streamer_name, [
            'headers' => [
                'Client-ID' => $this->getClientId()
            ]
        ]);
        }
        catch(RequestException $e){
            if ($e->hasResponse()) {
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                return $exception;
            } else {
                //503
                return array(
                    'error' => 'Service Unavailable',
                    'status' => 503,
                    'message' => $e->getMessage()
                );
            }

        }

        return json_decode($res->getBody()->getContents());
    }
}