@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-100">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Add new page</h6>
            <div class="mT-30 clearfix">
                {{ Form::open(array('action' => 'PageController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputTitle">Title</label>
                            {{ Form::text( 'title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
                        </div>
                        @if ($templates)
                            <div class="form-group col-md-5">
                                @php
                                    foreach($templates as $key => $template) {
                                        if($template == 'default') {
                                            $defaultTemplate = $key;
                                        } 
                                    }
                                @endphp
                                <label for="inputTemplate">Page template</label>
                                {{Form::select('template', $templates, $defaultTemplate, ['class' => 'form-control', 'id' => 'inputTemplate'])}}
                            </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputContent">Content</label>
                            {{Form::textarea('content', null, ['class' => 'form-control text-editor', 'placeholder' => 'Content', 'cols' => '30', 'rows' => '30'])}}
                        </div>
                    </div>

                    <div class="float-right">
                        <div class="form-row">
                            {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                        </div>
                    </div>
                    
                    
                    
                {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
@endsection