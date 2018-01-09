<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return Spotify headers.
     *
     * @return array
     */
    public function getSpotifyHeaders () 
    {
    	$headers = Config::get ('client');
    	return $headers;
    }
}
