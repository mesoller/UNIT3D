<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FfmEntry;

class FfmController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $entries = FfmEntry::with([
            'movie.genres',
            'movie.directors',
            'movie.torrents',
        ])
            ->orderBy('position')
            ->get();

        return view('ffm.index', compact('entries'));
    }
}
