<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\StoreArticle;
use App\Http\Resources\ArticleResource;
use App\Search\ArticleSearch;
use App\Serie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $series;

    /**
     * Middleware protection.
     *
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'filter']);

        // Getting and storing series once
        $this->series = Serie::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // If can list all draft return all drafts
        if (auth()->check()) {
            if (auth()->user()->can('listDrafts', Article::class)) {
                $articles = Article::all();
            } else {
                // Else if has own draft add to list of published articles
                if (\isApiRequest($request)) {
                    $articles = Article::
                        where('published', true)
                        ->orWhere('author_id', auth()->user()->id)
                        ->offsetPaginate();
                } else {
                    $articles = Article::
                        where('published', true)
                        ->orWhere('author_id', auth()->user()->id)
                        ->get();
                }

            }
        } else {
            // Else if has own draft add to list of published articles
            if (\isApiRequest($request)) {
                $articles = Article::
                    where('published', true)
                    ->offsetPaginate();
            } else {
                $articles = Article::
                    where('published', true)
                    ->get();
            }
        }

        // Api request
        if (\isApiRequest($request)) {
            return ArticleResource::collection($articles);
        }

        return view('articles.index')->with(['articles' => $articles, 'series' => $this->series]);
    }

    /**
     * List published articles
     */
    public function listPublished(Request $request)
    {
        if (\isApiRequest($request)) {
            return ArticleResource::collection(Article::where('published', true)->offsetPaginate());
        }

        $publishedArticles = Article::where('published', true)->get();
        return view('articles.index')->with(['articles' => $publishedArticles, 'series' => $this->series]);

    }

    /**
     * List drafts
     */
    public function listDrafts(Request $request)
    {
        $this->authorize('listDrafts', Article::class);

        if (\isApiRequest($request)) {
            return ArticleResource::collection(Article::where('published', false)->offsetPaginate());
        }

        $drafts = Article::where('published', false)->get();
        return view('articles.index')->with(['articles' => $drafts, 'series' => $this->series]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Article::class);
        return view('articles.create')->with(['series' => $this->series]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        $this->authorize('create', Article::class);

        // Validating the cover image gotten
        if ($request->hasFile('cover_image')) {
            // Save file
            $cover_image_file_name = save_file($request->file('cover_image'), 'articles_cover_images');
        } else {
            $cover_image_file_name = false;
        }

        $article = new Article;
        $article->title = $request->input('title');
        $article->series_id = $request->input('series_id');
        $article->content = $request->input('content') ?? false;
        $article->cover_image = $cover_image_file_name;
        $article->author_id = auth()->user()->id;
        $article->published = $request->input('published') ?? false;
        $article->save();

        // Api request
        if (\isApiRequest($request)) {
            return new ArticleResource($article);
        }

        return redirect('/articles')->with(['success' => 'Article saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Article $article)
    {
        if (\isApiRequest($request)) {
            return new ArticleResource($article);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit')->with(['article' => $article, 'series' => $this->series]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArticle $request, Article $article)
    {

        $this->authorize('update', $article);

        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($article->cover_image) {
                Storage::delete('public/articles_cover_images/' . $article->cover_image);
            }

            // Save new image
            $cover_image_file_name = save_file($request->file('cover_image'), 'articles_cover_images');
        }

        $article->title = $request->input('title');
        $article->series_id = $request->input('series_id');
        $article->content = $request->input('content') ?? false;
        $article->published = $request->input('published') ?? false;

        if ($request->hasFile('cover_image')) {
            $article->cover_image = $cover_image_file_name;
        }

        $article->save();

        // Api request
        if (\isApiRequest($request)) {
            return new ArticleResource($article);
        }

        return redirect('/articles')->with(['success' => 'Article updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        $this->authorize('delete', $article);

        // Delete cover image
        if ($article->cover_image) {
            Storage::delete('public/articles_cover_images/' . $article->cover_image);
        }

        // Delete media file
        if ($article->media != '--') {
            Storage::delete('public/articles_media/' . $article->media);
        }

        $article->delete();

        if (\isApiRequest($request)) {
            return \json_encode(['message' => 'Article deleted!']);
        }

        return redirect('/articles')->with(['success' => 'article deleted!']);
    }

    /**
     * Get articles created by a user (author)
     */
    public function authorArticles(Request $request, User $author)
    {
        if (\isApiRequest($request)) {
            return ArticleResource::collection($author->articles()->offsetPaginate());
        }

        $articles = $author->articles()->get();
        $series = Serie::all();
        return view('articles.index')->with(['articles' => $articles, 'series' => $series]);
    }

    /**
     * Get serie articles
     */
    public function serieArticles(Request $request, Serie $series)
    {
        if (\isApiRequest($request)) {
            return ArticleResource::collection($series->articles()->offsetPaginate());
        }

        $articles = $series->articles()->get();
        $series = Serie::all();
        return view('articles.index')->with(['articles' => $articles, 'series' => $series]);
    }

    /**
     * Filter messages by given parameters
     *
     */
    public function filter(Request $request)
    {
        $articleSearch = new ArticleSearch;
        return $articleSearch->apply($request);
    }

}