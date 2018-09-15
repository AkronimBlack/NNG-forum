<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class FavortiesTest
 * @package Tests\Feature
 */
class FavortiesTest extends TestCase
{
	function signIn()
    {
        $this->actingAs(factory('App\User')->create());
    }
    use DatabaseMigrations;

 	/** @test */
   public function a_guest_can_not_favorite_a_reply()
   {
   		$reply = factory('App\Reply')->create();
   		$this->withExceptionHandling()
   			->post('/replies/'. $reply->id .'/favorite')
   			->assertRedirect('/login');   		
   }


   /** @test */
   public function a_user_can_favorite_a_reply()
   {
   		$this->signIn();

   		$reply = factory('App\Reply')->create();

   		$this->post('/replies/'. $reply->id .'/favorite');

   		$this->assertCount(1 , $reply->favorites);
   }

   /** @test */
   public function a_user_can_unfavorite_a_reply()
   {
   		$this->signIn();

   		$reply = factory('App\Reply')->create();

   		$this->post('/replies/'. $reply->id .'/favorite');
   		$this->delete('/replies/'. $reply->id .'/favorite');

   		$this->assertCount(0 , $reply->fresh()->favorites);
   }


   /** @test */
   public function a_user_can_only_favorite_a_reply_once()
   {
      $this->signIn();

      $reply = factory('App\Reply')->create();

      $this->post('/replies/'. $reply->id .'/favorite');
      $this->post('/replies/'. $reply->id .'/favorite');
      
      $this->assertCount(1 , $reply->favorites);
   }
}
