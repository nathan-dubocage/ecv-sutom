<?php

declare(strict_types=1);

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
            require_once __DIR__.'/../../App/View/form.php';

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
        $currentTry = (int)$_COOKIE['try'];
        ++$currentTry;
        // le code n'était pas bon :
        // setcookie(string $name, string $value = "", array $options = []): bool
        // on devrait envoyer une string et pas un entier.
        // comme tu n'a pas utilisé de strict_types tu ne t'es pas rendu compte que tu n'étais pas précis.
        setcookie('try', (string)$currentTry);
        $this->showResult($cookieWord, $word, $currentTry);
    }

    // cette méthode n'a pas trop sa place ici, c'est plutôt des choses à retrouver dans un template.
    private function showResult(string $cookieWord, string $word, int $currentTry): void
    {
        if (6 === $currentTry) {
            echo "C'est perdu ! Le mot était ".$cookieWord.'. Vous avez utilisé '.$currentTry.' essais.';

            return;
        }

        if ($cookieWord === strtoupper($word)) {
            echo "C'est gagné ! Le mot était ".$cookieWord.'. Vous avez utilisé '.$currentTry.' essais.';

            return;
        }

        $upperWord = strtoupper($word);
        $explodeWord = str_split($upperWord);
        $explodeCookieWord = str_split($cookieWord);

        echo 'Vous avez saisi le mot : '.$upperWord.' <br />';
        echo 'Liste des lettres contenues dans le mot à deviner : ';
        $letters = [];

        foreach ($explodeWord as $value) {
            if (\in_array($value, $explodeCookieWord, true)) {
                if (!\in_array($value, $letters, true)) {
                    $letters[] = $value;
                }
            }
        }

        echo implode(' | ', $letters);
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
        // ce code n'est pas bon :
        // setcookie(string $name, string $value = "", array $options = []): bool
        // on devrait envoyer une string et pas un entier.
        // comme tu n'a pas utilisé de strict_types tu ne t'es pas rendu compte que tu n'étais pas précis.
        setcookie('try', '0');
        $this->word = $selectedWord;
    }

    public function getWord(): string
    {
        return $this->word;
    }
}
