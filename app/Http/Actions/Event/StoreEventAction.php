<?php

namespace App\Http\Actions\Event;

use App\Models\Event;

class StoreEventAction
{
    public function __invoke(array $payload)
    {
        return Event::create($payload);
    }
}
