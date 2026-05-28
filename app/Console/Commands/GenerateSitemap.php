<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Blog\Models\Post;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Enums\EntryStatus;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Routing\UrlGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Description('Generate the sitemap for the directory')]
#[Signature('seo:generate-sitemap')]
final class GenerateSitemap extends Command
{
    /**
     * Create a new console command instance.
     */
    public function __construct(private readonly UrlGenerator $urlGenerator)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Home
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // DirectoryEntries
        DirectoryEntry::query()->where('status', EntryStatus::Published)->each(function (DirectoryEntry $directoryEntry) use ($sitemap): void {
            $sitemap->add(Url::create($this->urlGenerator->route('listings.show', $directoryEntry))
                ->setLastModificationDate($directoryEntry->updated_at ?? now())
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

        // Categories
        DirectoryCategory::query()->where('is_active', true)->each(function (DirectoryCategory $directoryCategory) use ($sitemap): void {
            $sitemap->add(Url::create($this->urlGenerator->route('categories.show', $directoryCategory))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        });

        // Posts
        Post::query()->where('status', EntryStatus::Published)->each(function (Post $post) use ($sitemap): void {
            $sitemap->add(Url::create($this->urlGenerator->route('posts.show', $post))
                ->setLastModificationDate($post->updated_at ?? now())
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
