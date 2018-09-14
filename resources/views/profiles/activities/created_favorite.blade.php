@component('profiles.activities.partial')
    @slot('heading')
        {{--{{dd($activity->subject)}}--}}
        {{$profileUser->name}} favorited a reply from
        <a href="/profiles/{{$activity->subject->reply->owner->name}}">{{$activity->subject->reply->owner->name}}</a>
        to thread
        <a href="{{$activity->subject->reply->thread->path()}}">{{$activity->subject->reply->thread->title}}</a>
    @endslot
    @slot('body')
        Reply: {{$activity->subject->reply->body}}
    @endslot
@endcomponent