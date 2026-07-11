<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FilmClubMonth;
use App\Models\FilmClubSuggestion;
use App\Models\FilmClubVote;
use App\Models\TmdbMovie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FilmClubController extends Controller
{
    private const MAX_SUGGESTIONS = 10;

    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $user = $request->user();
        $nextMonth = now()->addMonth()->format('Y-m');

        $filmOfMonth = FilmClubMonth::current();

        $pastWinners = FilmClubMonth::with('movie')
            ->where('year_month', '<', now()->format('Y-m'))
            ->orderByDesc('year_month')
            ->take(6)
            ->get();

        $suggestions = FilmClubSuggestion::with(['movie', 'user'])
            ->where('for_month', $nextMonth)
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->get();

        $userVotedSuggestionId = FilmClubVote::where('user_id', $user->id)
            ->where('for_month', $nextMonth)
            ->value('suggestion_id');

        $userHasSuggested = FilmClubSuggestion::where('user_id', $user->id)
            ->where('for_month', $nextMonth)
            ->exists();

        return view('film-club.index', [
            'filmOfMonth'           => $filmOfMonth,
            'pastWinners'           => $pastWinners,
            'suggestions'           => $suggestions,
            'userVotedSuggestionId' => $userVotedSuggestionId,
            'userHasSuggested'      => $userHasSuggested,
            'totalSuggestions'      => $suggestions->count(),
            'maxSuggestions'        => self::MAX_SUGGESTIONS,
            'nextMonth'             => $nextMonth,
        ]);
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim((string) $request->input('q', ''));

        if (\strlen($q) < 2) {
            return response()->json([]);
        }

        $results = TmdbMovie::query()
            ->where('title', 'like', '%'.$q.'%')
            ->orderByDesc('popularity')
            ->take(8)
            ->get(['id', 'title', 'release_date', 'poster']);

        return response()->json($results->map(fn ($m) => [
            'id'         => $m->id,
            'title'      => $m->title,
            'year'       => $m->release_date?->format('Y'),
            'poster_url' => $m->poster ? tmdb_image('poster_small', $m->poster) : null,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tmdb_movie_id' => ['required', 'integer', 'exists:tmdb_movies,id'],
        ]);

        $user = $request->user();
        $nextMonth = now()->addMonth()->format('Y-m');

        if (FilmClubSuggestion::where('user_id', $user->id)->where('for_month', $nextMonth)->exists()) {
            return back()->with('error', 'Anda sudah mencadangkan filem untuk bulan hadapan.');
        }

        if (FilmClubSuggestion::where('for_month', $nextMonth)->count() >= self::MAX_SUGGESTIONS) {
            return back()->with('error', 'Slot cadangan untuk bulan hadapan telah penuh (10 filem).');
        }

        if (FilmClubMonth::where('tmdb_movie_id', $request->tmdb_movie_id)->exists()) {
            return back()->with('error', 'Filem ini pernah menjadi Filem Kelab sebelum ini.');
        }

        $sixMonthsAgo = now()->subMonths(6)->format('Y-m');

        if (FilmClubSuggestion::where('tmdb_movie_id', $request->tmdb_movie_id)
            ->where('for_month', '>=', $sixMonthsAgo)
            ->exists()
        ) {
            return back()->with('error', 'Filem ini telah dicadangkan dalam tempoh 6 bulan lepas.');
        }

        if (FilmClubSuggestion::where('tmdb_movie_id', $request->tmdb_movie_id)
            ->where('for_month', $nextMonth)
            ->exists()
        ) {
            return back()->with('error', 'Filem ini sudah dicadangkan oleh ahli lain untuk bulan hadapan.');
        }

        FilmClubSuggestion::create([
            'user_id'       => $user->id,
            'tmdb_movie_id' => $request->tmdb_movie_id,
            'for_month'     => $nextMonth,
        ]);

        return back()->with('success', 'Cadangan anda telah berjaya dihantar!');
    }

    public function vote(Request $request, FilmClubSuggestion $suggestion): RedirectResponse
    {
        $user = $request->user();
        $nextMonth = now()->addMonth()->format('Y-m');

        if ($suggestion->for_month !== $nextMonth) {
            return back()->with('error', 'Tempoh pengundian untuk cadangan ini telah tamat.');
        }

        if (FilmClubVote::where('user_id', $user->id)->where('for_month', $nextMonth)->exists()) {
            return back()->with('error', 'Anda sudah mengundi untuk bulan ini.');
        }

        FilmClubVote::create([
            'user_id'       => $user->id,
            'suggestion_id' => $suggestion->id,
            'for_month'     => $nextMonth,
        ]);

        return back()->with('success', 'Undi anda telah direkodkan!');
    }

    public function setWinner(Request $request): RedirectResponse
    {
        abort_unless(
            $request->user()->group->is_admin || $request->user()->group->is_modo,
            403
        );

        $request->validate([
            'suggestion_id' => ['required', 'exists:film_club_suggestions,id'],
            'year_month'    => ['required', 'string', 'size:7'],
        ]);

        $suggestion = FilmClubSuggestion::findOrFail($request->suggestion_id);
        $voteCount = FilmClubVote::where('suggestion_id', $suggestion->id)->count();

        FilmClubMonth::updateOrCreate(
            ['year_month' => $request->year_month],
            [
                'tmdb_movie_id'   => $suggestion->tmdb_movie_id,
                'winning_user_id' => $suggestion->user_id,
                'total_votes'     => $voteCount,
            ]
        );

        return back()->with('success', 'Filem Kelab bulan ini telah ditetapkan!');
    }
}
