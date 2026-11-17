<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Acceso Administrativo</h2>
            <p class="text-sm text-slate-500 mt-2">Ingrese sus credenciales para continuar</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p><i class="bi bi-exclamation-circle-fill mr-2"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('exito'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
                <p><i class="bi bi-check-circle-fill mr-2"></i>{{ session('exito') }}</p>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Usuario o Correo</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <input type="text" name="usuario" value="{{ old('usuario') }}" required 
                           class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="Ej. cmendoza">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <input type="password" name="contraseña" required 
                           class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ url('/catalogo') }}" class="text-sm text-blue-600 hover:text-blue-700">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
        </div>
    </div>
</body>
</html>
