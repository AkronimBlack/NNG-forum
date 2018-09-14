<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    protected $user;
    public function signIn()
    {
        $this->user = factory('App\User')->create();
        $this->actingAs($this->user);
    }

    use DatabaseMigrations;
    /** @test */
    public function guest_may_not_create_thread()
    {
        $this->withExceptionHandling();

        $this->post('/threads')
            ->assertRedirect('/login');
        

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_auth_user_can_create_threds()
    {
        $this->signIn();

        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());

        //Test DB entry

        $this->assertDatabaseHas('threads', ['title' => $thread->title]);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->withExceptionHandling()->actingAs(factory('App\User')->create());

        $thread=factory('App\Thread', ['titile'=>null])->make();

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function an_auth_user_can_delete_thread()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create(['user_id' =>$this->user->id]);
        $reply = factory('App\Reply')->create(['thread_id' =>$thread->id]);

        $response = $this->json('DELETE', $thread->path());

//        $this->assertDatabaseMissing('replies', ['thread_id' => $thread->id]);
//        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
//        Changed from deleting the thread to making its trash atribute 1 so it still remains in DB,
//        however the assertDatabaseMissing no longer will work couze the thread is still in the DB
        $this->get('/threads')
            ->assertDontSee($thread->title)
            ->assertDontSee($reply->body);

//        $this->assertEquals(0, Activity::count());
        $response->assertStatus(204);
    }

    /** @test */
    public function an_unauth_user_cannot_delete_thread()
    {
        $this->withExceptionHandling();
        $thread = factory('App\Thread')->create();

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(401);

        $this->signIn();
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(403);
    }
}
