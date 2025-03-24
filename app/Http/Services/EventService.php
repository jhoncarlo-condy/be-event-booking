<?php

namespace App\Http\Services;

use App\Models\Event;
use App\Http\Requests\EventFormRequest;
use App\Http\Actions\Event\StoreEventAction;
use App\Http\Actions\Event\UpdateEventAction;

class EventService
{
    public function __construct(
        public StoreEventAction $store_action,
        public UpdateEventAction $update_action
    ){}

    public function make(EventFormRequest $request, ?Event $event = null)
    {
        return $request->isMethod('POST')
            ? ($this->store_action)($request->validated())
            : ($this->update_action)($event, $request->validated());
    }
}
