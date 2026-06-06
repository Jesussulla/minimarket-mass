<?php /* Recibe $error desde AuthController */ ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['intentos_fallidos'])) {
    $_SESSION['intentos_fallidos'] = 0;
}
if (!empty($error)) {
    $_SESSION['intentos_fallidos']++;
}
$intentos = $_SESSION['intentos_fallidos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ingreso · Minimarket Mass</title>
<style>
  *{box-sizing:border-box;font-family:'Segoe UI',Arial,sans-serif;margin:0;padding:0}
  body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0066B3,#004F8C)}
  .login{background:#fff;width:340px;border-radius:14px;padding:32px 28px;box-shadow:0 18px 45px rgba(0,0,0,.25)}
  .logo{display:block;text-align:center;background:#0066B3;color:#fff;font-weight:800;font-size:20px;letter-spacing:1px;padding:8px 0;border-radius:8px;margin-bottom:18px}
  label{display:block;font-size:13px;font-weight:600;margin:14px 0 5px}
  input{width:100%;padding:11px 13px;border:1px solid #d7dde6;border-radius:8px;font-size:14px;transition:border .2s}
  input:focus{outline:none;border-color:#0066B3;box-shadow:0 0 0 3px rgba(0,102,179,.1)}
  input:disabled{background:#f5f5f5;cursor:not-allowed}
  button{width:100%;margin-top:20px;padding:12px;border:none;border-radius:8px;background:#0066B3;color:#fff;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s}
  button:hover:not(:disabled){background:#0055a0}
  button:disabled{background:#b0c4de;cursor:not-allowed}
  .hint{margin-top:16px;text-align:center;font-size:12px;color:#94a1b2}
  .error{background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;font-size:13px;padding:10px 12px;border-radius:8px;margin-bottom:8px}
  .error-bloqueado{background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;font-size:13px;padding:10px 12px;border-radius:8px;margin-bottom:8px;text-align:center}
  .intentos-dots{display:flex;justify-content:center;gap:6px;margin-bottom:10px}
  .dot{width:9px;height:9px;border-radius:50%;background:#e5e7eb;transition:background .3s}
  .dot.activo{background:#ef4444}
</style>
</head>
<body>
  <div class="login">
    <span class="logo">MASS</span>

    <?php if (!empty($error)): ?>
      <div class="intentos-dots">
        <?php for ($i = 1; $i <= 3; $i++): ?>
          <div class="dot <?= $i <= $intentos ? 'activo' : '' ?>"></div>
        <?php endfor; ?>
      </div>

      <?php if ($intentos >= 3): ?>
        <div class="error-bloqueado">
          ⚠️ Demasiados intentos fallidos.<br>
          <small>Verifica tus credenciales e intenta de nuevo.</small>
        </div>
      <?php else: ?>
        <div class="error">
          <?= htmlspecialchars($error) ?>
          <span style="float:right;opacity:.6"><?= $intentos ?>/3</span>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="index.php?accion=procesar-login">
      <label>Usuario</label>
      <input type="text" name="username" autofocus
             value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
             <?= $intentos >= 3 ? 'disabled' : '' ?>>

      <label>Contraseña</label>
      <input type="password" name="password"
             <?= $intentos >= 3 ? 'disabled' : '' ?>>

      <button type="submit" <?= $intentos >= 3 ? 'disabled' : '' ?>>
        <?= $intentos >= 3 ? '🔒 Bloqueado' : 'Ingresar' ?>
      </button>
    </form>

    <p class="hint">Demo: cajero01 / admin123</p>
  </div>
</body>
</html>