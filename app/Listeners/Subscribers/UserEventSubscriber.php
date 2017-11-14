<?php

namespace App\Listeners\Subscribers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class UserEventSubscriber
{
    public function onLogin(Login $event)
    {
        \Log::info('login event:' . $event->user->getAuthIdentifierName());
    }

    public function onLogout(Logout $event)
    {
        \Log::info('logout event:' . $event->user->getAuthIdentifierName());
    }

    /**
     * 订阅
     *
     * @param Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        $dispatcher->listen(Login::class, 'App\Listeners\Subscribers\UserEventSubscriber@onLogin');
        $dispatcher->listen(Logout::class, 'App\Listeners\Subscribers\UserEventSubscriber@onLogout');
    }
}
