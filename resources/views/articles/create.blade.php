@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-50">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Add new article</h6>
            <div class="mT-30 clearfix">
                {{ Form::open(array('action' => 'ArticleController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputTitle">Title</label>
                            {{ Form::text( 'title', null, ['class' => 'form-control', 'placehodler' => 'Title']) }}
                        </div>

                        <div class="form-group col-md-5">
                            <label for="inputSeries">Series</label>
    
                            {{-- Create series array --}}
                            @if (count($series) > 0)
                                @php
                                    $series_array = [];
    
                                    foreach ($series as $serie) {
                                        $series_array[$serie->id] = $serie->name;
                                    }
                                @endphp
                            @endif
                            {{ Form::select('series_id', $series_array, null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="image">Image</label>
                            {{Form::file('cover_image', ['class' => 'form-control-file', 'id' => 'inputCoverImage'])}}
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputContent">Content</label>
                            {{Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Content', 'cols' => '30', 'rows' => '10'])}}
                        </div>
                        
                    </div>

                    <div class="pull-right">
                        <label for="published">Publish</label>
                        {{ Form::checkbox('published', 1, false) }}
                    </div>
                    {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
@endsection