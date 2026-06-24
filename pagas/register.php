<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Daftar Akun</h2>
            <p class="text-gray-500 text-sm mt-1">Buat akun ModifTracker baru kamu</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=register" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="reg_username" required class="mt-1 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="reg_password" required class="mt-1 w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" name="register_submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-md transition duration-200">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-600">
            Sudah punya akun? <a href="index.php?page=login" class="text-blue-500 hover:underline">Login di sini</a>
        </div>
    </div>
</div>