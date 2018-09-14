<div class="card">
    {{--TITLE--}}
        <div class="card-header text-center">
            <h1>{{$thread->title}}</h1>
        </div>
    {{--BODY--}}
        <div class="card-body">
            {{ $thread->body }}
            {{--CHECK IF UPDATE/DELETE ALLOWED--}}
            @can ('update' , $thread)
                <div class="row">
                    {{--FORM DELETE--}}
                    <div class="col-md-12 text-right">
                        <form action="{{$thread->path()}}" method="POST">
                            @csrf
                            {{method_field('DELETE')}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
        </div>

</div>