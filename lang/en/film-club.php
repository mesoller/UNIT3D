<?php

declare(strict_types=1);

return [
    // Page title
    'page-title'               => 'MalayaBits Film Club',

    // Film of the Month
    'film-of-month'            => 'Film Club — :month',
    'watch-now'                => 'Watch Now!',
    'discuss'                  => 'Discussion',
    'discuss-body'             => 'Join the discussion for this film on our :link.',
    'discuss-forum-link'       => 'forum',
    'credit'                   => 'This film was suggested by :user and won with :votes vote(s).',
    'anonymous-member'         => 'Anonymous Member',
    'no-film-this-month'       => 'No film has been selected for this month yet. Stay tuned for an announcement from the admin!',

    // Voting section
    'suggestions-heading'      => 'Suggestions for Next Month',
    'slots'                    => ':total/:max slots',
    'no-suggestions'           => 'No suggestions yet. Be the first to suggest!',
    'by'                       => 'By:',
    'vote'                     => 'Vote',
    'vote-singular'            => 'vote',
    'vote-plural'              => 'votes',
    'your-vote'                => 'Your Vote',
    'already-voted'            => 'Already Voted',

    // Staff winner modal
    'set-winner-title'         => 'Set Film Club Winner',
    'set-winner-desc'          => 'This film will be set as the Film Club pick for the selected month.',
    'set-winner-month-label'   => 'Month',
    'set-winner-confirm'       => 'Confirm Winner',
    'cancel'                   => 'Cancel',

    // Suggest panel
    'already-suggested'        => 'You have already suggested a film for next month.',
    'suggestions-full'         => 'The suggestion slots for next month are full.',
    'suggest-btn'              => 'Suggest a Film for Next Month',
    'suggest-title'            => 'Search & Suggest a Film',
    'search-label'             => 'Search film title',
    'search-placeholder'       => 'e.g. Saving Private Ryan',
    'submit-suggestion'        => 'Submit Suggestion',

    // Rules sidebar
    'rules-heading'            => 'MalayaBits Film Club',
    'rules-intro'              => 'Each month, members have the opportunity to suggest and vote for their favourite film for the Film Club. The winning film will be featured as the following month\'s Film Club pick.',
    'suggestion-rules-heading' => 'Suggestion Rules',
    'suggestion-rules'         => [
        'A film cannot have been a Film Club pick before',
        'A film cannot have been suggested in the past 6 months',
        'One suggestion per member per month',
        'Maximum 10 film suggestions per month',
    ],
    'voting-rules-heading'     => 'Voting Rules',
    'voting-rules'             => [
        'One vote per member per month',
        'Voting is open throughout the current month',
        'The admin will confirm the winner at the end of the month',
    ],

    // Past winners
    'past-winners'             => 'Past Winners',
    'past-votes'               => ':votes vote(s)',
];
