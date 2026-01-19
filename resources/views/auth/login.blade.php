<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — WebGIS Oasis</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }

body {
  margin: 0;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
  background: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6')
              center / cover no-repeat;
  position: relative;
  overflow: hidden;
}

body::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0,40,20,0.6);
  backdrop-filter: blur(6px);
  z-index: 0;
}

/* LOGIN CARD */
.auth-container {
  z-index: 5;
  width: 400px;
  background: #ffffff;
  border-radius: 18px;
  padding: 42px 32px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.35);
  color: #1f2937;
}

/* TITLE */
.auth-title {
  text-align: center;
  font-weight: 700;
  font-size: 1.6rem;
  background: linear-gradient(90deg, #16a34a, #22c55e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 24px;
}

/* INPUT */
.form-control {
  background: #f9fafb;
  border: 1px solid #d1d5db;
  color: #111827;
  border-radius: 12px;
  padding: 12px;
}

.form-control::placeholder { color: #9ca3af; }

.form-control:focus {
  border-color: #22c55e;
  box-shadow: 0 0 12px rgba(34,197,94,0.35);
}

/* BUTTON */
.btn-glow {
  width: 100%;
  background: linear-gradient(90deg,#064e3b,#065f46);
  border: none;
  border-radius: 12px;
  color: #ecfdf5;
  font-weight: 700;
  padding: 12px;
  margin-top: 10px;
  box-shadow: 0 0 18px rgba(6,95,70,0.6);
}

.btn-glow:hover {
  transform: scale(1.03);
  background: linear-gradient(90deg,#065f46,#047857);
  box-shadow: 0 0 28px rgba(6,95,70,0.85);
}

/* ERROR ALERT ANIMATION */
.alert {
  animation: fadeDown .4s ease;
}

@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-8px); }
  to { opacity: 1; transform: translateY(0); }
}

/* LOADING */
.loading-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.55);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.loading-box {
  background: #ffffff;
  padding: 30px 40px;
  border-radius: 16px;
  text-align: center;
}

.spinner {
  width: 48px;
  height: 48px;
  border: 5px solid #d1fae5;
  border-top: 5px solid #065f46;
  border-radius: 50%;
  animation: spin 0.9s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
</head>

<body>

<div class="auth-container">
  <h2 class="auth-title">🌿 WebGIS Oasis</h2>

  {{-- NOTIFIKASI ERROR LOGIN --}}
  @if($errors->any())
    <div class="alert alert-danger text-center">
      ❌ Email atau password salah
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
    </div>

    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <button type="submit" class="btn-glow">Masuk Admin</button>

    <div class="text-center mt-3">
      <small class="text-muted">WebGIS Tanaman • Oasis Djarum</small>
    </div>
  </form>
</div>

<!-- LOADING -->
<div id="loadingOverlay" class="loading-overlay">
  <div class="loading-box">
    <div class="spinner"></div>
    <p class="mt-3 fw-semibold text-success">Memverifikasi akun...</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const loginForm = document.getElementById('loginForm');
  const loadingOverlay = document.getElementById('loadingOverlay');

  loginForm.addEventListener('submit', () => {
    loadingOverlay.style.display = 'flex';
  });

  // Jika error muncul, pastikan loading mati
  @if($errors->any())
    loadingOverlay.style.display = 'none';
  @endif
</script>

</body>
</html>
