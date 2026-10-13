<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guide\StoreGuideApplicationRequest;
use App\Http\Requests\Guide\UpdateGuideApplicationRequest;
use App\Http\Resources\GuideApplicationResource;
use App\Models\GuideApplication;
use App\Services\GuideApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuideApplicationController extends Controller
{
    public function __construct(protected GuideApplicationService $service)
    {
    }

    public function index(Request $request)
    {
        return GuideApplicationResource::collection(
            $request->user()->guideApplication()->with('city')->latest()->get()
        );
    }

    public function show(GuideApplication $guideApplication): GuideApplicationResource
    {
        \Gate::authorize('view', $guideApplication);

        return new GuideApplicationResource($guideApplication->load('city'));
    }

    public function store(StoreGuideApplicationRequest $request): JsonResponse
    {
        $application = $this->service->submit(
            $request->user(),
            $request->safe()->except('verification_document'),
            $request->file('verification_document')
        );

        return (new GuideApplicationResource($application->load('city')))
            ->response()->setStatusCode(201);
    }

    public function update(UpdateGuideApplicationRequest $request, GuideApplication $guideApplication): GuideApplicationResource
    {
        \Gate::authorize('update', $guideApplication);

        $application = $this->service->resubmit(
            $guideApplication,
            $request->safe()->except('verification_document'),
            $request->file('verification_document')
        );

        return new GuideApplicationResource($application->load('city'));
    }
}
