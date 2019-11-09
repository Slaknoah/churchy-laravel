@extends('layouts.app')

@section('content')
<div class="full-container">
        <div class="email-app">
        <div class="email-side-nav remain-height ov-h">
          <div class="h-100 layers">
            @can('create', App\Page::class)
              <div class="p-20 bgc-grey-100 layer w-100">
                <a href="/pages/create" class="btn btn-danger btn-block">New page</a>
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
                        <h4 class="c-grey-900 mB-20">Pages</h4>
                        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Template</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Template</th>
                                    <th></th>
                                  </tr>
                                </tfoot>
                                <tbody>`
                                    @if(count($pages) > 0)
                                        @foreach($pages as $key=>$page)
                                            <tr>
                                                <td>
                                                  @can('update', $page) 
                                                    <a href="/pages/{{ $page->slug }}/edit">{{ $page->title}}</a>
                                                  @else
                                                    {{ $page->title }}
                                                  @endcan
                                                </td>
                                                <td>{{ $page->created_at }}</td>
                                                <td>
                                                  <a href="/author/{{ $page->author->id }}/pages">
                                                    {{ $page->author->name}}
                                                  </a>
                                                </td>
                                                <td>
                                                  {{$page->template}}
                                                </td>
                                                <td>
                                                    {!! Form::open(['action' => ['PageController@destroy', $page->slug], 'method' => 'POST']) !!}
                                                        {{ Form::hidden('_method', 'DELETE')}}
                                                        <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger c-white-500 @cannot('delete', $page) disabled @endcannot" href="" type="submit">
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
