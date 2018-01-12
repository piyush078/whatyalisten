<?php

namespace App\Http\Controllers;

use \Exception;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Variable for search.
     *
     * @var string
     */
    private $url = 'https://api.spotify.com/v1/albums';
    private $id;

    /**
     * Get the details of an album.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function album (Request $request)
    {
        return $this->sendRequest ($request, [
        	'method' => 'GET', 
        	'url' => $this->url.'/'.$this->id
        ]);
    }

    /**
     * Handle album data fetch request.
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
        return $this->album ($request);
    }
}
