<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid License - SEOCarbon Dirs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
        <div class="text-red-500 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Invalid License</h1>
        <p class="text-gray-600 mb-6">
            A valid license key is required to access <strong>SEOCarbon Dirs</strong>. 
            Please make sure `license.key` is present in the root directory and is valid for this domain.
        </p>
        <div class="bg-gray-50 p-4 rounded border border-gray-200 text-sm text-gray-500">
            Domain: <span class="font-mono text-gray-700">{{ request()->getHost() }}</span>
        </div>
    </div>
</body>
</html>
