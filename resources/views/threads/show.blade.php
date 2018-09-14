@extends('layouts.app')

@section('content')

    <div class="container-fluid">


        <div class="row">
            {{--THREAD PRINT OUT WITH REPLIS--}}
            <div class="col-md-8 offset-1">
                {{--CHECK IF THE TREAD HAS BEEN TRASHED--}}
                @if($thread->trash == 0)
                    {{--THREAD PARTIAL--}}
                    @include('threads.thread')
                    <hr>
                    <h3 class="text-center">Thread discussion</h3>
                    <hr>
                    {{--LIST OUT ALL REPLIES IN DB--}}
                    @include('threads.replies')
                    {{--AUTH AND ALLOW OR DENY OPTION TO COMMENT--}}
                    @if(auth()->check())
                        @include('threads.replyForm')
                    @else
                        <p class="text-center">Sign in to comment</p>
                    @endif
                    {{--IF THREAD IS DELETED--}}
                @else
                    <div class="card-header text-center">
                        <h2>This Thread ({{$thread->title}}) has been deleted</h2>
                    </div>

                @endif
            </div>
            {{--Right side panel with info--}}
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        Author:
                        <a href="/profiles/{{$thread->owner->name}}">{{$thread->owner->name}}</a>
                        <hr>
                        Published: {{$thread->created_at->diffForHumans()}}
                        <hr>
                        Channel:
                        <a href="/threads/{{$thread->channel->name}}">{{$thread->channel->name}}</a>
                        <hr>
                        Number of replies: {{$thread->replies_count}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
