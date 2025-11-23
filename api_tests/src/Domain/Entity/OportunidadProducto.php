<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\OportunidadId;

/**
 * Entidad de dominio: OportunidadProducto
 * 
 * Representa un producto agregado a una oportunidad de venta
 */
final readonly class OportunidadProducto
{
    public function __construct(
        private OportunidadId $oportunidadId,
        private int $productoId,
        private int $cantidad,
        private int $esquemaImpuestosId,
        private int $precioId,
        private float $precioValor,
        private ?string $notas,
        private bool $guardado = false
    ) {}

    public function getOportunidadId(): OportunidadId
    {
        return $this->oportunidadId;
    }

    public function getProductoId(): int
    {
        return $this->productoId;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getEsquemaImpuestosId(): int
    {
        return $this->esquemaImpuestosId;
    }

    public function getPrecioId(): int
    {
        return $this->precioId;
    }

    public function getPrecioValor(): float
    {
        return $this->precioValor;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function isGuardado(): bool
    {
        return $this->guardado;
    }

    public function getSubtotal(): float
    {
        return $this->precioValor * $this->cantidad;
    }

    /**
     * Marca el producto como guardado exitosamente
     */
    public function marcarGuardado(): self
    {
        return new self(
            $this->oportunidadId,
            $this->productoId,
            $this->cantidad,
            $this->esquemaImpuestosId,
            $this->precioId,
            $this->precioValor,
            $this->notas,
            true
        );
    }

    /**
     * Crea una instancia desde datos primitivos
     */
    public static function create(
        int $oportunidadId,
        int $productoId,
        int $cantidad,
        int $esquemaImpuestosId,
        int $precioId,
        float $precioValor,
        ?string $notas = null
    ): self {
        return new self(
            new OportunidadId($oportunidadId),
            $productoId,
            $cantidad,
            $esquemaImpuestosId,
            $precioId,
            $precioValor,
            $notas,
            false
        );
    }
}
