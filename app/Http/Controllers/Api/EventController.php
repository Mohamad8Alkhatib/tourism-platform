<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(protected EventService $eventService) {}

    public function index(Request $request)
    {
        $perPage = min(max($request->integer('per_page', 15), 1), 50);

        return EventResource::collection($this->eventService->list($perPage));
    }

    public function show(Request $request, Event $event): EventResource
    {
        $user = $request->user('sanctum');

        abort_if(\Gate::forUser($user)->denies('view', $event), 404);

        return new EventResource($event->load(['city', 'category', 'images', 'creator']));
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        \Gate::authorize('create', Event::class);

        $event = $this->eventService->create($request->validated());

        return (new EventResource($event))->response()->setStatusCode(201);
    }

    public function update(UpdateEventRequest $request, Event $event): EventResource
    {
        \Gate::authorize('update', $event);

        return new EventResource($this->eventService->update($event, $request->validated()));
    }

    public function destroy(Event $event): JsonResponse
    {
        \Gate::authorize('delete', $event);

        $this->eventService->delete($event);

        return response()->json(null, 204);
    }
}
