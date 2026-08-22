<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FfmEntry;
use Illuminate\Database\Seeder;

class FfmSeeder extends Seeder
{
    public function run(): void
    {
        // Source: https://www.themoviedb.org/list/8679422-festival-filem-malaysia
        $entries = [
            ['tmdb_movie_id' => 248510, 'position' => 1, 'award_year' => 1984],
            ['tmdb_movie_id' => 1557879, 'position' => 2, 'award_year' => 1983],
            ['tmdb_movie_id' => 168724,  'position' => 3, 'award_year' => 1981],
            ['tmdb_movie_id' => 244050,  'position' => 4, 'award_year' => 1980],
            ['tmdb_movie_id' => 279801,  'position' => 5, 'award_year' => 1979],
        ];

        foreach ($entries as $entry) {
            FfmEntry::updateOrCreate(
                ['tmdb_movie_id' => $entry['tmdb_movie_id']],
                $entry
            );
        }
    }
}
