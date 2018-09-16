<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test  */
    public function a_user_can_read_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /** @test  */
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }
    /** @test  */
    public function a_user_can_read_replies_of_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id'=>$this->thread->id]);

        $this->assertDatabaseHas('replies' , ['body' => $reply->body]);
    }

    /** @test  */
    public function a_user_can_filter_threads_acording_to_tag()
    {
        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);

        $threadNotInChannel = factory('App\Thread')->create();

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test  */
    public function a_user_can_filter_threads_by_user()
    {
        $user = factory('App\User')->create(['name' => 'Testname']);
        $this->actingAs($user);

        $threadByTestName = factory('App\Thread')->create(['user_id' => auth()->user()->id]);


        $threadByOther = factory('App\Thread')->create();

        $this->get('/threads?by=Testname')
            ->assertSee($threadByTestName->title)
            ->assertDontSee($threadByOther->title);
    }
    
//     /** @test  */
//    public function a_user_can_filter_threads_by_popularity()
//    {
//
//        $thread0replies = $this->thread;
//        $thread3replies = factory('App\Thread')->create();
//        create('App\Reply', ['thread_id' => $thread3replies->id], 3);
//        $thread2replies = factory('App\Thread')->create();
//        create('App\Reply', ['thread_id' => $thread2replies->id], 2);
//        dd($thread3replies);
//
//        $response = $this->getJson('/threads?popular=1')->json();
//
//
//        //failes couze of pagination
//        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
//    }

    /** @test  */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = factory('App\Thread')->create();
        create('App\Reply' , ['thread_id' => $thread->id] , 2);

        $response = $this->getJson($thread->path() . '/replies')->json();
//        dd($response);
        $this->assertCount(2 , $response['data']);
        $this->assertEquals(2 , $response['total']);
    }
    /** @test  */
    function a_user_can_sort_by_unanswerd()
    {
        $thread = factory('App\Thread')->create();
        factory('App\Reply')->create(['thread_id' => $thread->id]);
//        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?uncommented=1')->json();
//        dd($response);
        $this->assertCount(1, $response['data']);
    }
}
