@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-100">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Edit about page</h6>
            <div class="mT-30 clearfix">
                @if (isset($page))    
                    {{ Form::open(array('action' => ['PageController@update', $page->slug], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="inputTitle">Title</label>
                                {{ Form::text( 'title', $page->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
                            </div>
                            @if (isset($templates))
                                <div class="form-group col-md-5">
                                    @php
                                        foreach($templates as $key => $template) {
                                            if($template == $page->template) {
                                                $pageTemplate = $key;
                                            } 
                                        }
                                    @endphp
                                    <label for="inputTemplate">Page template</label>
                                    {{Form::select('template', $templates, $pageTemplate, ['class' => 'form-control', 'id' => 'inputTemplate'])}}
                                </div>
                            @endif
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputVideo">Video</label>
                                {{Form::file('meta[video]', ['class' => 'form-control-file', 'id' => 'inputVideo'])}}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputVideoCover">Video cover</label>
                                {{Form::file('meta[video_cover]',['class' => 'form-control-file', 'id' => 'inputVideoCover'])}}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputContent">Content</label>
                                {{Form::textarea('content', $page->content, ['class' => 'form-control text-editor', 'placeholder' => 'Content', 'cols' => '30', 'rows' => '30'])}}
                            </div>
                        </div>

                        <div class="float-right">
                            <div class="form-row">
                                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                            </div>
                        </div>
                        {{Form::hidden('_method', 'PUT')}}
                    {{Form::close()}}
                @endif
            </div>
          </div>
        </div>
      </div>
@endsection