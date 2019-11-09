<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Http\Resources\MessageResource;
use App\Message;
use App\Search\MessageSearch;
use App\Serie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{

    /**
     * Middleware protection.
     *
     */
    protected $request;

    public function __construct(Request $request)
    {
        if (\isApiRequest($request)) {
            $this->middleware('auth:api', ['except' => ['index', 'filter', 'show', 'serieMessages', 'speakerMessages']]);
        } else {
            $this->middleware('auth');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Api request
        if (\isApiRequest($request)) {
            return MessageResource::collection(Message::orderBy('id', 'desc')->offsetPaginate());
        }

        $messages = Message::all();
        $series = Serie::all();
        return view('messages.index')->with(['messages' => $messages, 'series' => $series]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Message::class);

        $speakers = User::whereHas(
            'roles', function ($q) {
                $q->where('name', 'speaker');
            }
        )->get();
        $series = Serie::all();

        return view('messages.create')->with(['speakers' => $speakers, 'series' => $series]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessage $request)
    {
        $this->authorize('create', Message::class);

        // Validating the cover image gotten
        $cover_image_file_name = null;
        if ($request->hasFile('cover_image')) {
            $cover_image_file_name = save_file($request->file('cover_image'), 'messages_cover_images');
            $cover_image_url = \getFileUrl($cover_image_file_name, 'messages_cover_images');
        }

        // Validating the media file
        $media_file_name = null;
        if ($request->hasFile('media')) {
            $media_urls = [];
            foreach($request->file('media') as $media) 
                $media_urls[] = \getFileUrl(save_file($media, 'messages_media'), 'messages_media');
            // $media_file_name = save_file($request->file('media'), 'messages_media');
        }

        $message = new Message;
        $message->title = $request->input('title');
        $message->speaker_id = $request->input('speaker_id');
        $message->series_id = $request->input('series_id');
        $message->description = $request->input('description');
        $message->media = json_encode($media_urls);
        $message->cover_image = $cover_image_url;
        $message->author_id = auth()->user()->id;
        $message->save();

        // Saving post metas in case sent in request
        $metas = \get_req_metas($request, 'meta');
        \save_metas($message, $metas);

        // Api request
        if (\isApiRequest($request)) {
            return new MessageResource($message);
        }

        return redirect('/messages')->with(['success' => 'Message saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {
        if (\isApiRequest($request)) {
            return new MessageResource($message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        $this->authorize('update', $message);

        $speakers = User::whereHas(
            'roles', function ($q) {
                $q->where('name', 'speaker');
            }
        )->get();

        $series = Serie::all();

        return view('messages.edit')->with([
            'message' => $message,
            'speakers' => $speakers,
            'series' => $series,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMessage $request, Message $message)
    {
        // $this->authorize('update', $message);

        // Validating the cover image gotten
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($message->cover_image) {
                Storage::delete('public/messages_cover_images/' . $message->cover_image);
            }

            // Save new image
            $cover_image_file_name = save_file($request->file('cover_image'), 'messages_cover_images');

        }

        // Validating the media file
        if ($request->hasFile('media')) {
            // Delete old cover image
            if ($message->media != '--') {
                Storage::delete('public/messages_media/' . $message->media);
            }

            $media_file_name = save_file($request->file('medis'), 'messages_media');
        }

        $message->title = $request->input('title');
        $message->speaker_id = $request->input('speaker_id');
        $message->series_id = $request->input('series_id');
        $message->description = $request->input('description');

        if ($request->hasFile('media')) {
            $message->media = $media_file_name;
        }

        if ($request->hasFile('cover_image')) {
            $message->cover_image = $cover_image_file_name;
        }

        $message->save();

        // Saving post metas in case sent in request
        $metas = \get_req_metas($request, 'meta');
        \save_metas($message, $metas);

        if (\isApiRequest($request)) {
            return new MessageResource($message);
        }
        return redirect('/messages')->with(['success' => 'Message updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Message $message)
    {
        $this->authorize('delete', $message);

        // Delete cover image
        if ($message->cover_image) {
            Storage::delete('public/messages_cover_images/' . $message->cover_image);
        }

        // Delete media file
        if ($message->media != '--') {
            Storage::delete('public/messages_media/' . $message->media);
        }

        $message->delete();

        if (\isApiRequest($request)) {
            return \json_encode(['message' => 'Message deleted!']);
        }

        return redirect('/messages')->with(['success' => 'Message deleted!']);
    }

    /**
     * Get messages created by a user (author)
     */
    public function authorMessages(Request $request, User $author)
    {
        if (\isApiRequest($request)) {
            return MessageResource::collection($author->authorMessages()->offsetPaginate());
        }

        $messages = $author->authorMessages()->get();
        $series = Serie::all();

        return view('messages.index')->with(['messages' => $messages, 'series' => $series]);
    }

    /**
     * Get messages created by a user (speaker
     */
    public function speakerMessages(Request $request, User $speaker)
    {
        if (\isApiRequest($request)) {
            return MessageResource::collection($speaker->speakerMessages()->offsetPaginate());
        }

        $messages = $speaker->speakerMessages()->get();
        $series = Serie::all();

        return view('messages.index')->with(['messages' => $messages, 'series' => $series]);
    }

    /**
     * Get serie messages
     */
    public function serieMessages(Request $request, Serie $series)
    {
        if (\isApiRequest($request)) {
            return MessageResource::collection($series->messages()->offsetPaginate());
        }

        $messages = $series->messages()->get();
        $series = Serie::all();

        return view('messages.index')->with(['messages' => $messages, 'series' => $series]);
    }

    /**
     * Filter messages by given parameters
     *
     */
    public function filter(Request $request)
    {
        $messageSearch = new MessageSearch;
        return $messageSearch->apply($request);
    }
}
