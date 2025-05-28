<?php
namespace App;

interface VocabularyChecker {
    function exists(string $word): bool;
}