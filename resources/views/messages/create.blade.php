@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-50">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Add new message</h6>
            <div class="mT-30">
                {{ Form::open(array('action' => 'MessageController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                    <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="inputTitle">Title</label>
                        {{ Form::text( 'title', null, ['class' => 'form-control', 'placehodler' => 'Title']) }}
                    </div>

                    <div class="form-group col-md-5">
                        <label for="inputSpeaker">Speaker</label>

                        {{-- Create speakers array --}}
                        @if (count($speakers) > 0)
                            @php
                                $speakers_array = [];

                                foreach ($speakers as $speaker) {
                                    $speakers_array[$speaker->id] = $speaker->name;
                                }
                            @endphp
                        @endif
                        {{ Form::select('speaker_id', $speakers_array, null, ['class' => 'form-control']) }}
                    </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="image">Image</label>
                            {{Form::file('cover_image', ['class' => 'form-control-file', 'id' => 'inputCoverImage'])}}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputVideo">Media</label>
                            {{Form::file('media', ['class' => 'form-control-file', 'id' => 'inputMedia'])}}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputSeries">Series</label>
    
                            {{-- Create sereis array --}}
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
                    <div class="form-group">
                        <label for="inputDescription">Sermon summary</label>
                        {{Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Sermon summary', 'cols' => '30', 'rows' => '10'])}}
                    </div>
                    {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
@endsection