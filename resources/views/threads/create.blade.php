@extends('layouts.app')

@section('content')
<div class="container">

    <div class="jumbotron">
        <h1 class="display-3">Forum threads</h1>                            
    </div>

    <form action="/threads" method="POST">

        @csrf 

        <div class="form-group">
            Title:
            <input type="text" name="title" class="form-control" value = "{{old('title')}}" required>
        </div>

        <div class="form-group">
            Article:
            <textarea class="form-control" name="body" rows="10" required>                
                    {{old('body')}}
            </textarea>
        </div>

        <div class="form-group">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Channels</label>
          <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="channel_id" required>
            <option selected>Choose a channel...</option> 

            @foreach ($channels as $channel)
                <option value="{{$channel->id}}" {{old('channel') == $channel->id ? 'selected' : ''}} >{{$channel->name}} </option>
            @endforeach

          </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Post</button>
        </div>

        @include('layouts.errors')

    </form>
</div>
@endsection