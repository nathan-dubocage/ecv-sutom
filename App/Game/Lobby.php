<?php

namespace App\Game;

class Lobby
{
    private string $word;

    public function __construct()
    {
        $this->checkGame();
    }

    private function checkGame(): void
    {
        if (isset($_COOKIE['word']) && isset($_COOKIE['try']) && $_COOKIE['try'] < 7) {
            require_once(__DIR__ . '/../../App/View/form.php');

            if (isset($_POST['word'])) {
                $word = htmlspecialchars($_POST['word']);
                $this->checkWord($word);
            }
        } else {
            $this->initializeLobby();
            header('Refresh:1');
        }
    }

    private function checkWord(string $word): void
    {
        $cookieWord = $_COOKIE['word'];
        $currentTry = $_COOKIE['try'];
        $currentTry++;
        setcookie('try', $currentTry);
        $this->showResult($cookieWord, $word, $currentTry);
    }

    private function showResult(string $cookieWord, string $word, int $currentTry): void
    {
        if ($currentTry === 6) {
            echo "C'est perdu ! Le mot était " . $cookieWord . ". Vous avez utilisé " . $currentTry . " essais.";
            return;
        }

        if ($cookieWord == strtoupper($word)) {
            echo "C'est gagné ! Le mot était " . $cookieWord . ". Vous avez utilisé " . $currentTry . " essais.";
            return;
        }

        $upperWord = strtoupper($word);
        $explodeWord = str_split($upperWord);
        $explodeCookieWord = str_split($cookieWord);

        echo "Vous avez saisi le mot : " . $upperWord . " <br />";
        echo "Liste des lettres contenues dans le mot à deviner : ";
        $letters = [];

        foreach ($explodeWord as $key => $value) {
            if (in_array($value, $explodeCookieWord)) {
                if (!in_array($value, $letters)) {
                    array_push($letters, $value);
                }
            }
        }

        foreach ($letters as $letter) {
            echo $letter . " | ";
        }
    }

    private function initializeLobby(): void
    {
        /* --- Récupération de la liste de mots --- */
        $words = new Words();
        $getAllWords = $words->getAllWords();

        /* --- Sélection d'un mot au hasard --- */
        $selectWord = new SelectWord();
        $selectedWord = $selectWord->selectWord($getAllWords);

        /* --- On place le mot dans un cookie --- */
        setcookie('word', $selectedWord);
        setcookie('try', 0);
        $this->word = $selectedWord;
    }

    public function getWord(): string
    {
        return $this->word;
    }
}
