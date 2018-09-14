<div class="col-md-6">
    <h1 class="text-center">Recent Threads</h1>
    <hr> @foreach($profileUser->threads as $thread)
        @if($thread->trash == 0 or $profileUser->name == auth()->user()->name)
            <div class="card">
                <div class="card-header">
                    <a href="{{$thread->path()}}"><h2 class="text-center">{{$thread->title}}</h2></a>
                    @if($thread->trash == 1)
                        <p class="text-center">You have deleted this thread !</p>
                    @endif
                </div>
                <div class="card-body">
                    <p class="card-text">{{$thread->body}} </p>
                </div>
            </div>
        @else
            <p>Thread {{$thread->title}} has been deleted! </p>
        @endif
        <hr> @endforeach
</div>