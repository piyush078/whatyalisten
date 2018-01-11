<?php

namespace App\Http\Controllers;

use \Exception;
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
     * Search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    private function search (Request $request)
    {
        return $this->sendRequest ($request, [
            'method' => 'GET', 
            'url' => $this->url
        ], [
            'q' => urlencode ($this->title),
            'type' => $this->type,
            'limit' => $this->limit
        ]);
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
            return $this->invalidRequest ();
        }
    }
}
