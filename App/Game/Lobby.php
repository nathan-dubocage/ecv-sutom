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
        if (isset($_COOKIE['word']) && isset($_COOKIE['try'])) {
            /* --- À changer par quelque chose de plus flexible --- */
            echo "<h1>Partie en cours</h1>";
            require_once(__DIR__ . '/../../App/View/form.php');

            if (isset($_POST['word'])) {
                $word = htmlspecialchars($_POST['word']);
                echo $word;
            }
        } else {
            $this->initializeLobby();
            header('Refresh:1');
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
