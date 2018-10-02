<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{

    protected $thread;

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_thrad_can_make_a_string_path()
    {

        $thread = factory('App\Thread')->create();

        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {

        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {

        $this->thread->addReply([
            'body'    => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_reg_subscribers()
    {
        Notification::fake();
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $this->thread->subscribe();

        $this->thread->addReply([
            'body'    => 'foobar',
            'user_id' => 1
        ]);

        Notification::assertSentTo(auth()->user() , ThreadWasUpdated::class);



    }


    /** @test */
    public function a_thread_has_a_channel()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    function a_thread_can_be_sub_to()
    {

        $thread = factory('App\Thread')->create();

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );

    }

    /** @test */
    function a_thread_can_be_unsub_to()
    {

        $thread = factory('App\Thread')->create();

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertEquals(0, $thread->subscribtions);

    }

    /** @test */
    function it_knows_if_user_is_subscribed_to_it()
    {

        $thread = factory('App\Thread')->create();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }
}
