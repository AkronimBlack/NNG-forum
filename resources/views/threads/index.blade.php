@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-3">Forum threads</h1>                            
    </div>
                          
                @forelse($threads as $thread)
                <div class="row justify-content-center">
                    <div class="col">
                    <div class="card">
                    <div class="card-header">  
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{$thread->path()}}"><h2> {{$thread->title}}</h2> </a> by:
                                <a href="/profiles/{{$thread->owner->name}}">{{$thread->owner->name}}</a>                           
                            </div>                           
                            <div class="col-md-6 text-right">                                
                                    <a href="{{$thread->path()}}">
                                      {{$thread->replies_count}} {{str_plural('reply' , $thread->replies_count)  }}
                                      </a>                       
                            </div>

                        </div>                       
                                               
                    </div>
                    <div class="card-body">
                        {{ $thread->body }} 
                        @can ('update' , $thread)
                        <div class="row">
                            <div class="col-md-12 text-right">
                                  <form action="{{$thread->path()}}" method="POST">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </div>
                                    </form>
                            </div>                                               
                        </div> 
                        @endcan                  
                    </div>
                    </div>
                    <hr>               
                @empty
                	<h2>There are no results for this thread yet</h2>

                @endforelse
                {{$threads->links()}}            
        </div>
    </div>
</div>
@endsection
