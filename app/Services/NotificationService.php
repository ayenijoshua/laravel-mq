<?php
namespace App\Services;
use App\Models;

class NotificationService{

    private $rabbitMqService;
    public function __construct(){
        $this->rabbitMqService = new RabbitMQService();
    }

    public function consume(){

        //info('consuming');

        $callback = function($msg){
            info('rabbit',$msg->body);
        };

        retry(5, function () use ($callback) {
            info('consuming');
            // Attempt 5 times while resting 100ms between attempts...\
            $this->rabbitMqService->consume($callback);
        }, 100);
        
    }

}