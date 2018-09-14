@component('profiles.activities.partial') 
@slot('heading') 
{{$activity->subject->owner->name}} replied to
<a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a> at {{$activity->created_at->toTimeString()}} 
@endslot 
@slot('body')
<p>Reply Text: {{$activity->subject->body}}</p>
<hr>
<p>Number of times favorited: {{count($activity->subject->favorites)}}</p>
@endslot 
@endcomponent
