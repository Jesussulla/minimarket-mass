<?php

class Producto {

    private string $codigo;
    private string $nombre;
    private string $categoria;
    private float  $precio;
    private int    $stock;

    public function __construct(string $codigo, string $nombre, string $categoria, float $precio, int $stock = 0) {
        $this->codigo    = $codigo;
        $this->nombre    = $nombre;
        $this->categoria = strtolower(trim($categoria));
        $this->precio    = $precio;
        $this->stock     = $stock;
    }

    public function getCodigo(): string    { return $this->codigo;    }
    public function getNombre(): string    { return $this->nombre;    }
    public function getCategoria(): string { return $this->categoria; }
    public function getPrecio(): float     { return $this->precio;    }
    public function getStock(): int        { return $this->stock;     }

    public function tasaIGV(): float {
        $exoneradas = ['panaderia', 'frutas y verduras'];
        return in_array($this->categoria, $exoneradas, true) ? 0.00 : 0.18;
    }

    public function precioConIGV(): float {
        return $this->precio * (1 + $this->tasaIGV());
    }

    public function haySuficienteStock(int $cantidad): bool {
        return $this->stock >= $cantidad;
    }

    public function descontarStock(int $cantidad): void {
        if (!$this->haySuficienteStock($cantidad)) {
            throw new RuntimeException(
                "Stock insuficiente para '{$this->nombre}'. Disponible: {$this->stock}, solicitado: {$cantidad}."
            );
        }
        $this->stock -= $cantidad;
    }
}