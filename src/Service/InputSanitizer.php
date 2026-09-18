<?php

namespace App\Service;

final class InputSanitizer
{
    public function escape(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public function isStrongPassword(string $password): bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * @return non-empty-string
     */
    public function sanitizeProductName(string $rawName): string
    {
        $clean = trim(strip_tags($rawName));

        if ('' === $clean) {
            throw new \InvalidArgumentException('Le nom du produit ne peut pas être vide');
        }

        return $clean;
    }
}
