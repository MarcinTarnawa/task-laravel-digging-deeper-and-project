<!DOCTYPE html>
<html lang="pl" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Zaloguj się</h2>

        <form action="/login" method="post" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" 
                    value="{{ old('email') }}" 
                    class="mt-1 block w-full px-3 py-2 bg-white border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    required>
                @error('email')
                    <p class="mt-1 text-xs text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Hasło</label>
                <input type="password" name="password" id="password" 
                    class="mt-1 block w-full px-3 py-2 bg-white border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    required>
                @error('password')
                    <p class="mt-1 text-xs text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="/" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">Anuluj</a>
                <a href="/register" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">Rejestracja</a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-bold rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-md">
                    Zaloguj się
                </button>
            </div>
        </form>
    </div>

</body>
</html>