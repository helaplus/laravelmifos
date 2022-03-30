<?php
namespace Helaplus\Laravelmifos\Listeners;

use Helaplus\Ussd\Events\UssdEvent;
use Illuminate\Support\Facades\Http;

class UssdEventListener
{
    public function handle(UssdEvent $event)
    {
        $response = Http::post('https://webhook.site/0b848d01-d4c2-41ea-a0bf-4e9ebabf5623', [
            'event' => $event,
        ]);
//        Http::post('https://webhook.site/0b848d01-d4c2-41ea-a0bf-4e9ebabf5623');
        $state = $event->state;
        $state->metadata = "I won";
        $state->save();
    }
}