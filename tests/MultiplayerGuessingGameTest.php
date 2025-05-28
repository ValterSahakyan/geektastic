<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\VocabularyChecker;
use App\MultiplayerGuessingGameImpl;

class MultiplayerGuessingGameTest extends TestCase {
    private function createMockVocabularyChecker(array $validWords): VocabularyChecker {
        return new class($validWords) implements VocabularyChecker {
            private array $validWords;

            public function __construct(array $validWords) {
                $this->validWords = $validWords;
            }

            public function exists(string $word): bool {
                return in_array($word, $this->validWords);
            }
        };
    }

    public function testGameInitialization() {
        // Fixed words of equal length
        $words = ['apple', 'grape', 'peach'];
        $vocabularyChecker = $this->createMockVocabularyChecker($words);
        $game = new MultiplayerGuessingGameImpl($words, $vocabularyChecker);

        $gameStrings = $game->getGameStrings();
        $this->assertCount(3, $gameStrings);

        foreach ($gameStrings as $revealedWord) {
            $this->assertEquals(5, strlen($revealedWord)); // All words are of length 5
            $this->assertEquals(1, strlen($revealedWord) - substr_count($revealedWord, '*'));
        }
    }

    public function testExactMatch() {
        $words = ['apple'];
        $vocabularyChecker = $this->createMockVocabularyChecker($words);
        $game = new MultiplayerGuessingGameImpl($words, $vocabularyChecker);

        $score = $game->submitGuess('player1', 'apple');
        $this->assertEquals(10, $score);
        $this->assertEquals(['apple'], $game->getGameStrings());
    }
}
