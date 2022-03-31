<?php

declare(strict_types=1);

namespace App\Game;

class Words
{
    private const FILE_PATH = __DIR__ . '/../../var/words.txt';
    private array $words = [];

    public function __construct()
    {
        $this->loadWordsFromFile();
    }

    private function loadWordsFromFile(): void
    {
        $wordsLine = file_get_contents(self::FILE_PATH);
        $this->words = explode("\n", $wordsLine);
    }

    public function getAllWords(): array
    {
        return $this->words;
    }
}
