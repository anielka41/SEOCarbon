<?php

declare(strict_types=1);

namespace App\Services\Ai\Providers;

use App\Services\Ai\Contracts\AiProvider;

final class MockAiProvider implements AiProvider
{
    public function complete(string $prompt, string $systemPrompt = ''): string
    {
        return json_encode([
            'name' => 'Suggested Name from AI',
            'description' => 'This is an AI generated description for the website.',
            'category_suggestion' => 'Technology',
            'tags' => ['ai', 'tech', 'software'],
        ], JSON_THROW_ON_ERROR);
    }
}
