<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\ReviewThank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $reviews = Review::with([
            'user.group',
            'tmdbMovie',
            'tmdbTv',
            'igdbGame',
            'thanks',
        ])
            ->latest()
            ->paginate(25);

        return view('review.index', compact('reviews'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tmdb_movie_id' => 'nullable|integer',
            'tmdb_tv_id'    => 'nullable|integer',
            'igdb_id'       => 'nullable|integer',
            'category_id'   => 'required|integer|exists:categories,id',
            'meta_id'       => 'required|integer',
            'title'         => 'required|string|max:255',
            'body'          => 'nullable|string|max:5000',
            'rating'        => 'required|integer|min:1|max:10',
            'is_anonymous'  => 'nullable|boolean',
            'is_spoiler'    => 'nullable|boolean',
        ]);

        $userId = auth()->id();

        // Check for duplicate review
        $existing = Review::where('user_id', $userId)
            ->when($validated['tmdb_movie_id'] ?? null, fn ($q) => $q->where('tmdb_movie_id', $validated['tmdb_movie_id']))
            ->when($validated['tmdb_tv_id'] ?? null, fn ($q) => $q->where('tmdb_tv_id', $validated['tmdb_tv_id']))
            ->when($validated['igdb_id'] ?? null, fn ($q) => $q->where('igdb_id', $validated['igdb_id']))
            ->exists();

        if ($existing) {
            return back()->withErrors(['rating' => 'Anda sudah menghantar ulasan untuk tajuk ini.']);
        }

        Review::create([
            'user_id'       => $userId,
            'tmdb_movie_id' => $validated['tmdb_movie_id'] ?? null,
            'tmdb_tv_id'    => $validated['tmdb_tv_id'] ?? null,
            'igdb_id'       => $validated['igdb_id'] ?? null,
            'title'         => $validated['title'],
            'body'          => $validated['body'] ?? null,
            'rating'        => $validated['rating'],
            'is_anonymous'  => (bool) ($validated['is_anonymous'] ?? false),
            'is_spoiler'    => (bool) ($validated['is_spoiler'] ?? false),
        ]);

        return back()->with('success', 'Ulasan berjaya dihantar!');
    }

    public function destroy(Review $review): RedirectResponse
    {
        abort_unless(
            auth()->id() === $review->user_id || auth()->user()->group->is_modo,
            403
        );

        $review->delete();

        return back()->with('success', 'Ulasan telah dipadam.');
    }

    public function thank(Review $review): RedirectResponse
    {
        $userId = auth()->id();

        if ($review->user_id === $userId) {
            return back()->withErrors(['thank' => 'Anda tidak boleh berterima kasih pada ulasan sendiri.']);
        }

        $existing = ReviewThank::where('user_id', $userId)->where('review_id', $review->id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            ReviewThank::create(['user_id' => $userId, 'review_id' => $review->id]);
        }

        return back();
    }
}
