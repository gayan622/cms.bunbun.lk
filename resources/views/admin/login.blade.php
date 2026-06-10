<!DOCTYPE html>
<html>
<head>
    <title>BunBun CMS Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#FAF6EE] flex items-center justify-center">

<div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">
    <h1 class="text-4xl font-black text-[#E50914] text-center mb-2">
        bunbun.lk
    </h1>

    <p class="text-center text-gray-500 mb-8">
        CMS Admin Login
    </p>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-xl">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-4">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full border rounded-xl p-4"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            class="w-full border rounded-xl p-4"
            required
        >

        <button class="w-full bg-[#E50914] text-white font-bold p-4 rounded-xl">
            Login
        </button>
    </form>
</div>

</body>
</html>