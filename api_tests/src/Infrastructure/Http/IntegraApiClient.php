<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Cecapta\IntegraApi\Infrastructure\Exception\ApiConnectionException;
use Cecapta\IntegraApi\Infrastructure\Exception\ApiResponseException;

/**
 * Cliente HTTP para comunicarse con la API de IntegraApp
 * Utiliza Guzzle como cliente HTTP subyacente
 */
final class IntegraApiClient
{
    private const BASE_URL = 'https://integraapp.net/API/';
    private const DEFAULT_TIMEOUT = 30;
    private const DEFAULT_CONNECT_TIMEOUT = 10;

    private Client $httpClient;

    public function __construct(
        ?string $baseUrl = null,
        int $timeout = self::DEFAULT_TIMEOUT,
        int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        array $additionalOptions = []
    ) {
        $this->httpClient = new Client(array_merge([
            'base_uri' => $baseUrl ?? self::BASE_URL,
            'timeout' => $timeout,
            'connect_timeout' => $connectTimeout,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false, // Manejamos los errores manualmente
        ], $additionalOptions));
    }

    /**
     * Realiza una petición GET a la API
     *
     * @param string $endpoint Endpoint relativo (ej: '/Empresas/ConsultarTabla/token123')
     * @param array $queryParams Parámetros de query string opcionales
     * @return array Respuesta decodificada de la API
     * @throws ApiConnectionException Si hay error de conexión
     * @throws ApiResponseException Si la respuesta no es válida
     */
    public function get(string $endpoint, array $queryParams = []): array
    {
        try {
            $response = $this->httpClient->get($endpoint, [
                'query' => $queryParams,
            ]);

            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();

            // Validar código de respuesta
            if ($statusCode < 200 || $statusCode >= 300) {
                throw new ApiResponseException(
                    "Error HTTP {$statusCode}: {$body}",
                    $statusCode
                );
            }

            // Decodificar JSON
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($data)) {
                throw new ApiResponseException(
                    'La respuesta de la API no es un array válido',
                    $statusCode
                );
            }

            return $data;

        } catch (GuzzleException $e) {
            throw new ApiConnectionException(
                "Error de conexión con la API: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        } catch (\JsonException $e) {
            throw new ApiResponseException(
                "Error al decodificar la respuesta JSON: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    /**
     * Realiza una petición GET a la API y retorna la respuesta como string
     * Útil para endpoints que retornan cadenas simples en lugar de JSON
     *
     * @param string $endpoint Endpoint relativo
     * @return string Respuesta en formato string
     * @throws ApiConnectionException Si hay error de conexión
     * @throws ApiResponseException Si la respuesta no es válida
     */
    public function getString(string $endpoint): string
    {
        try {
            $response = $this->httpClient->get($endpoint);

            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();

            // Validar código de respuesta
            if ($statusCode < 200 || $statusCode >= 300) {
                throw new ApiResponseException(
                    "Error HTTP {$statusCode}: {$body}",
                    $statusCode
                );
            }

            return trim($body);

        } catch (GuzzleException $e) {
            throw new ApiConnectionException(
                "Error de conexión con la API: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Obtiene la URL base configurada
     */
    public function getBaseUrl(): string
    {
        return (string) $this->httpClient->getConfig('base_uri');
    }
}
