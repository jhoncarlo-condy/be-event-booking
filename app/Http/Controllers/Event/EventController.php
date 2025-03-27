<?php

namespace App\Http\Controllers\Event;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Requests\EventFormRequest;

class EventController extends Controller
{
    public function index(Event $event)
    {
        $per_page = request()->query('per_page') ? request()->query('per_page') : 10;

        if (request()->query('upcoming')) {
            $event = $event->where('event_date', '>=', Carbon::today());
        }

        $result = $event->simplePaginate($per_page);

        $result->data = EventResource::collection($result);

        return response()->json($result);
    }

    public function show(Event $event)
    {
        return response()->json(new EventResource($event));
    }

    public function store(
        EventFormRequest $request,
        EventService $service,
    ) {
        return DB::transaction(function () use ($request, $service) {
            $result = $service->make($request);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event created successfully',
                ], Response::HTTP_CREATED);
            }

            return response()->json([
                'success' => false,
                'message' => 'Event creation failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    public function update(
        Event $event,
        EventFormRequest $request,
        EventService $service
    ) {
        return DB::transaction(function () use ($event, $request, $service) {
            if (empty($request->validated())) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event updated successfully'
                ], Response::HTTP_OK);
            }

            $result = $service->make($request, $event);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event updated successfully',
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => false,
                'message' => 'Event update failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    public function destroy()
    {

    }
}
