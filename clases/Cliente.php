<?php

class Cliente {

    private string $dni;
    private string $nombre;
    private string $apellido;
    private string $tipo;

    public function __construct(string $dni, string $nombre, string $apellido, string $tipo = 'regular') {
        if (!preg_match('/^\d{8}$/', $dni)) {
            $msg = ctype_digit($dni)
                ? "El DNI debe tener exactamente 8 dígitos. El tuyo tiene " . strlen($dni) . "."
                : "El DNI no puede contener letras ni espacios.";
            echo "<div style='color:#721c24;background:#f8d7da;padding:15px;border:1px solid #f5c6cb;font-family:sans-serif;border-radius:4px;margin:20px;'>[ERROR DNI]: $msg</div>";
            exit();
        }
        $this->dni      = $dni;
        $this->nombre   = $nombre;
        $this->apellido = $apellido;
        $this->tipo     = strtolower(trim($tipo));
    }

    public function getDni(): string      { return $this->dni;      }
    public function getNombre(): string   { return $this->nombre;   }
    public function getApellido(): string { return $this->apellido; }
    public function getTipo(): string     { return $this->tipo;     }

    public function nombreCompleto(): string {
        return $this->nombre . ' ' . $this->apellido;
    }
}