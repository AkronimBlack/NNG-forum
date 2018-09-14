<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ReplyTest extends TestCase
{

	use DatabaseMigrations;


    /** @test */
    public function it_has_an_owner()
    {
       $reply = factory('App\Reply')->create();

       $this->assertInstanceOf('App\User' , $reply->owner);
    }

    /** @test */
    public function an_auth_user_can_delete_reply()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

//        $reply = create('App\Reply' , ['user_id' => auth()->id()]);
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302)
            ->assertDontSee($reply->body);
    }

    /** @test */
    public function an_unauth_user_cannot_delete_reply()
    {
        $this->withExceptionHandling();
        $reply = factory('App\Reply')->create();
        $this->delete("/replies/{$reply->id}")->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_auth_user_can_update_reply()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $update = 'Some string to serve as update';
//        $reply = create('App\Reply' , ['user_id' => auth()->id()]);
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);

        $this->patch("/replies/{$reply->id}" , ['body' => $update]);

        $this->assertDatabaseHas('replies', ['body' => $update]);
    }

    /** @test */
    public function an_unauth_user_cannot_update_reply()
    {
        $this->withExceptionHandling();
        $reply = factory('App\Reply')->create();
        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');
    }

}
