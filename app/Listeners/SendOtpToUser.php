<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\AuthService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOtpToUser implements  ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(protected AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function handle(UserRegistered $event): void
    {
        $this->authService->sendOtp($event->user);
    }
}
