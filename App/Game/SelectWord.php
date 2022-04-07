<?php

declare(strict_types=1);

namespace App\Game;

class SelectWord
{
    public function selectWord(array $words): string
    {
        return $words[random_int(0, \count($words) - 1)];
    }
}
