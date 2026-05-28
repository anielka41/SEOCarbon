<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ImageController extends Controller
{
    public function show(Request $request, string $path): StreamedResponse
    {
        $server = ServerFactory::create([
            'source' => storage_path('app/public'),
            'cache' => storage_path('app/glide-cache'),
            'driver' => 'gd',
        ]);

        return $server->getImageResponse($path, $request->all());
    }
}
