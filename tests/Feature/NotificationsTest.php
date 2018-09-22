<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_thread_recives_a_reply_by_other_user()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create()->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'something',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $otherUser = factory('App\User')->create();

        $thread->addReply([
            'user_id' => $otherUser->id,
            'body'    => 'something',
        ]);
        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create()->subscribe();

        $otherUser = factory('App\User')->create();

        $thread->addReply([
            'user_id' => $otherUser->id,
            'body'    => 'something',
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete('/profiles/'. auth()->user()->name .'/notifications/' . $notificationId);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }


    /** @test */
    public function a_user_can_fetch_unread_notifications()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create()->subscribe();

        $otherUser = factory('App\User')->create();

        $thread->addReply([
            'user_id' => $otherUser->id,
            'body'    => 'something',
        ]);

        $response = $this->getJson('/profiles/'. auth()->user()->name .'/notifications')->json();

        $this->assertCount(1 , $response);
    }
}
