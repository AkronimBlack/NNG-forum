<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;
    public function signIn()
    {
        $this->actingAs(factory('App\User')->create());
    }

    /** @test */
    public function record_activity_when_thread_is_created()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id'=> auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function record_activity_when_reply_is_created()
    {
        $this->signIn();

        $reply = factory('App\Reply')->create();
        
        $this->assertEquals(2, \App\Activity::count());
    }
}
