<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/UsuarioRepository.php';

class AuthController {

    public function mostrarLogin(string $error = ''): void {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function procesarLogin(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->mostrarLogin('Completa usuario y contraseña.');
            return;
        }

        $repo    = new UsuarioRepository();
        $usuario = $repo->buscarPorUsername($username);

        if ($usuario === null || !$usuario->verificarPassword($password)) {
            $this->mostrarLogin('Usuario o contraseña incorrectos.');
            return;
        }

        // Registrar último acceso
        $repo->registrarAcceso($usuario->getId());

        $_SESSION['usuario'] = [
            'id'            => $usuario->getId(),
            'username'      => $usuario->getUsername(),
            'nombre'        => $usuario->getNombreCompleto(),
            'rol'           => $usuario->getRol(),
            'tienda'        => $usuario->getTienda(),
            'ultimo_acceso' => $usuario->getUltimoAcceso()
                ? date('d/m/Y H:i', strtotime($usuario->getUltimoAcceso()))
                : 'Primer acceso',
        ];

        header('Location: index.php?accion=catalogo');
        exit;
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?accion=login');
        exit;
    }
}