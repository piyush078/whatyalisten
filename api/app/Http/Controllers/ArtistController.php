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
     * Check for valid request parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function checkParams (Request $request)
    {
        if (! $request->has ('id') || empty ($request->query ('id'))) {
            return $this->invalidRequest ();
        } else {
            $this->id = $request->query ('id');
            return false;
        }
    }

    /**
     * Get the details of an artist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function artist (Request $request)
    {
        $isValid = $this->checkParams ($request);
        if ($isValid) {
            return $isValid;
        } else {
            return $this->sendRequest ($request, [
            	'method' => 'GET', 
            	'url' => $this->url.'/'.$this->id
            ]);
        }
    }

    /**
     * Get the albums of artist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function albums (Request $request)
    {
    	$isValid = $this->checkParams ($request);
        if ($isValid) {
            return $isValid;
        } else {
            return $this->sendRequest ($request, [
        		'method' => 'GET',
        		'url' => $this->url.'/'.$this->id.'/albums'
        	], [
        		'limit' => '50',
        		'album_type' => $this->albumType
        	]);
        }
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
}
