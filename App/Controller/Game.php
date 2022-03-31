<?php

declare(strict_types=1);

namespace App\Controller;

use App\Game\Lobby;

class Game implements Controller
{
    public function render()
    {
        new Lobby();
    }
}
