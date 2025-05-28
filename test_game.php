<?php

use App\MultiplayerGuessingGameImpl;

require_once 'VocabularyCheckerImpl.php';
require_once 'MultiplayerGuessingGameImpl.php';

// Initialize game with some words
$words = ['apple', 'banana', 'cherry', 'dragon', 'elephant'];
$vocabularyChecker = new VocabularyCheckerImpl();
$game = new MultiplayerGuessingGameImpl($words, $vocabularyChecker);

echo "Welcome to the Word Guessing Game!\n";
echo "Initial game state:\n";
print_r($game->getGameStrings());

while (true) {
    echo "\nEnter your guess (or 'quit' to exit): ";
    $guess = trim(fgets(STDIN));

    if ($guess === 'quit') {
        break;
    }

    $score = $game->submitGuess('player1', $guess);
    echo "Score for this guess: $score\n";
    echo "Current game state:\n";
    print_r($game->getGameStrings());
}