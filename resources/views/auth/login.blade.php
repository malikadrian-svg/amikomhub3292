<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke AmikomHub – platform tiket event terpercaya Universitas Amikom.">
    <title>Login – AmikomHub</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Gradient animasi latar belakang */
        .bg-animated {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Efek glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        }

        /* Input focus glow */
        .input-glow:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.25);
        }

        /* Tombol hover shimmer */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.45);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        /* Lingkaran dekorasi blur */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-animated min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Dekorasi orb / cahaya latar --}}
    <div class="orb w-96 h-96 bg-indigo-500 -top-20 -left-20"></div>
    <div class="orb w-80 h-80 bg-purple-600 bottom-0 right-0"></div>
    <div class="orb w-64 h-64 bg-blue-500 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

    {{-- Card Login --}}
    <div class="glass-card rounded-3xl p-10 w-full max-w-md mx-4 relative z-10">

        {{-- Logo / Heading --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 bg-opacity-80 mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">AmikomHub</h1>
            <p class="text-slate-400 text-sm mt-1">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        {{-- Pesan Error (jika ada) --}}
        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-500 bg-opacity-20 border border-red-400 border-opacity-40 px-4 py-3">
                <ul class="text-red-300 text-sm list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
            @csrf

            {{-- Input Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                    Alamat Email
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="contoh@amikom.ac.id"
                        class="input-glow w-full pl-10 pr-4 py-3 rounded-xl
                               bg-white bg-opacity-10 text-white placeholder-slate-500
                               border border-white border-opacity-10
                               text-sm transition duration-200"
                    >
                </div>
            </div>

            {{-- Input Password --}}
            <div class="mb-7">
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                    Password
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="input-glow w-full pl-10 pr-12 py-3 rounded-xl
                               bg-white bg-opacity-10 text-white placeholder-slate-500
                               border border-white border-opacity-10
                               text-sm transition duration-200"
                    >
                    {{-- Toggle show/hide password --}}
                    <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-300 transition">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <button
                type="submit"
                id="submitBtn"
                class="btn-primary w-full py-3 px-4 rounded-xl
                       text-white font-semibold text-sm tracking-wide
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent">
                Masuk ke Akun
            </button>
        </form>

        {{-- Footer Card --}}
        <p class="text-center text-slate-500 text-xs mt-8">
            &copy; {{ date('Y') }} AmikomHub – Universitas Amikom Yogyakarta
        </p>
    </div>

    {{-- Script toggle show/hide password --}}
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const eyeIcon        = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round"
                         d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round"
                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round"
                         d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        });
    </script>

</body>
</html>
