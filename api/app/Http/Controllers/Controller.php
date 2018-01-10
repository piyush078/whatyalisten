<?php

namespace App\Http\Controllers;

use Config;
use \DateTime;
use \Session;
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
    public $client = null;

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
    public function getSpotifyToken (Request $request)
    {
        if (! Session::has ($this->sessionTokenName) || ! array_key_exists ('timestamp', Session::get ($this->sessionTokenName))) {
            return $this->initializeToken ($request);
        } else if (! $this->isValidToken ($request)) {
            return $this->refreshToken ($request);
        } else {
            return Session::get ($this->sessionTokenName) ['tokenObject'];
        }
    }
}
