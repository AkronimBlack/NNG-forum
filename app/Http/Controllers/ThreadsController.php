<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\Filters\ThreadFilter;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create', 'destroy');
    }

    /**
     * Display a listing of the resource where 'trash' columne isnt true
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filters)
    {
        $threads=Thread::where('trash' , false)->latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->paginate(5);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'channel_id'=>'required|exists:channels,id'
        ]);

        
        $thread=Thread::Create([
            'user_id'=>auth()->id(),
            'channel_id'=>Request('channel_id'),
            'body'=>Request('body'),
            'title'=>Request('title')
        ]);

        return redirect($thread->path())->with('flash' , 'Your Thread has been posted');
    }

    /**
     * Display the specified resource.
     *
     * @param $channelSlug
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelSlug, Thread $thread)
    {

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * Thread 'trash' colum in DB is changed from false to true
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channelSlug, Thread $thread)
    {
        $this->authorize('update', $thread);
   
        $thread->update(['trash'=>true]);

        $thread->replies->each(function ($reply) {
                $reply->update(['trash'=>true]);
            });

        $thread->logDeleteActivity();

        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads')->with('flash' , 'Your Thread has been deleted');
    }
}