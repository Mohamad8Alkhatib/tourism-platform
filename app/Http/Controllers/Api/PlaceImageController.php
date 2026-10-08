<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaceImagesRequest;
use App\Http\Resources\ImageResource;
use App\Models\Place;
use App\Services\PlaceImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PlaceImageController extends Controller
{
    private PlaceImageService $imageService;
    public function __construct(PlaceImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function store(StorePlaceImagesRequest $request, Place $place): JsonResponse
    {
        \Gate::authorize('update', $place);

        $images = $this->imageService->store($place, $request->file('images'));

        return ImageResource::collection($images)->response()->setStatusCode(201);
    }
    public function destroy(Place $place, int $image):Response
    {
        \Gate::authorize('update', $place);

        $imageModel = $place->images()->findOrFail($image);

        $this->imageService->delete($imageModel);

        return response()->noContent();
    }
}
