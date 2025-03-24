<?php

namespace App\Http\Actions\Event;

use App\Models\Event;

class UpdateEventAction
{
    public function __invoke(Event $event, array $payload)
    {
        return $event->update($payload);
    }
}
