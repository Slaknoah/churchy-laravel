@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-50">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Add new song</h6>
            <div class="mT-30 clearfix">
                {{ Form::open(array('action' => 'SongController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputTitle">Title</label>
                            {{ Form::text( 'title', null, ['class' => 'form-control', 'placeholder' => 'Title']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputArtist">Artist</label>
                            {{ Form::text( 'artist', null, ['class' => 'form-control', 'placeholder' => 'Song artist']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputTempo">Tempo</label>
                            {{ Form::number( 'tempo', null, ['class' => 'form-control', 'placeholder' => 'Tempo(bpm)']) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputSongCover">Song cover</label>
                            {{Form::file('song_cover', ['class' => 'form-control-file', 'id' => 'inputSongCover'])}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputOriginalSong">Original song</label>
                            {{Form::file('original_song', ['class' => 'form-control-file', 'id' => 'inputOriginalSong'])}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputChord">Chord</label>
                            {{Form::textarea('chord', '', ['class' => 'form-control', 'placeholder' => 'Song chord', 'cols' => '30', 'rows' => '10'])}}
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputContent">Lyrics</label>
                            {{Form::textarea('lyrics', '', ['class' => 'form-control', 'placeholder' => 'Song lyrics', 'cols' => '30', 'rows' => '20'])}}
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