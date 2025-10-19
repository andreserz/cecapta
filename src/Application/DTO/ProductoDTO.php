<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\DTO;

use Cecapta\IntegraApi\Domain\Entity\Producto;

/**
 * Data Transfer Object para transferir datos de Producto entre capas
 */
final readonly class ProductoDTO
{
    public function __construct(
        public int $id,
        public string $nombre,
        public string $estatus,
        public int $esquemaImpuestosId,
        public int $listaPreciosId,
        public string $precio,
        public float $precioValor,
        public string $precioFormateado,
        public bool $isActivo
    ) {
    }

    /**
     * Crea un DTO desde una entidad del dominio
     */
    public static function fromEntity(Producto $producto): self
    {
        return new self(
            id: $producto->getId(),
            nombre: $producto->getNombre(),
            estatus: $producto->getEstatus()->value,
            esquemaImpuestosId: $producto->getEsquemaImpuestosId(),
            listaPreciosId: $producto->getListaPreciosId(),
            precio: $producto->getPrecio(),
            precioValor: $producto->getPrecioValor(),
            precioFormateado: $producto->getPrecioFormateado(),
            isActivo: $producto->isActivo()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'estatus' => $this->estatus,
            'esquemaImpuestosId' => $this->esquemaImpuestosId,
            'listaPreciosId' => $this->listaPreciosId,
            'precio' => $this->precio,
            'precioValor' => $this->precioValor,
            'precioFormateado' => $this->precioFormateado,
            'isActivo' => $this->isActivo
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
