<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Projek SIT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: url("{{ asset('img/koke.jpg') }}") no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0;
        }
        .card { 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 20px; 
            backdrop-filter: blur(15px) saturate(150%); 
            background: rgba(0, 0, 0, 0.5); 
            box-shadow: 0 15px 35px rgba(0,0,0,0.6); 
            width: 100%;
            max-width: 400px;
            color: white;
        }
        .card h3, .card p, .card label { color: white !important; }
        .form-control { 
            background: rgba(255, 255, 255, 0.1) !important; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            color: white !important; 
        }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.5); }
        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #00ffff;
        }
        .register-logo {
            max-width: 100px;
            filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.6));
            margin-bottom: 10px;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #00ffff;
        }
        .alert-custom {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.5);
            color: #ffcccc;
            border-radius: 10px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo-ar.jpg') }}" alt="Logo" class="register-logo img-fluid">
                        <h3 class="fw-bold">Daftar Akun</h3>
                        <p class="small">Buat akun untuk mengelola data mahasiswa</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-custom mb-3 text-start">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required placeholder="Buat username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group position-relative">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password_input" class="form-control" required placeholder="Min. 6 karakter">
                                <i class="fas fa-eye-slash password-toggle" id="toggle_password_icon"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3" style="background: linear-gradient(45deg, #00d2ff, #3a7bd5); border: none;">Daftar Sekarang</button>
                    </form>
                    <div class="text-center">
                        <p class="small mb-0">Sudah punya akun? <a href="/login" class="text-decoration-none fw-bold" style="color: #00ffff !important;">Masuk di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('password_input');
        const toggleIcon = document.getElementById('toggle_password_icon');
        toggleIcon.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                passwordInput.type = 'password';
                this.classList.replace('fa-eye', 'fa-eye-slash');
            }
        });
    </script>
</body>
</html>