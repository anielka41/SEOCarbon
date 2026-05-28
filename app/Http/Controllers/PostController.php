<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Blog\Models\Post;
use App\Services\Seo\JsonLdGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PostController extends Controller
{
    public function __construct(private readonly Factory $factory) {}

    public function show(Post $post, JsonLdGenerator $jsonLd): View
    {
        $schema = $jsonLd->generateForPost($post);

        return $this->factory->make('posts.show', [
            'post' => $post,
            'schema' => $schema,
        ]);
    }
}
