<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi FoodSaver</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Registrasi</h2>
        <form action="{{ route('registrasi') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="Nama_Pengguna" class="block text-gray-700">Nama Pengguna</label>
                <input type="text" name="Nama_Pengguna" id="Nama_Pengguna" class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="Masukkan nama">
            </div>
            <div class="mb-4">
                <label for="Email_Pengguna" class="block text-gray-700">Email Pengguna</label>
                <input type="email" name="Email_Pengguna" id="Email_Pengguna" class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="Masukkan email">
            </div>
            <div class="mb-4">
                <label for="Password_Pengguna" class="block text-gray-700">Password</label>
                <input type="password" name="Password_Pengguna" id="Password_Pengguna" class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="Masukkan password">
            </div>
            <div class="mb-4">
                <label for="Alamat_Pengguna" class="block text-gray-700">Alamat</label>
                <textarea name="Alamat_Pengguna" id="Alamat_Pengguna" rows="3" class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="Masukkan alamat"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</body>
</html>