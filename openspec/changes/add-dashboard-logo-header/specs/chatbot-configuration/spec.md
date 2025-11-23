# Especificación: Header con Logo y Título en Dashboard

## MODIFIED Requirements

### Requirement: Diseño Responsive Sin Scroll
El sistema SHALL proporcionar una interfaz adaptativa que funcione en diferentes tamaños de pantalla sin requerir desplazamiento vertical u horizontal, incluyendo el nuevo header con branding.

#### Scenario: Vista móvil con header (< 768px)
- **WHEN** el usuario accede desde un dispositivo móvil
- **THEN** el sistema muestra el header con logo (40px) y título "Requerimientos"
- **AND** el header está en la parte superior
- **AND** el layout sigue siendo de una columna
- **AND** todo el contenido (header + wizard) es visible sin scroll
- **AND** no se muestra el sidebar de pasos

#### Scenario: Vista desktop con header (≥ 1024px)
- **WHEN** el usuario accede desde un dispositivo desktop
- **THEN** el sistema muestra el header con logo (48px) y título "Requerimientos"
- **AND** el header ocupa el ancho completo
- **AND** el layout de dos columnas se mantiene debajo del header
- **AND** todo el contenido es visible sin scroll

## ADDED Requirements

### Requirement: Header con Branding Corporativo
El sistema SHALL mostrar un header en la parte superior del dashboard que incluya el logotipo de Call Blaster y el título "Requerimientos".

#### Scenario: Mostrar header con logo y título
- **WHEN** el usuario accede al dashboard
- **THEN** el sistema muestra un header en la parte superior
- **AND** el header contiene el logotipo de Call Blaster desde `/main/img/Logo_Claro_Trans.png`
- **AND** el header contiene el título "Requerimientos" junto al logo
- **AND** el logo y título están alineados horizontalmente
- **AND** el header usa el tema oscuro consistente con el resto del dashboard

#### Scenario: Logo responsive según dispositivo
- **WHEN** el usuario accede desde móvil (< 768px)
- **THEN** el logo tiene altura de 40px
- **AND** el título usa tamaño text-xl
- **WHEN** el usuario accede desde desktop (≥ 768px)
- **THEN** el logo tiene altura de 48px
- **AND** el título usa tamaño text-2xl o text-3xl

#### Scenario: Alineación vertical del header
- **WHEN** el header se renderiza
- **THEN** el logo y el título están alineados verticalmente en el centro
- **AND** hay un espaciado de 1rem (16px) entre el logo y el título
- **AND** el header tiene padding vertical de 1rem
- **AND** el header tiene padding horizontal de 1.5rem

### Requirement: Identidad Visual Corporativa
El sistema SHALL usar el logotipo oficial de Call Blaster y mantener la consistencia visual con el sitio principal.

#### Scenario: Usar logo corporativo oficial
- **WHEN** el sistema renderiza el header
- **THEN** el logo se carga desde `../main/img/Logo_Claro_Trans.png`
- **AND** el logo mantiene su proporción original (w-auto)
- **AND** el logo tiene alt text "Call Blaster Logo"
- **AND** el logo se carga con prioridad (loading="eager")

#### Scenario: Consistencia de tema oscuro
- **WHEN** el header se muestra
- **THEN** el fondo del header es gris oscuro (#1F2937 o similar)
- **AND** el título usa color de texto claro (#F9FAFB)
- **AND** hay un borde inferior sutil (#374151) para separación
- **AND** el estilo es consistente con el resto del wizard

### Requirement: Tipografía del Título
El sistema SHALL mostrar el título "Requerimientos" con tipografía clara, legible y consistente con la interfaz.

#### Scenario: Renderizar título con estilo correcto
- **WHEN** el título se muestra en el header
- **THEN** el texto es "Requerimientos"
- **AND** la fuente es Inter (consistente con el wizard)
- **AND** el peso de fuente es bold (700)
- **AND** el color es gris claro para contraste sobre fondo oscuro
- **AND** el tamaño es responsive según el dispositivo

#### Scenario: Jerarquía visual del título
- **WHEN** el usuario ve el dashboard
- **THEN** el título está marcado como `<h1>` (heading principal)
- **AND** el título es el primer heading de la página
- **AND** el título tiene jerarquía visual clara (tamaño y peso)

### Requirement: Separación Visual del Header
El sistema SHALL proporcionar separación visual clara entre el header y el contenido del wizard.

#### Scenario: Borde de separación
- **WHEN** el header se renderiza
- **THEN** hay un borde inferior en el header
- **AND** el borde es de color gris medio (#374151)
- **AND** el borde es sutil pero visible (1px)
- **AND** el borde separa visualmente el header del wizard

#### Scenario: Estructura HTML semántica
- **WHEN** el HTML se renderiza
- **THEN** el header usa la etiqueta semántica `<header>`
- **AND** el título usa la etiqueta `<h1>`
- **AND** el logo usa la etiqueta `<img>` con alt text apropiado
- **AND** la estructura es accesible para lectores de pantalla

### Requirement: Preservación de Funcionalidad
El sistema SHALL mantener toda la funcionalidad existente del wizard al agregar el header.

#### Scenario: Wizard funciona después de agregar header
- **WHEN** se agrega el header al dashboard
- **THEN** la navegación entre preguntas funciona normalmente
- **AND** la validación de campos funciona igual
- **AND** el guardado de configuración funciona sin cambios
- **AND** los modales de éxito/error se muestran correctamente
- **AND** la barra de progreso funciona igual

#### Scenario: Layout sin scroll se mantiene
- **WHEN** se agrega el header
- **THEN** el diseño sigue sin requerir scroll vertical
- **AND** el contenido del wizard se ajusta al espacio disponible
- **AND** no aparece scroll horizontal en ningún dispositivo
- **AND** el sidebar (desktop) sigue completamente visible

### Requirement: Performance del Header
El sistema SHALL cargar el header y el logo sin impactar significativamente el tiempo de carga de la página.

#### Scenario: Carga rápida del logo
- **WHEN** la página se carga
- **THEN** el logo se carga con prioridad alta (loading="eager")
- **AND** el logo no causa reflow o layout shift
- **AND** el tiempo de carga total aumenta menos de 50ms
- **AND** el navegador cachea el logo para visitas subsiguientes

#### Scenario: Tamaño de archivo aceptable
- **WHEN** el logo se incluye en la página
- **THEN** el archivo del logo es menor a 20 KB
- **AND** el formato PNG con transparencia es apropiado
- **AND** no requiere optimización adicional

### Requirement: Accesibilidad del Header
El sistema SHALL garantizar que el header sea accesible para todos los usuarios, incluyendo aquellos que usan tecnologías asistivas.

#### Scenario: Alt text descriptivo
- **WHEN** un lector de pantalla encuentra el logo
- **THEN** el alt text "Call Blaster Logo" se lee correctamente
- **AND** el texto alternativo es descriptivo pero conciso
- **AND** proporciona contexto adecuado del contenido visual

#### Scenario: Contraste de texto
- **WHEN** se renderiza el título
- **THEN** el contraste entre el texto y el fondo es al menos 7:1 (AAA)
- **AND** el texto es legible en todas las condiciones de iluminación
- **AND** cumple con WCAG 2.1 nivel AAA

#### Scenario: Navegación por teclado
- **WHEN** un usuario navega con Tab
- **THEN** el foco se mueve directamente al primer campo del wizard
- **AND** el logo no recibe foco (no es interactivo)
- **AND** el título no recibe foco (es solo texto)
- **AND** el orden de tabulación es lógico

#### Scenario: Lectores de pantalla
- **WHEN** un lector de pantalla lee la página
- **THEN** el header se anuncia como "header" o "banner"
- **AND** el título se lee como "heading level 1: Requerimientos"
- **AND** el logo se lee con su alt text
- **AND** el orden de lectura es: logo → título → contenido wizard

### Requirement: Consistencia entre Dispositivos
El sistema SHALL mostrar el header de forma consistente en todos los navegadores y dispositivos soportados.

#### Scenario: Consistencia cross-browser
- **WHEN** se accede desde Chrome, Firefox, Safari o Edge
- **THEN** el header se renderiza idénticamente
- **AND** el espaciado es consistente
- **AND** las fuentes se cargan correctamente
- **AND** no hay diferencias visuales significativas

#### Scenario: Soporte mobile
- **WHEN** se accede desde iOS Safari
- **OR** se accede desde Chrome Mobile en Android
- **THEN** el header responsive funciona correctamente
- **AND** el logo se ve nítido en pantallas retina
- **AND** el touch no interfiere con el header (no es interactivo)
