
    {{--SEND REPLY TO VUE AS AN ATTRIBUTE--}}
    <reply :attributes="{$reply}" inline-template v-cloak>
        <div class="card">
            {{--TITLE/AUTHOR/TIME_OF_CREATE  REPLY HEADER--}}
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h4>
                            <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a></h4>
                        said {{$reply->created_at->diffForHumans()}}
                    </div>
                    <div class="col-md-2 text-right ">
                        {{--FAVORITE FORM--}}
                        @if(Auth::check())
                            <favorite :reply="{{$reply}}"></favorite>
                        @endif
                    </div>
                </div>
            </div>


            {{-- EDITING TOOLBAR --}}
            <div class="card-body">
                <div v-if="editing">
                    <textarea rows="3" class="form-control" v-model="body"></textarea>
                    <button class="btn btn-primary" @click="update">Edit</button>
                    <button class="btn btn-link" @click="editing = false">Cancel</button>
                </div>
                <div v-else v-text="body">
                </div>
            </div>


            {{--REPLY OPTIONS--}}
            @can ('update' , $reply)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 level">
                            {{--VUE INSTANCE--}}
                            <button class="btn btn-primary" @click="editing = true">Edit</button>
                            <button class="btn btn-primary" @click="destroy">Delete</button>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </reply>
    <hr>
