<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Domain\Repository\OportunidadRepositoryInterface;
use Cecapta\IntegraApi\Domain\Entity\OportunidadProducto;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Agregar Producto a Oportunidad
 * 
 * Agrega un producto con cantidad y precio a una oportunidad existente
 */
final readonly class AgregarProductoAOportunidad
{
    public function __construct(
        private OportunidadRepositoryInterface $oportunidadRepository
    ) {}

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Token de autenticación
     * @param int $oportunidadId ID de la oportunidad
     * @param int $productoId ID del producto
     * @param int $cantidad Cantidad de productos
     * @param int $esquemaImpuestosId ID del esquema de impuestos
     * @param int $precioId ID del precio aplicable
     * @param float $precioValor Valor unitario del precio
     * @param string|null $notas Notas adicionales sobre el producto
     * @return bool True si se agregó correctamente
     * @throws \InvalidArgumentException Si los datos son inválidos
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si hay error en la API
     */
    public function execute(
        string $tokenValue,
        int $oportunidadId,
        int $productoId,
        int $cantidad,
        int $esquemaImpuestosId,
        int $precioId,
        float $precioValor,
        ?string $notas = null
    ): bool {
        // Validar datos
        $this->validarDatos($oportunidadId, $productoId, $cantidad, $esquemaImpuestosId, $precioId, $precioValor);

        // Crear value object
        $token = new Token($tokenValue);

        // Crear entidad de producto
        $producto = OportunidadProducto::create(
            $oportunidadId,
            $productoId,
            $cantidad,
            $esquemaImpuestosId,
            $precioId,
            $precioValor,
            $notas
        );

        // Agregar producto a la oportunidad
        return $this->oportunidadRepository->agregarProducto($token, $producto);
    }

    /**
     * Agrega múltiples productos a una oportunidad
     *
     * @param string $tokenValue Token de autenticación
     * @param int $oportunidadId ID de la oportunidad
     * @param array $productos Array de productos con estructura:
     *                         ['productoId', 'cantidad', 'esquemaImpuestosId', 'precioId', 'precioValor', 'notas']
     * @return array Array con resultados: ['exito' => int, 'fallidos' => array]
     */
    public function executeMultiple(
        string $tokenValue,
        int $oportunidadId,
        array $productos
    ): array {
        $exitosos = 0;
        $fallidos = [];

        foreach ($productos as $index => $prod) {
            try {
                $this->execute(
                    $tokenValue,
                    $oportunidadId,
                    $prod['productoId'],
                    $prod['cantidad'],
                    $prod['esquemaImpuestosId'],
                    $prod['precioId'],
                    $prod['precioValor'],
                    $prod['notas'] ?? null
                );
                $exitosos++;
            } catch (\Exception $e) {
                $fallidos[] = [
                    'index' => $index,
                    'producto' => $prod,
                    'error' => $e->getMessage()
                ];
            }
        }

        return [
            'exito' => $exitosos,
            'fallidos' => $fallidos
        ];
    }

    private function validarDatos(
        int $oportunidadId,
        int $productoId,
        int $cantidad,
        int $esquemaImpuestosId,
        int $precioId,
        float $precioValor
    ): void {
        if ($oportunidadId <= 0) {
            throw new \InvalidArgumentException('El ID de la oportunidad debe ser positivo');
        }

        if ($productoId <= 0) {
            throw new \InvalidArgumentException('El ID del producto debe ser positivo');
        }

        if ($cantidad <= 0) {
            throw new \InvalidArgumentException('La cantidad debe ser positiva');
        }

        if ($esquemaImpuestosId <= 0) {
            throw new \InvalidArgumentException('El ID del esquema de impuestos debe ser positivo');
        }

        if ($precioId <= 0) {
            throw new \InvalidArgumentException('El ID del precio debe ser positivo');
        }

        if ($precioValor < 0) {
            throw new \InvalidArgumentException('El precio no puede ser negativo');
        }
    }
}
