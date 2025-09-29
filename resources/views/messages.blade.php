<html>
    <head>
        <title>Messages</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 text-gray-800">
        <div class="max-w-2xl mx-auto p-6">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-600 transition">
                    ← Back
                </a>
            </div>

            <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Messages</h1>

            <ul class="space-y-4">
                @foreach ($messages as $message)
                    <li class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <strong class="text-lg text-gray-900">{{ $message->name }}</strong>
                            <span class="text-sm text-gray-500">{{ $message->email }}</span>
                        </div>
                        <p class="mt-2 text-gray-700">{{ $message->message }}</p>
                        <em class="block mt-3 text-xs text-gray-400">
                            Sent on: {{ $message->created_at->format('Y-m-d H:i') }}
                        </em>
                    </li>
                @endforeach
            </ul>
        </div>
    </body>
</html>
