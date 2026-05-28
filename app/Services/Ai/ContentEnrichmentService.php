<?php

declare(strict_types=1);

namespace App\Services\Ai;

use App\Services\Ai\Contracts\AiProvider;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final readonly class ContentEnrichmentService
{
    public function __construct(private AiProvider $aiProvider) {}

    /**
     * @return array<string, mixed>
     */
    public function enrichFromUrl(string $url): array
    {
        $content = $this->scrapeUrl($url);

        if (! $content) {
            return [];
        }

        $systemPrompt = 'You are a helpful assistant for a company directory. Extract data from the provided website content and return it in JSON format. Fields: name, description, tags (array of strings), contact_email, contact_phone, address, category_suggestion.';

        $prompt = "Website content:\n\n".substr($content, 0, 7000);

        try {
            $response = $this->aiProvider->complete($prompt, $systemPrompt);

            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $exception) {
            Log::error('AI Enrichment Error: '.$exception->getMessage());

            return [];
        }
    }

    private function scrapeUrl(string $url): ?string
    {
        try {
            $response = Http::timeout(15)->get($url);

            if ($response->successful()) {
                // Strip HTML tags and normalize whitespace
                $text = strip_tags($response->body());

                return preg_replace('/\s+/', ' ', $text);
            }
        } catch (Exception $exception) {
            Log::error('Scraping Error: '.$exception->getMessage(), ['url' => $url]);
        }

        return null;
    }
}
