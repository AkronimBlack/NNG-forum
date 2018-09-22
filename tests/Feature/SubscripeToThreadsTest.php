<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function a_user_can_subscribe_to_threads()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1 , $thread->fresh()->subscriptions);
    }

    /** @test */
    function a_user_can_unsubscribe_from_threads()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $this->post($thread->path() . '/subscriptions');



        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0 , $thread->subscriptions);

//        auth()->user()->notifications();

    }

}