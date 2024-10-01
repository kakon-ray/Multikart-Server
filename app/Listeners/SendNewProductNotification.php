<?php

namespace App\Listeners;

use App\Events\NewProduct;
use App\Mail\NewProductAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewProductNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewProduct $event): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewProductAdded());
        }
    }
}
