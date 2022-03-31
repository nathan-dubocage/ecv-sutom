<?php

declare(strict_types=1);

namespace App\Game;

class SelectWord
{
    public function selectWord(array $words): string
    {
        return $words[rand(0, count($words) - 1)];
    }
}
