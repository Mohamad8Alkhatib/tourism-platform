<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guide\ReviewGuideApplicationRequest;
use App\Http\Resources\GuideApplicationResource;
use App\Models\GuideApplication;
use App\Services\GuideApplicationService;
use Illuminate\Http\Request;

class AdminGuideApplicationController extends Controller
{
    public function __construct(protected GuideApplicationService $service)
    {
    }

    public function index(Request $request)
    {
        return GuideApplicationResource::collection(
            $this->service->listForAdmin($request->user(), $request->query('status'))
        );
    }

    public function show(Request $request, GuideApplication $guideApplication): GuideApplicationResource
    {
        $this->service->assertAdminCanAccess($request->user(), $guideApplication);

        return new GuideApplicationResource($guideApplication->load(['city', 'user']));
    }

    public function review(ReviewGuideApplicationRequest $request, GuideApplication $guideApplication):GuideApplicationResource
    {
        $this->service->assertAdminCanAccess($request->user(), $guideApplication);

        return new GuideApplicationResource(
            $this->service->review($guideApplication, $request->user(), $request->validated()));
    }
}
