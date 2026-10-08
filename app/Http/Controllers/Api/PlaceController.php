<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    private PlaceService $placeService;

    public function __construct(PlaceService $placeService)
    {
        $this->placeService = $placeService;
    }

    public function index(): AnonymousResourceCollection
    {
        return PlaceResource::collection($this->placeService->list());
    }

    public function show(Place $place): PlaceResource
    {
        return new PlaceResource($this->placeService->find($place));
    }

    public function store(StorePlaceRequest $request): JsonResponse
    {
        \Gate::authorize('create_places');

        $place = $this->placeService->create($request->validated());

        return (new PlaceResource($place))->response()->setStatusCode(201);
    }

    public function update(UpdatePlaceRequest $request, Place $place): PlaceResource
    {
        \Gate::authorize('update', $place);

        return new PlaceResource($this->placeService->update($place, $request->validated()));
    }

    public function destroy(Place $place): Response
    {
        \Gate::authorize('delete', $place);

        $this->placeService->delete($place);

        return \response()->noContent();
    }
}
