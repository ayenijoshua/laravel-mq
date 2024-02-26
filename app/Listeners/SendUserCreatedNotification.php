<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\RabbitMQService;

class SendUserCreatedNotification
{
    public $rabbitMqService;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->rabbitMqService = new RabbitMQService();
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $message = json_encode($event->data);
        $this->rabbitMqService->publish($message);
    }
}
