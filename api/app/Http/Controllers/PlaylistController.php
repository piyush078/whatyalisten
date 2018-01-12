<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Variable for API.
     *
     * @var string
     */
    private $url = 'https://api.spotify.com/v1/browse';

    /**
     * Get the latest releases.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function latest (Request $request)
    {
        return $this->sendRequest ($request, [
        	'method' => 'GET', 
        	'url' => $this->url.'/new-releases'
        ], [
        	'country' => 'US',
        	'limit' => 10,
        	'offset' => 0
        ]);
    }

    /**
     * Handle playlists data request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function index (Request $request)
    {
        return $this->latest ($request);
    }
}
