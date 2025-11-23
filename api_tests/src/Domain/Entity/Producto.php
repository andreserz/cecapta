<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\EstatusEmpresa;

/**
 * Entidad que representa un Producto en el dominio
 * 
 * Nota: Este endpoint usa 'Id' en lugar de 'IdBD' (diferente a otros endpoints)
 */
final readonly class Producto
{
    public function __construct(
        private int $id,
        private string $nombre,
        private EstatusEmpresa $estatus,
        private int $esquemaImpuestosId,
        private int $listaPreciosId,
        private string $precio,
        private float $precioValor
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEstatus(): EstatusEmpresa
    {
        return $this->estatus;
    }

    public function getEsquemaImpuestosId(): int
    {
        return $this->esquemaImpuestosId;
    }

    public function getListaPreciosId(): int
    {
        return $this->listaPreciosId;
    }

    public function getPrecio(): string
    {
        return $this->precio;
    }

    public function getPrecioValor(): float
    {
        return $this->precioValor;
    }

    public function isActivo(): bool
    {
        return $this->estatus->isActivo();
    }

    /**
     * Obtiene el precio formateado con símbolo de moneda
     */
    public function getPrecioFormateado(string $moneda = '$'): string
    {
        return $moneda . number_format($this->precioValor, 2, '.', ',');
    }

    /**
     * Crea una instancia desde un array de datos
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['Id'] ?? $data['id'] ?? 0),
            nombre: (string) ($data['Nombre'] ?? $data['nombre'] ?? ''),
            estatus: EstatusEmpresa::fromString((string) ($data['Estatus'] ?? $data['estatus'] ?? 'ACTIVO')),
            esquemaImpuestosId: (int) ($data['EsquemaImpuestosId'] ?? $data['esquemaImpuestosId'] ?? 0),
            listaPreciosId: (int) ($data['ListaPreciosId'] ?? $data['listaPreciosId'] ?? 0),
            precio: (string) ($data['Precio'] ?? $data['precio'] ?? ''),
            precioValor: (float) ($data['PrecioValor'] ?? $data['precioValor'] ?? 0.0)
        );
    }

    /**
     * Convierte la entidad a array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'estatus' => $this->estatus->value,
            'esquemaImpuestosId' => $this->esquemaImpuestosId,
            'listaPreciosId' => $this->listaPreciosId,
            'precio' => $this->precio,
            'precioValor' => $this->precioValor
        ];
    }
}
