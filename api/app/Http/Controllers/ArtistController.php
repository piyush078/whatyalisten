<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Variables for API.
     *
     * @var string
     */
    private $url = 'https://api.spotify.com/v1/artists';
    private $id;
    private $albumType = 'album';

    /**
     * Get the details of an artist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function artist (Request $request)
    {
        return $this->sendRequest ($request, [
        	'method' => 'GET', 
        	'url' => $this->url.'/'.$this->id
        ]);
    }

    /**
     * Get the albums of artist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function albums (Request $request)
    {
    	return $this->sendRequest ($request, [
    		'method' => 'GET',
    		'url' => $this->url.'/'.$this->id.'/albums'
    	], [
    		'limit' => 100,
    		'album_type' => $this->albumType
    	]);
    }

    /**
     * Get the top tracks of artist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function tracks (Request $request)
    {
    	return $this->sendRequest ($request, [
    		'method' => 'GET',
    		'url' => $this->url.'/'.$this->id.'/top-tracks'
    	], [
            'country' => 'US'
        ]);
    }

    /**
     * Get the related artists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function related (Request $request)
    {
    	return $this->sendRequest ($request, [
    		'method' => 'GET',
    		'url' => $this->url.'/'.$this->id.'/related-artists'
    	]);
    }

    /**
     * Handle artist data request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function index (Request $request)
    {
        if (! $request->has ('id') || empty ($request->query ('id'))) {
            return $this->invalidRequest ();
        }
        $this->id = $request->query ('id');
        return $this->artist ($request);
    }
}
