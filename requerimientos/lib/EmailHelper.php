<?php
/**
 * Helper para envío de correos mediante SMTP
 * Usa PHPMailer para envío confiable
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    private $config;
    private $mailer;
    
    /**
     * Constructor
     * @param array $config Configuración de email
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->mailer = new PHPMailer(true);
        $this->configurarSMTP();
    }
    
    /**
     * Configura los parámetros SMTP
     */
    private function configurarSMTP()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['smtp_host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['smtp_username'];
        $this->mailer->Password = $this->config['smtp_password'];
        $this->mailer->SMTPSecure = $this->config['smtp_encryption'];
        $this->mailer->Port = $this->config['smtp_port'];
        $this->mailer->CharSet = $this->config['charset'];
        $this->mailer->Timeout = $this->config['timeout'];
        
        // Debug (0 = off, 1 = client, 2 = client and server)
        $this->mailer->SMTPDebug = $this->config['debug'] ?? 0;
        
        // Configurar remitente
        $this->mailer->setFrom(
            $this->config['from_email'],
            $this->config['from_name']
        );
    }
    
    /**
     * Envía un correo de notificación de requerimientos
     * 
     * @param array $datos Datos del formulario
     * @param string $nombreArchivo Nombre del archivo de backup
     * @return array ['exito' => bool, 'mensaje' => string, 'error' => string|null]
     */
    public function enviarNotificacionRequerimientos(array $datos, string $nombreArchivo): array
    {
        try {
            // Limpiar destinatarios previos
            $this->mailer->clearAddresses();
            
            // Agregar destinatarios
            foreach ($this->config['to_emails'] as $email) {
                $this->mailer->addAddress($email);
            }
            
            // Preparar contenido
            $nombreEmpresa = $datos['nombre_empresa'] ?? 'Sin nombre';
            $this->mailer->Subject = "Nueva entrega de requerimientos - {$nombreEmpresa}";
            
            // Configurar formato del correo
            $this->mailer->isHTML(false); // Texto plano
            $this->mailer->Body = $this->generarCuerpoCorreo($datos, $nombreArchivo);
            
            // Enviar
            $this->mailer->send();
            
            return [
                'exito' => true,
                'mensaje' => 'Correo enviado exitosamente',
                'error' => null
            ];
            
        } catch (Exception $e) {
            // Log del error
            error_log("Error al enviar correo: " . $this->mailer->ErrorInfo);
            
            return [
                'exito' => false,
                'mensaje' => 'Error al enviar correo',
                'error' => $this->mailer->ErrorInfo
            ];
        }
    }
    
    /**
     * Genera el cuerpo del correo
     * 
     * @param array $datos Datos del formulario
     * @param string $nombreArchivo Nombre del archivo
     * @return string
     */
    private function generarCuerpoCorreo(array $datos, string $nombreArchivo): string
    {
        $cuerpo = "Se ha recibido una nueva entrega de requerimientos.\n\n";
        $cuerpo .= "Empresa: " . ($datos['nombre_empresa'] ?? 'No especificada') . "\n";
        $cuerpo .= "Fecha: " . date('Y-m-d H:i:s') . " (Hora de México)\n";
        $cuerpo .= "Archivo: {$nombreArchivo}\n\n";
        $cuerpo .= "Detalles:\n";
        
        if (!empty($datos['nombre_asistente'])) {
            $cuerpo .= "- Nombre del Asistente: {$datos['nombre_asistente']}\n";
        }
        
        if (!empty($datos['objetivos_asistente'])) {
            $cuerpo .= "- Objetivos: {$datos['objetivos_asistente']}\n";
        }
        
        if (!empty($datos['tono_comunicacion'])) {
            $cuerpo .= "- Tono de Comunicación: {$datos['tono_comunicacion']}\n";
        }
        
        if (!empty($datos['horario_atencion'])) {
            $cuerpo .= "- Horario de Atención: {$datos['horario_atencion']}\n";
        }
        
        if (!empty($datos['url_website'])) {
            $cuerpo .= "- Sitio Web: {$datos['url_website']}\n";
        }
        
        if (!empty($datos['casos_uso'])) {
            $cuerpo .= "\n--- Casos de Uso ---\n";
            $cuerpo .= $datos['casos_uso'] . "\n";
        }
        
        $cuerpo .= "\n---\n";
        $cuerpo .= "Este correo fue generado automáticamente por el Sistema de Requerimientos de CallBlaster AI.\n";
        $cuerpo .= "Ubicación del archivo: /var/www/cecapta.callblasterai.com/requerimientos/preguntas/backups/{$nombreArchivo}\n";
        
        return $cuerpo;
    }
}
