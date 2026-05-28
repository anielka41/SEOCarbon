<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Domain\Blog\Models\Post;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use Illuminate\Routing\UrlGenerator;

final readonly class JsonLdGenerator
{
    public function __construct(private UrlGenerator $urlGenerator) {}

    /**
     * @return array<string, mixed>
     */
    public function generateForDirectoryEntry(DirectoryEntry $directoryEntry): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $directoryEntry->name,
            'description' => $directoryEntry->meta_description ?? $directoryEntry->description,
            'url' => $directoryEntry->url,
            'image' => $directoryEntry->logo_path ? $this->urlGenerator->asset('storage/'.$directoryEntry->logo_path) : null,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $directoryEntry->address,
            ],
            'email' => $directoryEntry->contact_email,
            'telephone' => $directoryEntry->contact_phone,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function generateForDirectoryCategory(DirectoryCategory $directoryCategory): array
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $directoryCategory->name,
            'description' => $directoryCategory->description,
            'url' => $this->urlGenerator->route('categories.show', $directoryCategory),
        ];

        if ($directoryCategory->faq && is_array($directoryCategory->faq)) {
            $data['mainEntity'] = array_map(fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'] ?? '',
                ],
            ], $directoryCategory->faq);

            $data['@type'] = ['CollectionPage', 'FAQPage'];
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function generateForPost(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->meta_description ?? $post->excerpt,
            'image' => $post->featured_image ? $this->urlGenerator->asset('storage/'.$post->featured_image) : null,
            'datePublished' => $post->published_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->user?->name,
            ],
        ];
    }
}
