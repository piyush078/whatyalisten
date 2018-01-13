<?php

namespace App\Http\Controllers;

use Config;
use \DateTime;
use \Session;
use \Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * GuzzleHttp variable.
     *
     * @var \GuzzleHttp\Guzzle\Client
     */
    private $client = null;

    /**
     * Session token variable.
     *
     * @var string
     */
    private $sessionTokenName = 'apiToken';

    /**
     * Constructor of Controller.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->client = new \GuzzleHttp\Client ();
    }

    /**
     * Send invalid request response.
     *
     * @param  void
     * @return Response
     */
    public function invalidRequest ()
    {
        return response ()->json (['statusCode' => 500, 'responseText' => 'Invalid Request'], 500);
    }

    /**
     * Return Spotify headers.
     *
     * @param  void
     * @return string
     */
    public function getAuthorizationCode () 
    {
        $headers = Config::get ('client');
        $client_id = $headers ['client_id'];
        $client_secret = $headers ['client_secret'];
        return base64_encode ($client_id.':'.$client_secret);
    }

    /**
     * Check if token validity is over.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    private function isValidToken (Request $request)
    {
        $now = new DateTime ();
        $newTimestamp = $now->getTimestamp ();
        $oldTimestamp = Session::get ($this->sessionTokenName) ['timestamp'];
        return ($newTimestamp - $oldTimestamp <= 3600);
    }

    /**
     * Refresh the Spotify token and store the new values in session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean|mixed
     */
    private function refreshToken (Request $request)
    {
        try {
            $response = $this->client->request ('POST', 'https://accounts.spotify.com/api/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic '.$this->getAuthorizationCode (),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]
            ]);
        } catch (GuzzleHttp\Exception\BadResponseException $error) {
            return false;
        } catch (Exception $error) {
            return false;
        }
        $contents = json_decode ($response->getBody ()->getContents ());
        Session::put ($this->sessionTokenName, [
            'timestamp' => (new DateTime ())->getTimestamp (),
            'tokenObject' => $contents
        ]);
        Session::save ();
        return $contents;
    }

    /**
     * Initialize the Spotify token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean|mixed
     */
    private function initializeToken (Request $request)
    {
        return $this->refreshToken ($request);
    }

    /** 
     * Return the valid Spotify token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function getSpotifyToken (Request $request)
    {
        if (! Session::has ($this->sessionTokenName) || ! array_key_exists ('timestamp', Session::get ($this->sessionTokenName))) {
            return $this->initializeToken ($request);
        } else if (! $this->isValidToken ($request)) {
            return $this->refreshToken ($request);
        } else {
            return Session::get ($this->sessionTokenName) ['tokenObject'];
        }
    }

    /**
     * Send the request to fetch API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array                     $resources
     * @param  array                     $parameters
     * @return Response
     */
    public function sendRequest (Request $request, $resources, $parameters = [])
    {
        $contents = $this->getSpotifyToken ($request);
        try {
            if (! $contents) {
                throw new Exception ();
            }
            $response = $this->client->request ($resources ['method'], $resources ['url'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $contents->token_type.' '.$contents->access_token,
                ],
                'query' => $parameters
            ]);
            $response = $response->getBody ()->getContents ();
            return response ($response, 200);
            
        } catch (GuzzleHttp\Exception\BadResponseException $error) {
            return response ()->json (['statusCode' => 500, 'responseText' => 'Something is wrong. Please try again.'], 500);
        } catch (Exception $error) {
            return response ()->json (['statusCode' => 500, 'responseText' => 'Cannot complete the request.'], 500);
        }
    }
}