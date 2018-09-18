@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{$thread->replies_count}}" inline-template>

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
                        <replies
                                 @removed="repliesCount--"
                                 @added="repliesCount++">

                        </replies>

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
                            Number of replies: <span v-text="repliesCount"></span>
                        </div>
                        <div class="card-footer text-center">
                            <subscribe :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe>
                        </div>

                    </div>



                </div>

            </div>
        </div>
    </thread-view>

@endsection
