<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - WifiNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563eb' }
                }
            }
        }
    </script>
    <style>
        .login-bg {
            background-image: linear-gradient(to right bottom, rgba(30, 64, 175, 0.9), rgba(15, 23, 42, 0.95)), url('https://images.unsplash.com/photo-1558494949-efc5270f9c40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01]">
        
        <!-- Header -->
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 text-center">
            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-white text-xl mx-auto mb-3 shadow-lg shadow-blue-500/30">
                <i class="fas fa-wifi"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Login Petugas</h2>
            <p class="text-sm text-gray-500 mt-1">Masuk untuk mengelola layanan WifiNet</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm" role="alert">
                    <p class="font-bold">Gagal Masuk</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                               id="email" type="email" name="email" placeholder="nama@wifinet.id" required autofocus>
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                               id="password" type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ingat Saya</label>
                    </div>
                    <a class="text-sm text-primary hover:text-blue-700 font-medium" href="{{ url('/') }}">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Home
                    </a>
                </div>

                <button class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-600/30 transition-all transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" type="submit">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} WifiNet Management System. <br>Hanya untuk personel berwenang.
            </p>
        </div>
    </div>

</body>
</html>