<?php

class Venta {

    private Cliente $cliente;
    private array   $lineas = [];
    private string  $fecha;
    private string  $metodoPago;

    public function __construct(Cliente $cliente, string $metodoPago = 'efectivo') {
        $this->cliente    = $cliente;
        $this->metodoPago = strtolower(trim($metodoPago));
        $this->fecha      = date('d/m/Y H:i:s');
    }

    public function getCliente(): Cliente   { return $this->cliente;    }
    public function getFecha(): string      { return $this->fecha;      }
    public function getMetodoPago(): string { return $this->metodoPago; }
    public function getLineas(): array      { return $this->lineas;     }

    public function agregarProducto(Producto $producto, int $cantidad): void {
        $this->lineas[] = ['producto' => $producto, 'cantidad' => $cantidad];
    }

    public function calcularSubtotal(): float {
        $total = 0.0;
        foreach ($this->lineas as $l) $total += $l['producto']->getPrecio() * $l['cantidad'];
        return $total;
    }

    public function calcularIGV(): float {
        $igv = 0.0;
        foreach ($this->lineas as $l) {
            $p = $l['producto'];
            $igv += $p->getPrecio() * $l['cantidad'] * $p->tasaIGV();
        }
        return $igv;
    }

    private function totalBruto(): float {
        return $this->calcularSubtotal() + $this->calcularIGV();
    }

    public function porcentajeDescuentoMonto(): int {
        $b = $this->totalBruto();
        if ($b >= 200) return 15;
        if ($b >= 100) return 10;
        if ($b >= 30)  return 5;
        return 0;
    }

    public function porcentajeDescuentoCliente(): int {
        if ($this->cliente->getTipo() === 'vip')       return 5;
        if ($this->cliente->getTipo() === 'frecuente') return 2;
        return 0;
    }

    public function descuentoMontoSoles(): float {
        return $this->totalBruto() * ($this->porcentajeDescuentoMonto() / 100);
    }

    public function descuentoClienteSoles(): float {
        return $this->totalBruto() * ($this->porcentajeDescuentoCliente() / 100);
    }

    public function calcularTotal(): float {
        return $this->totalBruto() - $this->descuentoMontoSoles() - $this->descuentoClienteSoles();
    }

    public function mensajeMetodoPago(): string {
        switch ($this->metodoPago) {
            case 'efectivo': return 'Pago en efectivo - exacto preferido';
            case 'yape':
            case 'plin':     return 'Mostrar QR del comercio';
            case 'tarjeta':  return 'Insertar tarjeta en POS';
            default:         return 'Método no especificado - Validar en caja';
        }
    }

    public function advertenciaSeguridad(): string {
        if ($this->metodoPago === 'efectivo' && $this->calcularTotal() > 500.00)
            return 'ALERTA DE SEGURIDAD: Se sugiere otro método para montos altos.';
        return '';
    }
}