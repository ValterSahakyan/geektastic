<?php
namespace App;

class MultiplayerGuessingGameImpl implements MultiplayerGuessingGame {
    private array $targetWords;
    private array $revealedWords;
    private VocabularyChecker $vocabularyChecker;

    public function __construct(array $words, VocabularyChecker $vocabularyChecker) {
        if (empty($words)) {
            throw new \InvalidArgumentException("Game must have at least one word");
        }

        $wordLength = strlen($words[0]);
        foreach ($words as $word) {
            if (strlen($word) !== $wordLength) {
                throw new \InvalidArgumentException("All words must be same length");
            }
        }

        $this->targetWords = $words;
        $this->vocabularyChecker = $vocabularyChecker;
        $this->initializeRevealedWords();
    }

    private function initializeRevealedWords(): void {
        foreach ($this->targetWords as $word) {
            $wordLength = strlen($word);
            $revealPos = random_int(0, $wordLength - 1);

            $revealedWord = str_repeat('*', $wordLength);
            $revealedWord[$revealPos] = $word[$revealPos];

            $this->revealedWords[] = $revealedWord;
        }
    }

    public function getGameStrings(): array {
        return $this->revealedWords;
    }

    public function submitGuess(string $playerName, string $submission) {
        $wordLength = strlen($this->targetWords[0]);
        if (strlen($submission) !== $wordLength) {
            return 0;
        }

        if (!$this->vocabularyChecker->exists($submission)) {
            return 0;
        }

        // Exact match check
        foreach ($this->targetWords as $index => $targetWord) {
            if ($submission === $targetWord && strpos($this->revealedWords[$index], '*') !== false) {
                $this->revealedWords[$index] = $targetWord;
                return 10;
            }
        }

        // Partial match handling
        $totalRevealed = 0;
        foreach ($this->targetWords as $index => $targetWord) {
            if (strpos($this->revealedWords[$index], '*') === false) {
                continue;
            }

            for ($i = 0; $i < $wordLength; $i++) {
                if ($this->revealedWords[$index][$i] === '*' && $submission[$i] === $targetWord[$i]) {
                    $this->revealedWords[$index][$i] = $targetWord[$i];
                    $totalRevealed++;
                }
            }
        }

        return $totalRevealed;
    }
}