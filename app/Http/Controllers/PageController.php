<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;

use App\Http\Requests\StorePage;
use App\Page;
use App\Postmeta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Get templates 
     */
    private function getTemplates() {
        // Get templates into array
        $templates = [];
        $templatesPath = Storage::disk('views')->files('pages/editTemplates');

        foreach($templatesPath as $path)
        {
            $fileInfo = pathinfo($path);
            $templates[] = strtok($fileInfo['filename'], ".");
        }
        return $templates;
    }

    /**
     * Set template
     */
    private function checkTemplateName($template_input) {
        $template = 'default'; // set default value of template if not sent

        $templates = $this->getTemplates();
        if (!empty($template_input) && array_key_exists($template_input, $templates)) {
            // If template ID send and found in templates array
            $template = $templates[$template_input];
        } elseif(!empty($template_input) && in_array($template_input, $templates)) {
            // If template name sent and found in templates array
            $template = $template_input;
        }

        return $template;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Api request
        if(\isApiRequest($request)) {
            return PageResource::collection(Page::offsetPaginate());            
        }

        $pages = Page::all();
        return view('pages.index')->with(['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Page::class);
        return view('pages.create')->with(['templates' => $this->getTemplates()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePage $request)
    {
        $this->authorize('create', Page::class);

        // Storing page data
        $page = new Page;
        $page->title = $request->input('title');
        $page->setSlugAttribute($request->input('title'));
        $page->template = $this->checkTemplateName($request->input('template'));
        $page->content = $request->input('content');
        $page->author_id = $request->user()->id;
        $page->save();

        // Saving post metas in case sent in request 
        $metas = \get_req_metas($request, 'meta');
        \save_metas($page, $metas);
        
        // Api request
        if(\isApiRequest($request)) {
            return new PageResource($page);
        }

        return redirect( '/pages/' . $page->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Page $page)
    {
        // $page = Page::where('slug', $slug)->firstOrFail(); 
        if (\isApiRequest($request)) {
            return new PageResource($page);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        if (view()->exists('pages.editTemplates.'.$page->template)) {
            $view = 'pages.editTemplates.' . $page->template;
        } else {
             $view = 'pages.editTemplates.default';
        }
        return view($view)->with([
            'page' => $page, 
            'templates' => $this->getTemplates()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePage $request,Page $page)
    {
        $this->authorize('update', $page);

        $page->title = $request->input('title');

        if($page->slug !== $request->input('slug') && !empty($request->input('slug'))) 
            $page->setSlugAttribute($request->input('slug'));       
        $page->template = $this->checkTemplateName($request->input('template'));
        $page->content = $request->input('content');
        $page->save();


        // Post metas 
        $metas = \get_req_metas($request, 'meta');
        \save_metas($page, $metas);
        
        if(\isApiRequest($request)) {
            return new PageResource($page);
        }
        return redirect( '/pages/' . $page->slug . '/edit')->with(['success' => 'Page updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {
        $this->authorize('delete', Page::class);

        // Deleting page metas
        \delete_metas($page);

        $page->delete();

        if(\isApiRequest($request)) {
            return \json_encode(['message' => 'Page deleted!']);
        }

        return \redirect('/pages')->with([
            'success' => 'Page deleted!'
        ]);
    }
}
