<?php

namespace App\Services;

use App\Models\AccountType;
use App\Models\Guide;
use App\Models\GuideApplication;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GuideApplicationService
{
    public function submit(User $user, array $data, UploadedFile $document): GuideApplication
    {
        if (Guide::where('user_id', $user->id)->exists()) {
            throw ValidationException::withMessages(['user' => 'You are already a guide']);
        }

        $hasOpen = GuideApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review', 'changes_requested'])
            ->exists();

        if ($hasOpen)
            throw ValidationException::withMessages(['user' => 'You already have an open application']);

        $data['verification_document'] = $document->store('guide_documents');
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        return GuideApplication::create($data);
    }

    public function resubmit(GuideApplication $application, array $data, ?UploadedFile $document = null): GuideApplication
    {
        if ($application->status !== 'changes_requested')
            throw ValidationException::withMessages(['status' => 'The application cannot be edited now']);

        if ($document) {
            Storage::delete($application->verification_document);
            $data['verification_document'] = $document->store('guide_documents');
        }

        $application->update($data + ['status' => 'pending']);

        return $application->refresh();
    }

    public function review(GuideApplication $application, User $reviewer, array $data): GuideApplication
    {
        if (in_array($application->status, ['approved', 'rejected']))
            throw ValidationException::withMessages(['status' => 'The application is already finalized']);

        return \DB::transaction(function () use ($application, $reviewer, $data) {
            $application->update([
                'status' => $data['status'],
                'review_note' => $data['review_note'],
                'reviewed_by' => $reviewer->id,
                'reviewed_at' => now()
            ]);

            if ($data['status'] === 'approved')
                $this->approve($application);

            return $application->refresh();
        });
    }

    private function approve(GuideApplication $application): void
    {
        Guide::create([
            'user_id' => $application->user_id,
            'city_id' => $application->city_id,
            'bio_en' => $application->bio_en,
            'bio_ar' => $application->bio_ar,
            'years_experience' => $application->years_experience,
            'languages' => $application->languages,
            'verification_status' => 'approved',
            'verified_at' => now(),
        ]);

        $application->user->update([
            'account_type_id' => AccountType::where('type', 'guide')->value('id')
        ]);
    }

    public function listForAdmin(User $admin, ?string $status = null, int $perPage = 10)
    {
        $query = GuideApplication::with(['city', 'user'])->latest();

        if (!$this->isSuperAdmin($admin))
            $query->whereIn('city_id', $admin->adminCities()->pluck('id'));

        if ($status)
            $query->where('status', $status);

        return $query->paginate($perPage);
    }

    public function assertAdminCanAccess(User $admin, GuideApplication $application): void
    {
        if ($this->isSuperAdmin($admin))
            return;

        abort_unless(
            $admin->adminCities()->whereKey($application->city_id)->exists(),
            403
        );
    }

    private function isSuperAdmin(User $user): bool
    {
        return $user->accountType?->type === 'super_admin';
    }
}

