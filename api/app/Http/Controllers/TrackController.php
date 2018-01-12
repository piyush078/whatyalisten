<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Variables for API.
     *
     * @var string
     */
    private $url = 'https://api.spotify.com/v1/tracks';
    private $id;

    /**
     * Get the details of a track.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function track (Request $request)
    {
        return $this->sendRequest ($request, [
        	'method' => 'GET', 
        	'url' => $this->url.'/'.$this->id
        ]);
    }

    /**
     * Handle tracks data request.
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
        return $this->track ($request);
    }
}
