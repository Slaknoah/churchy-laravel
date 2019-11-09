@extends('layouts.app')

@section('content')
<div class="full-container">
        <div class="email-app">
        <div class="email-side-nav remain-height ov-h">
          <div class="h-100 layers">
            @can('create', App\Article::class)
              <div class="p-20 bgc-grey-100 layer w-100">
                <a href="/articles/create" class="btn btn-danger btn-block">New article</a>
              </div>
            @endcan
            
            @if(count($series) > 0)
              <div class="scrollable pos-r bdT layer w-100 fxg-1">
                <ul class="p-20 nav flex-column">
                  @foreach ($series as $serie)
                    <li class="nav-item">
                        <a href="/articles/series/{{$serie->id}}" class="nav-link c-grey-800 cH-blue-500">
                          <div class="peers ai-c jc-sb">
                            <div class="peer peer-greed">
                              <span>{{$serie->name}}</span>
                            </div>
                            <div class="peer">
                              <span class="badge badge-pill bgc-deep-purple-50 c-deep-purple-700">{{ count($serie->articles) }}</span>
                            </div>
                          </div>
                        </a>
                      </li>
                  @endforeach
                </ul>
              </div>
            @endif
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
                        <h4 class="c-grey-900 mB-20">Articles</h4>
                        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th></th>
                                  </tr>
                                </tfoot>
                                <tbody>
                                    @if(count($articles) > 0)
                                        @foreach($articles as $key=>$article)
                                            <tr>
                                                <td>
                                                  @can('update', $article) 
                                                    <a href="/articles/{{ $article->id }}/edit">{{ $article->title}}</a>
                                                  @else
                                                    {{ $article->title }}
                                                  @endcan
                                                </td>
                                                <td>{{ $article->created_at }}</td>
                                                <td>
                                                  <a href="/author/{{ $article->author->id }}/articles">
                                                    {{ $article->author->name}}
                                                  </a>
                                                </td>
                                                <td>
                                                  @if ($article->published)
                                                      Published
                                                  @else
                                                      Draft
                                                  @endif
                                                </td>
                                                <td>
                                                    {!! Form::open(['action' => ['ArticleController@destroy', $article->id], 'method' => 'POST']) !!}
                                                        {{ Form::hidden('_method', 'DELETE')}}
                                                        <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger c-white-500 @cannot('delete', $article) disabled @endcannot" href="" type="submit">
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
