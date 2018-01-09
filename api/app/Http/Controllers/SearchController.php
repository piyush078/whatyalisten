<?php

namespace App\Http\Controllers;

use Config;
use GuzzleHttp;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	/**
	 * Search for a songs title.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \GuzzleHttp\Guzzle\Client
	 */
    public function artists (Request $request, $title, $limit) {

        $headers = $this->getSpotifyHeaders ();
        $client_id = $headers ['client_id'];
        $client_secret = $headers ['client_secret'];
        $client = new GuzzleHttp\Client ();

        $authorization = base64_encode ($client_id.':'.$client_secret);

        try {
        	$tokenResponse = $client->request ('POST', 'https://accounts.spotify.com/api/token', [
        		'headers' => [
        			'Accept' => 'application/json',
        			'Authorization' => 'Basic '.$authorization,
        		],
        		'form_params' => [
        			'grant_type' => 'client_credentials'
        		]
        	]);

        	$contents = json_decode ($tokenResponse->getBody ()->getContents ());

            $access_token = $contents->access_token;
        	$token_type = $contents->token_type;

        	$url = 'https://api.spotify.com/v1/search';
        	$query = $title;
        	$type = 'artist';
            $limit = ($limit && (int)$limit <= 5 && (int)$limit > 0) ? $limit : 5;

        	$response = $client->request ('GET', $url, [
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

        	$response = json_decode ($response->getBody ()->getContents ());
        	dd ($response);

        } catch (GuzzleHttp\Exception\BadResponseException $error) {
        	dd ($error);
        }

    }
}
