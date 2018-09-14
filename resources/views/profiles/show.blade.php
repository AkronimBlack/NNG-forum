@extends('layouts.app') @section('content')
    @include('profiles.jumbo')

    <div class="container">
        <hr>
        <div class="row">
            {{--@include('profiles.listThread')--}}
            <div class="col">
                <h1 class="text-center">Recent Activity</h1>
                <hr>
                @foreach($activities as $date=>$activity)
                    <h1>{{$date}} </h1>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}" , ['activity' => $record])
                        @endif
                        <hr>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection

