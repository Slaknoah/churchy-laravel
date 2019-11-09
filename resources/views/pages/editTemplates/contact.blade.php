@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-100">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Edit contact page</h6>
            <div class="mT-30 clearfix">
                @if (isset($page))    
                    {{ Form::open(array('action' => ['PageController@update', $page->slug], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputTitle">Title</label>
                                {{ Form::text( 'title', $page->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputTitle">Slug</label>
                                {{ Form::text( 'slug', $page->slug, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
                            </div>
                            @if (isset($templates))
                                <div class="form-group col-md-3">
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
                            <div class="form-group col-md-8 row">
                                <div class="col-md-6">
                                    <label for="inputTelephoneOne">Telephone 1</label> 
                                    {{ Form::number( 'meta[telephone_one]', get_meta($page, 'telephone_one'), ['class' => 'form-control', 'placeholder' => 'Phone One', 'id' => 'inputTelephoneOne']) }}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputTelephoneTwo">Telephone 2</label>
                                    {{ Form::number( 'meta[telephone_two]', get_meta($page, 'telephone_two'), ['class' => 'form-control', 'placeholder' => 'Phone One', 'id' => 'inputTelephoneTwo']) }}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputInstagram">Instagram</label>
                                    {{ Form::text( 'meta[instagram]', get_meta($page, 'instagram'), ['class' => 'form-control', 'placeholder' => 'Instagram', 'id' => 'inputInstagram']) }}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputTwitter">Twitter</label>
                                    {{ Form::text( 'meta[twitter]', get_meta($page, 'twitter'), ['class' => 'form-control', 'placeholder' => 'Twitter', 'id' => 'inputTwitter']) }}
                                </div>
                            </div>

                            <div class="form-group col-md-4 row">  
                                <div class="col-md-12">
                                    <label for="inputAddress">Address</label>
                                    {{Form::textarea('meta[address]', get_meta($page, 'address'), ['class' => 'form-control', 'placeholder' => 'Address', 'rows' => '8'])}}
                                </div>
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