<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ModifTracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen p-4 text-white">
    <div class="max-w-md w-full bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-8">
        <h2 class="text-2xl font-bold text-center text-blue-400 mb-2">Akses Masuk</h2>
        <p class="text-gray-400 text-xs text-center mb-6">Silakan login untuk mengelola dashboard ModifTracker</p>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 text-xs p-3 rounded-xl mb-4 text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Username</label>
                <input type="text" name="username" required placeholder="Masukkan username"
                       class="w-full px-4 py-2.5 rounded-xl bg-gray-900 border border-gray-700 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Password</label>
                <input type="password" name="password" required placeholder="Masukkan password"
                       class="w-full px-4 py-2.5 rounded-xl bg-gray-900 border border-gray-700 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" name="login_submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-lg shadow-blue-500/20">
                Masuk Sekarang
            </button>
        </form>
        <div class="text-center mt-4">
            <a href="index.php?page=onboarding" class="text-xs text-gray-500 hover:text-gray-400">&larr; Kembali ke Awal</a>
        </div>
    </div>
</body>
</html>