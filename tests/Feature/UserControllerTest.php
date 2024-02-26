<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\UserCreated;
use App\Jobs\ConsumeMessage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_store_user(): void
    {
        Event::fake([UserCreated::class]);
        Queue::fake([ConsumeMessage::class]);
        
        $data = User::factory()->make()->toArray();
        $response = $this->postJson('api/create-user',$data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['first_name'=>$data['first_name']]);

        Event::assertDispatched(UserCreated::class,1);

        Queue::assertPushed(ConsumeMessage::class);
    }
}
