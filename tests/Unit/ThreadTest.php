<?php

namespace Tests\Unit;

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

        $this->assertEquals( '/threads/' . $thread->channel->slug . '/' . $thread->id , $thread->path());
    }

    /** @test */
    public function a_thread_has_replies()
    {
    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {   	

    	$this->assertInstanceOf('App\User' , $this->thread->owner);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {       

        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }


    /** @test */
    public function a_thread_has_a_channel()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel' , $thread->channel);
    }

    
}
