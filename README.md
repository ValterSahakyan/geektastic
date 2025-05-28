# Multiplayer Word Guessing Game

This project is a backend implementation of a multiplayer word guessing game. Players can guess words to reveal hidden characters and score points based on the rules defined in the game.

## Features

- Players guess partially revealed words to reveal hidden characters.
- Scoring system for partial and exact matches.
- Words are initialized with one character revealed in a random position.
- Supports multiple players submitting guesses concurrently.
- Includes a vocabulary checker to validate English words.

## Prerequisites

- PHP >= 8.1
- Composer (Dependency Manager for PHP)
- PHPUnit (for testing)

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ValterSahakyan/geektastic.git
   cd geektastic
   composer install
   composer test
   
