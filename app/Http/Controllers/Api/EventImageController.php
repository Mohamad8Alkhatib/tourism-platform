<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaceImagesRequest;
use App\Http\Resources\ImageResource;
use App\Models\Event;
use App\Services\EventImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EventImageController extends Controller
{
    public function __construct(protected EventImageService $imageService) {}

    public function store(StorePlaceImagesRequest $request, Event $event): JsonResponse
    {
        \Gate::authorize('update', $event);

        $images = $this->imageService->store($event, $request->file('images'));

        return ImageResource::collection($images)->response()->setStatusCode(201);
    }

    public function destroy(Event $event, int $image): Response
    {
        \Gate::authorize('delete', $event);

        $imageModel = $event->images()->findOrFail($image);

        $this->imageService->delete($imageModel);

        return response()->noContent();
    }
}
