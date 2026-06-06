<?php
declare(strict_types=1);
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/../config/conexion.php';

class ProductoRepository {

    public function obtenerTodos(): array {
        try {
            $pdo = getConexion();
            $stmt = $pdo->query(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 ORDER BY nombre"
            );
            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerTodos] ' . $e->getMessage());
            return [];
        }
    }

    public function buscarPorCodigo(string $codigo): ?Producto {
        try {
            $pdo = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE codigo_barras = :codigo"
            );
            $stmt->execute([':codigo' => $codigo]);
            $fila = $stmt->fetch();
            if ($fila === false) return null;
            return new Producto(
                $fila['codigo'],
                $fila['nombre'],
                (float) $fila['precio'],
                (int)   $fila['stock']
            );
        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorCodigo] ' . $e->getMessage());
            return null;
        }
    }

    public function buscarPorNombre(string $termino): array {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE nombre LIKE :termino
                 ORDER BY nombre"
            );
            $stmt->execute([':termino' => '%' . $termino . '%']);
            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorNombre] ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorCategoria(int $categoriaId): array {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE categoria_id = :id
                 ORDER BY nombre"
            );
            $stmt->execute([':id' => $categoriaId]);
            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerPorCategoria] ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerBajoStock(int $umbral): array {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE stock < :umbral
                 ORDER BY stock ASC"
            );
            $stmt->execute([':umbral' => $umbral]);
            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerBajoStock] ' . $e->getMessage());
            return [];
        }
    }

    public function contarTotalProductos(): int {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('[ProductoRepository::contarTotalProductos] ' . $e->getMessage());
            return 0;
        }
    }

    // BONUS: devuelve los N productos más caros del catálogo
    public function obtenerMasCaros(int $limite): array {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 ORDER BY precio DESC
                 LIMIT :limite"
            );
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerMasCaros] ' . $e->getMessage());
            return [];
        }
    }
}