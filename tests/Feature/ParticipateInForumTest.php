<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    public function an_unauth_user_may_participate()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();

        $this->post($thread->path() . '/replies' , $reply->toArray());      
        
    }


    /** @test */
    public function a_auth_user_may_participate()
    {
    	$this->be($user = factory('App\User')->create());

    	$thread = factory('App\Thread')->create();

    	$reply = factory('App\Reply')->make();

    	$this->post($thread->path() . '/replies' , $reply->toArray());
        
        $this->get($thread->path())
            ->assertSee($reply->body);
    	
    }
}
