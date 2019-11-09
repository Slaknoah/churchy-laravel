<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeriesResource;
use App\Message;
use App\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Index function
     */
    public function index(Request $request) {
        // Api request
        if(\isApiRequest($request)) {
            return SeriesResource::collection(Serie::offsetPaginate());            
        }

        $series = Serie::all();
        return view('series.index')->with(['series' => $series]);

    }

    /**
     * Store Series
     */
    public function store(Request $request) {

        $this->authorize('create', Serie::class);

        // Storing series data
        $series = new Serie;
        $series->name = $request->input('name');
        $series->save();

        // Saving post metas in case sent in request 
        // Post metas texts
        $metas = \get_req_metas($request, 'meta');
        \save_metas($series, $metas);
        
        // Api request
        if(\isApiRequest($request)) {
            return new SeriesResource($series);
        }

        return redirect()->route('series.edit', $series->id);
    }

    /**
     * Update Series
     */
    public function update(Request $request, Serie $series) {

        $this->authorize('update', $series);

        // Storing series data
        $series->name = $request->input('name');
        $series->save();

        // Saving post metas in case sent in request 
        $metas = \get_req_metas($request, 'meta');
        \save_metas($series, $metas);
        
        // Api request
        if(\isApiRequest($request)) {
            return new SeriesResource($series);
        }

        return redirect()->route('series.edit', $series->id);

    }
}
