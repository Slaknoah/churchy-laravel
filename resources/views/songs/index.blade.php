@extends('layouts.app')

@section('content')
<div class="full-container">
        <div class="email-app">
        <div class="email-side-nav remain-height ov-h">
          <div class="h-100 layers">
            @can('create', App\Song::class)
              <div class="p-20 bgc-grey-100 layer w-100">
                <a href="/songs/create" class="btn btn-danger btn-block">New song</a>
              </div>
            @endcan
        
          </div>
        </div>
        <div class="email-wrapper row remain-height pos-r scrollable bgc-white">
          <div class="email-content open no-inbox-view">
                <div class="email-compose">
                    <div class="d-n@md+ p-20">
                        <a class="email-side-toggle c-grey-900 cH-blue-500 td-n" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                        </a>
                    </div>
                    <div class="email-compose-body">
                        <h4 class="c-grey-900 mB-20">Songs</h4>
                        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Tempo</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Tempo</th>
                                    <th></th>
                                  </tr>
                                </tfoot>
                                <tbody>
                                    @if(count($songs) > 0)
                                        @foreach($songs as $key=>$song)
                                            <tr>
                                                <td>
                                                  @can('update', $song) 
                                                    <a href="/songs/{{ $song->id }}/edit">{{ $song->title}}</a>
                                                  @else
                                                    {{ $song->title}}
                                                  @endcan
                                                </td>
                                                <td>{{ $song->artist }}</td>
                                                <td>{{$song->tempo}}</td>
                                                <td>
                                                    {!! Form::open(['action' => ['SongController@destroy', $song->id], 'method' => 'POST']) !!}
                                                        {{ Form::hidden('_method', 'DELETE')}}
                                                        <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger c-white-500 @cannot('delete', $song) disabled @endcannot" href="" type="submit">
                                                            <span class="icon-holder">
                                                                <i class="c-white-500 ti-trash"></i>
                                                            </span>
                                                            <span class="title">Delete</span>
                                                        </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
          </div>
        </div>
        </div>
      </div>
@endsection
