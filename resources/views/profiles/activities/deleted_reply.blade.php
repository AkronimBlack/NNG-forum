@component('profiles.activities.partial')
    @slot('heading')
        {{$activity->subject->owner->name}} deleted a reply to Thread:
        <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a> at {{$activity->created_at->toTimeString()}}
    @endslot
    @slot('body')
        {{--<p class="card-text"> Number of replies:  {{$activity->subject->replies_count}}</p>--}}
    @endslot
@endcomponent