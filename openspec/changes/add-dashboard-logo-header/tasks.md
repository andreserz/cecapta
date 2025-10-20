# Tareas de Implementación: Header con Logo y Título

## 1. Preparación
- [ ] 1.1 Verificar ruta del logo: `/main/img/Logo_Claro_Trans.png`
- [ ] 1.2 Revisar tamaño actual del logo (13 KB)
- [ ] 1.3 Considerar si necesita optimización (probablemente no)

## 2. Implementación en HTML (index.php)

### 2.1 Estructura del Header
- [ ] 2.1.1 Agregar sección `<header>` antes del contenedor principal
- [ ] 2.1.2 Crear contenedor flex para logo + título
- [ ] 2.1.3 Agregar elemento `<img>` con ruta al logo
- [ ] 2.1.4 Configurar alt text: "Call Blaster Logo"
- [ ] 2.1.5 Agregar título `<h1>` con texto "Requerimientos"

### 2.2 Estilos Tailwind
- [ ] 2.2.1 Aplicar bg-gray-800 o bg-gray-900 al header
- [ ] 2.2.2 Configurar padding: py-4 px-6 o similar
- [ ] 2.2.3 Usar flexbox: flex items-center gap-4
- [ ] 2.2.4 Tamaño logo: h-12 (48px) en desktop, h-10 (40px) en móvil
- [ ] 2.2.5 Tipografía título: font-bold text-2xl lg:text-3xl
- [ ] 2.2.6 Color título: text-gray-100 o text-white
- [ ] 2.2.7 Opcional: border-b border-gray-700 para separación

### 2.3 Responsive
- [ ] 2.3.1 En móvil: logo más pequeño, título más compacto
- [ ] 2.3.2 En desktop: mantener tamaños normales
- [ ] 2.3.3 Verificar que el header no cause scroll vertical

## 3. Ajustes de Layout

### 3.1 Contenedor Principal
- [ ] 3.1.1 Ajustar altura disponible para el wizard
- [ ] 3.1.2 Mantener diseño sin scroll
- [ ] 3.1.3 Probar que sidebar (desktop) sigue visible completo
- [ ] 3.1.4 Verificar que card de pregunta no se recorte

### 3.2 Posicionamiento
- [ ] 3.2.1 Header debe estar fuera del max-w-7xl del wizard
- [ ] 3.2.2 O dentro pero arriba de todo el contenido
- [ ] 3.2.3 Considerar si el header es fijo (position: fixed) o estático

## 4. Testing

### 4.1 Visuales
- [ ] 4.1.1 Verificar que el logo se vea nítido
- [ ] 4.1.2 Verificar alineación vertical del logo y título
- [ ] 4.1.3 Comprobar espaciado adecuado (gap)
- [ ] 4.1.4 Verificar contraste del título sobre fondo oscuro

### 4.2 Responsive
- [ ] 4.2.1 Probar en móvil (320px, 375px, 414px)
- [ ] 4.2.2 Probar en tablet (768px, 1024px)
- [ ] 4.2.3 Probar en desktop (1280px, 1920px)
- [ ] 4.2.4 Verificar que no aparece scroll horizontal

### 4.3 Funcionalidad
- [ ] 4.3.1 Verificar que el wizard sigue funcionando normal
- [ ] 4.3.2 Probar navegación entre preguntas
- [ ] 4.3.3 Verificar que modales siguen funcionando
- [ ] 4.3.4 Comprobar que el guardado no se afecta

## 5. Optimización (Opcional)

### 5.1 Performance
- [ ] 5.1.1 Considerar preload de la imagen del logo
- [ ] 5.1.2 Agregar loading="eager" al img (ya que está above the fold)
- [ ] 5.1.3 Verificar tiempos de carga no aumenten significativamente

### 5.2 Accesibilidad
- [ ] 5.2.1 Verificar que el alt text es descriptivo
- [ ] 5.2.2 Comprobar orden de tab (logo no debe ser tabulable)
- [ ] 5.2.3 Verificar que lectores de pantalla leen el título correctamente

## 6. Documentación

- [ ] 6.1 Actualizar README.md si es necesario
- [ ] 6.2 Agregar comentario en código sobre el header
- [ ] 6.3 Documentar ruta del logo para referencia futura

## 7. Revisión Final

- [ ] 7.1 Comparar con diseño corporativo de main/
- [ ] 7.2 Verificar que mantiene el estilo del wizard
- [ ] 7.3 Confirmar que mejora la identidad visual
- [ ] 7.4 Probar en navegadores principales (Chrome, Firefox, Safari)

## 8. Despliegue

- [ ] 8.1 Commit de cambios con mensaje descriptivo
- [ ] 8.2 Verificar en servidor de desarrollo (si existe)
- [ ] 8.3 Probar en producción
- [ ] 8.4 Recargar caché del navegador si es necesario

## 9. Post-Implementación

- [ ] 9.1 Solicitar feedback de usuarios
- [ ] 9.2 Verificar que no hay reportes de problemas visuales
- [ ] 9.3 Archivar cambio en OpenSpec
