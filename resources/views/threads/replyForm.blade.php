<form method="POST" action="{{$thread->path().'/replies'}}">
    @csrf
    <div class="form-group">
        <textarea class="form-control" name="body" rows="6" placeholder="Express your opinion"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Reply</button>
    </div>
    @include('layouts.errors')
</form>
