<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Auto BON Giveaway Settings
    |--------------------------------------------------------------------------
    | amount           - BON awarded to the winner each giveaway
    | duration_minutes - How long entries are open
    | start_num        - Lowest number players can enter
    | end_num          - Highest number players can enter
    | reminders        - How many reminder messages to send during the giveaway
    */

    // User ID whose BON bank funds the giveaway prize
    'bot_user_id' => 4,

    'amount'           => 10000,
    'duration_minutes' => 180,
    'start_num'        => 1,
    'end_num'          => 100,
    'reminders'        => 2,
];
