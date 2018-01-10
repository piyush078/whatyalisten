<?php

namespace App\Http\Controllers;

use \Exception;
use \Response;
use GuzzleHttp;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
	 * Search for a artist name.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \GuzzleHttp\Guzzle\Client
	 */
    public function artists (Request $request, $title, $limit) 
    {
        try {
            $contents = $this->getSpotifyToken ($request);
            if (! $contents) {
                dd ('Cannot complete the request.');
                return;
            }
            $access_token = $contents->access_token;
            $token_type = $contents->token_type;

        	$url = 'https://api.spotify.com/v1/search';
        	$query = $title;
        	$type = 'artist';
            $limit = ($limit && (int)$limit <= 5 && (int)$limit > 0) ? $limit : 5;

        	$response = $this->client->request ('GET', $url, [
        		'headers' => [
        			'Accept' => 'application/json',
        			'Authorization' => $token_type.' '.$access_token,
        		],
        		'query' => [
        			'q' => urlencode ($title),
        			'type' => $type,
                    'limit' => $limit
        		]
        	]);
        	$response = '('.$response->getBody ()->getContents ().')';
        	return Response ($response, 200);

        } catch (GuzzleHttp\Exception\BadResponseException $error) {
        	dd ('Something wrong.');
        }
    }
}
