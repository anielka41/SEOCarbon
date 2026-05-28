<?php

declare(strict_types=1);

namespace App\Services\Ai\Contracts;

interface AiProvider
{
    public function complete(string $prompt, string $systemPrompt = ''): string;
}
