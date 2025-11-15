<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Helpers\TaskHelper;
use App\Models\Donation;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProfileController
 *
 * Контроллер для управления профилем пользователя.
 * Обрабатывает отображение, обновление и удаление профиля.
 */
class ProfileController extends Controller
{
    /**
     * Display the user's public profile.
     */
    public function view(Request $request)
    {
        $user = $request->user();
        
        // Get task statistics
        $taskStats = TaskHelper::getUserTaskStats($user);
        
        // Get donation statistics
        $donationStats = [
            'count' => Donation::getTotalDonationCount($user->id),
            'amount' => Donation::getTotalDonationAmount($user->id),
            'currencies' => Donation::where('user_id', $user->id)
                ->where('status', 'completed')
                ->distinct('currency')
                ->count('currency'),
        ];
        
        // Get tasks by completion status for chart
        $completionStats = [
            'completed' => $user->tasks()->where('completed', true)->count(),
            'pending' => $user->tasks()->where('completed', false)->count(),
        ];
        
        // Get tasks created in the last 7 days for activity chart
        $tasksByDay = $user->tasks()
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Get reminder statistics
        $reminderStats = [
            'enabled' => $user->reminder_enabled,
            'one_day' => $user->reminder_1_day,
            'three_days' => $user->reminder_3_days,
            'one_week' => $user->reminder_1_week,
            'overdue' => $user->reminder_overdue,
            'time' => $user->reminder_time ? $user->reminder_time->format('H:i') : '09:00',
        ];
        
        return view('profile.view', [
            'user' => $user,
            'taskStats' => $taskStats,
            'donationStats' => $donationStats,
            'completionStats' => $completionStats,
            'tasksByDay' => $tasksByDay,
            'reminderStats' => $reminderStats
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar_path && Storage::disk('public')->exists('avatars/' . $user->avatar_path)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar_path);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = basename($avatarPath);
        }
        
        // Fill user data
        $user->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}