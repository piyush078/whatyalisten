<?php

namespace App\Http\Controllers;

use \Exception;
use \Response;
use GuzzleHttp;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Variable for search.
     *
     * @var string
     */
    private $url = 'https://api.spotify.com/v1/search';
    private $type;
    private $title;
    private $limit;

    /**
     * Send the request to fetch API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function search (Request $request)
    {
        $contents = $this->getSpotifyToken ($request);
        if (! $contents) {
            return response ('({Cannot complete the request.})', 500);
        }
        $accessToken = $contents->access_token;
        $tokenType = $contents->token_type;
        try {
            $response = $this->client->request ('GET', $this->url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $tokenType.' '.$accessToken,
                ],
                'query' => [
                    'q' => urlencode ($this->title),
                    'type' => $this->type,
                    'limit' => $this->limit
                ]
            ]);
            $response = '('.$response->getBody ()->getContents ().')';
            return response ($response, 200);

        } catch (GuzzleHttp\Exception\BadResponseException $error) {
            return response ('({Something is wrong. Please try again.})', 500);
        }
    }

    /**
     * Handle search request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function index (Request $request)
    {
        try {
            if (! $request->has (['type', 'title'])) {
                throw new Exception ();
            }

            $this->type = $request->query ('type');
            $this->title = $request->query ('title');
            $this->limit = $request->query ('limit', 5);

            $this->type = $this->type === 'artist' ? 'artist' : 'track';
            if (empty ($this->title)) {
                throw new Exception ();
            }
            $this->limit = ($this->limit && (int)$this->limit <= 5 && (int)$this->limit > 0) ? $this->limit : 5;
            return $this->search ($request);

        } catch (Exception $error) {
            return response ('({Invalid Request})', 400);
        }
    }
}
