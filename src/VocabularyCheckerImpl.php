<?php
namespace App;

class VocabularyCheckerImpl implements VocabularyChecker {
    private array $validWords = [];

    public function __construct() {
        try {
            $handle = fopen(__DIR__ . '/../wordlist.txt', 'r');
            if ($handle !== false) {
                while (($line = fgets($handle)) !== false) {
                    $this->validWords[] = trim($line);
                }
                fclose($handle);
            } else {
                throw new \Exception("Failed to open wordlist.txt");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function exists(string $word): bool {
        return in_array($word, $this->validWords);
    }
}