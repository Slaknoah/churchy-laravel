<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSong;
use App\Http\Resources\SongResource;
use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    /**
     * Middleware protection.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('list', Song::class);

        // Api request
        if (\isApiRequest($request)) {
            return SongResource::collection(Song::offsetPaginate());
        }

        $songs = Song::all();
        return view('songs.index')->with(['songs' => $songs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Song::class);
        return view('songs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSong $request)
    {
        {
            $this->authorize('create', Song::class);

            // Validating the cover image gotten
            if ($request->hasFile('song_cover')) {
                // Save file
                $song_cover_file_name = \save_file($request->file('song_cover'), 'song_covers');
            } else {
                $song_cover_file_name = false;
            }

            // Handling original song
            if ($request->hasFile('original_song')) {
                //  Save File
                $original_song_file_name = \save_file($request->file('original_song'), 'original_songs');
            } else {
                $original_song_file_name = '--';
            }

            $song = new Song;
            $song->title = $request->input('title');
            $song->artist = $request->input('artist') ?? '';
            $song->tempo = $request->input('tempo') ?? '';
            $song->song_cover = $song_cover_file_name;
            $song->original_song = $original_song_file_name;
            $song->chord = $request->input('chord') ?? '';
            $song->lyrics = $request->input('lyrics') ?? '';
            $song->author_id = auth()->user()->id;
            $song->save();

            // Api request
            if (\isApiRequest($request)) {
                return new SongResource($song);
            }

            return redirect('/songs')->with(['success' => 'Song saved!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Song $song)
    {
        if (\isApiRequest($request)) {
            return new SongResource($song);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        return view('songs.edit')->with('song', $song);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSong $request, Song $song)
    {
        $this->authorize('update', Song::class);

        // Validating the cover image gotten
        if ($request->hasFile('song_cover')) {
            // Delete old song cover
            if ($song->song_cover) {
                Storage::delete('public/song_covers/' . $song->song_cover);
            }
            // Save file
            $song_cover_file_name = \save_file($request->file('song_cover'), 'song_covers');
        }

        // Handling original song
        if ($request->hasFile('original_song')) {
            // Delete old song
            if ($song->song_cover) {
                Storage::delete('public/original_songs/' . $song->original_song);
            }
            //  Save File
            $original_song_file_name = \save_file($request->file('original_song'), 'original_songs');
        }

        $song->title = $request->input('title');
        $song->artist = $request->input('artist') ?? '';
        $song->tempo = $request->input('tempo') ?? '';

        if ($request->hasFile('song_cover')) {
            $song->song_cover = $song_cover_file_name;
        }

        if ($request->hasFile('original_song')) {
            $song->original_song = $original_song_file_name;
        }
        $song->chord = $request->input('chord') ?? '';
        $song->lyrics = $request->input('lyrics') ?? '';
        $song->author_id = auth()->user()->id;
        $song->save();

        if (\isApiRequest($request)) {
            return new SongResource($song);
        }

        return redirect('/songs')->with(['success' => 'Article saved!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Song $song)
    {
        $this->authorize('delete', $song);

        // Delete song cover
        if ($song->song_cover != 'no-image.jpg') {
            Storage::delete('public/song_covers/' . $song->song_covers);
        }

        // Delete original song
        if ($song->original_song != '--') {
            Storage::delete('public/original_songs/' . $song->original_song);
        }

        $song->delete();

        if (\isApiRequest($request)) {
            return \json_encode(['message' => 'Song deleted!']);
        }

        return redirect('/songs')->with(['success' => 'Song deleted!']);
    }
}