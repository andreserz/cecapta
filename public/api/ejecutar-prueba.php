<?php

declare(strict_types=1);

session_start();

// Verificar autenticación
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

// Cargar autoloader y configuración
require_once __DIR__ . '/../../bootstrap.php';
$config = require __DIR__ . '/../../config/pruebas.php';

// Obtener datos de la petición
$input = json_decode(file_get_contents('php://input'), true);
$endpoint = $input['endpoint'] ?? null;
$dependencies = $input['dependencies'] ?? [];

if (!$endpoint) {
    http_response_code(400);
    echo json_encode(['error' => 'Endpoint no especificado']);
    exit;
}

// Imports necesarios
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpresaApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\SucursalApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\CampañaApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpleadoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\ProductoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;
use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpresas;
use Cecapta\IntegraApi\Application\UseCase\ConsultarSucursales;
use Cecapta\IntegraApi\Application\UseCase\ConsultarCampañas;
use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpleados;
use Cecapta\IntegraApi\Application\UseCase\ConsultarProductos;
use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;

// Preparar respuesta
$response = [
    'status' => 'error',
    'endpoint' => $endpoint,
    'timestamp' => date('Y-m-d H:i:s'),
    'execution_time' => 0,
    'http_code' => null,
];

try {
    $startTime = microtime(true);
    $token = $config['api_token'];
    $apiClient = new IntegraApiClient();
    
    // Ejecutar prueba según el endpoint
    switch ($endpoint) {
        case 'consultar-empresas':
            $repository = new EmpresaApiRepository($apiClient);
            $useCase = new ConsultarEmpresas($repository);
            $result = $useCase->execute($token);
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = array_map(fn($e) => $e->toArray(), $result);
            $response['summary'] = [
                'message' => count($result) . ' empresa(s) encontrada(s)',
                'count' => count($result)
            ];
            break;
            
        case 'consultar-sucursales':
            $empresaId = $config['test_data']['empresa_id'];
            $repository = new SucursalApiRepository($apiClient);
            $useCase = new ConsultarSucursales($repository);
            $result = $useCase->execute($token, $empresaId);
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = array_map(fn($s) => $s->toArray(), $result);
            $response['summary'] = [
                'message' => count($result) . ' sucursal(es) encontrada(s)',
                'count' => count($result)
            ];
            break;
            
        case 'consultar-campañas':
            $empresaId = $config['test_data']['empresa_id'];
            $repository = new CampañaApiRepository($apiClient);
            $useCase = new ConsultarCampañas($repository);
            $result = $useCase->execute($token, $empresaId);
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = array_map(fn($c) => $c->toArray(), $result);
            $response['summary'] = [
                'message' => count($result) . ' campaña(s) encontrada(s)',
                'count' => count($result)
            ];
            break;
            
        case 'consultar-empleados':
            $empresaId = $config['test_data']['empresa_id'];
            $repository = new EmpleadoApiRepository($apiClient);
            $useCase = new ConsultarEmpleados($repository);
            $result = $useCase->execute($token, $empresaId);
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = array_map(fn($e) => $e->toArray(), $result);
            $response['summary'] = [
                'message' => count($result) . ' empleado(s) encontrado(s)',
                'count' => count($result)
            ];
            break;
            
        case 'consultar-productos':
            $empresaId = $config['test_data']['empresa_id'];
            $repository = new ProductoApiRepository($apiClient);
            $useCase = new ConsultarProductos($repository);
            $result = $useCase->execute($token, $empresaId);
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = array_map(fn($p) => $p->toArray(), $result);
            $response['summary'] = [
                'message' => count($result) . ' producto(s) encontrado(s)',
                'count' => count($result)
            ];
            break;
            
        case 'registrar-prospecto':
            $testProspecto = $config['test_prospecto'];
            $repository = new ProspectoApiRepository($apiClient);
            $useCase = new RegistrarProspecto($repository);
            
            $prospectoId = $useCase->execute(
                $token,
                $testProspecto['curp'],
                $testProspecto['nombre'],
                $testProspecto['lada'],
                $testProspecto['telefono']
            );
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = [
                'prospecto_id' => $prospectoId,
                'curp' => $testProspecto['curp'],
                'nombre' => $testProspecto['nombre']
            ];
            $response['summary'] = [
                'message' => 'Prospecto registrado exitosamente',
                'ids' => [
                    'prospecto_id' => $prospectoId
                ]
            ];
            $response['data'] = [
                'prospecto_id' => $prospectoId
            ];
            break;
            
        case 'crear-oportunidad':
            // Requiere prospecto_id del test anterior
            if (!isset($dependencies['registrar-prospecto']['data']['prospecto_id'])) {
                throw new \Exception('Se requiere ejecutar "Registrar Prospecto" primero');
            }
            
            $prospectoId = $dependencies['registrar-prospecto']['data']['prospecto_id'];
            $testData = $config['test_data'];
            $testOportunidad = $config['test_oportunidad'];
            
            $repository = new OportunidadApiRepository($apiClient);
            $useCase = new CrearOportunidad($repository);
            
            $oportunidadId = $useCase->execute(
                $token,
                $testData['empresa_id'],
                $testData['sucursal_id'],
                $testData['empleado_id'],
                $testData['campaña_id'],
                $prospectoId,
                $testOportunidad['evento_programar'],
                $testOportunidad['evento_tipo'],
                (new DateTime('+3 days'))->format('Y-m-d H:i:s'),
                $testOportunidad['notas'],
                $testData['etapa_id'],
                (new DateTime('+30 days'))->format('Y-m-d'),
                $testOportunidad['probabilidad']
            );
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = [
                'oportunidad_id' => $oportunidadId,
                'prospecto_id' => $prospectoId,
                'probabilidad' => $testOportunidad['probabilidad']
            ];
            $response['summary'] = [
                'message' => 'Oportunidad creada exitosamente',
                'ids' => [
                    'oportunidad_id' => $oportunidadId,
                    'prospecto_id' => $prospectoId
                ]
            ];
            $response['data'] = [
                'oportunidad_id' => $oportunidadId,
                'prospecto_id' => $prospectoId
            ];
            break;
            
        case 'agregar-producto':
            // Requiere oportunidad_id del test anterior
            if (!isset($dependencies['crear-oportunidad']['data']['oportunidad_id'])) {
                throw new \Exception('Se requiere ejecutar "Crear Oportunidad" primero');
            }
            
            $oportunidadId = $dependencies['crear-oportunidad']['data']['oportunidad_id'];
            $testData = $config['test_data'];
            $testProducto = $config['test_producto'];
            
            $repository = new OportunidadApiRepository($apiClient);
            $useCase = new AgregarProductoAOportunidad($repository);
            
            $resultado = $useCase->execute(
                $token,
                $oportunidadId,
                $testData['producto_id'],
                $testProducto['cantidad'],
                $testData['esquema_impuestos_id'],
                $testData['precio_id'],
                $testProducto['precio_valor'],
                $testProducto['notas']
            );
            
            $response['status'] = 'success';
            $response['http_code'] = 200;
            $response['response'] = [
                'resultado' => $resultado ? 'Exitoso' : 'Fallido',
                'oportunidad_id' => $oportunidadId,
                'producto_id' => $testData['producto_id'],
                'cantidad' => $testProducto['cantidad'],
                'precio' => $testProducto['precio_valor']
            ];
            $response['summary'] = [
                'message' => 'Producto agregado exitosamente a la oportunidad',
                'ids' => [
                    'oportunidad_id' => $oportunidadId,
                    'producto_id' => $testData['producto_id']
                ]
            ];
            break;
            
        default:
            throw new \Exception('Endpoint no reconocido: ' . $endpoint);
    }
    
    $endTime = microtime(true);
    $response['execution_time'] = $endTime - $startTime;
    
} catch (\Exception $e) {
    $endTime = microtime(true);
    $response['execution_time'] = $endTime - $startTime;
    $response['status'] = 'error';
    $response['error'] = [
        'message' => $e->getMessage(),
        'type' => get_class($e),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ];
    $response['details'] = [
        'endpoint' => $endpoint,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

// Enviar respuesta
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
