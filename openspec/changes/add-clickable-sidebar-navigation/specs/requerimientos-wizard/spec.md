# Spec: Sistema de Requerimientos - Navegación Clickeable en Sidebar

## ADDED Requirements

### Requirement: Navegación Clickeable en Sidebar
El sistema SHALL permitir a los usuarios hacer clic en los pasos del sidebar "Pasos de Configuración" para navegar directamente a una pregunta específica, mejorando la eficiencia y experiencia de usuario.

#### Scenario: Click en paso anterior
- **GIVEN** el usuario está en la pregunta #5
- **AND** hay pasos anteriores (#1, #2, #3, #4) en el sidebar
- **WHEN** el usuario hace clic en el paso #2
- **THEN** la respuesta actual se guarda automáticamente
- **AND** el sistema navega a la pregunta #2
- **AND** la pregunta #2 se muestra en el área principal

#### Scenario: Click en siguiente paso inmediato
- **GIVEN** el usuario está en la pregunta #3
- **AND** el paso #4 está disponible en el sidebar
- **WHEN** el usuario hace clic en el paso #4
- **THEN** la respuesta actual se guarda automáticamente
- **AND** el sistema navega a la pregunta #4
- **AND** la pregunta #4 se muestra en el área principal

#### Scenario: Click en paso ya completado
- **GIVEN** el usuario completó las preguntas #1, #2, #3
- **AND** actualmente está en la pregunta #5
- **WHEN** el usuario hace clic en el paso #3 (ya completado)
- **THEN** la respuesta actual se guarda automáticamente
- **AND** el sistema navega a la pregunta #3
- **AND** muestra la respuesta previamente guardada

#### Scenario: Click en paso futuro no visitado - bloqueado
- **GIVEN** el usuario está en la pregunta #2
- **AND** el paso #5 no ha sido visitado
- **WHEN** el usuario hace clic en el paso #5
- **THEN** el sistema muestra un mensaje informativo "Completa las preguntas anteriores primero"
- **AND** NO navega a la pregunta #5
- **AND** mantiene al usuario en la pregunta #2

### Requirement: Feedback Visual de Clickeabilidad
El sistema SHALL proporcionar feedback visual claro para indicar qué pasos son clickeables y cuáles no, usando estados hover y estilos diferenciados.

#### Scenario: Hover sobre paso clickeable
- **GIVEN** un paso es clickeable (anterior, siguiente inmediato, o completado)
- **WHEN** el usuario posiciona el cursor sobre el paso
- **THEN** el paso muestra un background color naranja suave (rgba(249, 115, 22, 0.1))
- **AND** el paso se desplaza ligeramente a la derecha (transform: translateX(4px))
- **AND** el cursor cambia a pointer

#### Scenario: Paso no clickeable - visual deshabilitado
- **GIVEN** un paso está en el futuro y no ha sido visitado
- **WHEN** el paso se renderiza en el sidebar
- **THEN** el paso muestra opacity reducida (0.5)
- **AND** el cursor es "not-allowed" al hacer hover
- **AND** el paso no muestra efectos hover interactivos

### Requirement: Auto-guardado Antes de Navegar
El sistema SHALL guardar automáticamente la respuesta actual cuando el usuario navega a otra pregunta mediante click en el sidebar, sin requerir validación estricta.

#### Scenario: Guardado automático en navegación
- **GIVEN** el usuario escribió texto en la pregunta #3
- **AND** el texto no fue guardado explícitamente
- **WHEN** el usuario hace clic en el paso #1 del sidebar
- **THEN** el sistema llama a `guardarRespuestaActual()`
- **AND** la respuesta de la pregunta #3 se almacena en `estado.respuestas[2]`
- **AND** luego navega a la pregunta #1

#### Scenario: Guardado sin validación estricta
- **GIVEN** el usuario está en una pregunta con campo vacío
- **WHEN** el usuario hace clic en otro paso del sidebar
- **THEN** el sistema guarda el valor actual (puede ser vacío)
- **AND** NO muestra mensaje de error de validación
- **AND** permite la navegación

### Requirement: Respeto a Validaciones de Dependencias
El sistema SHALL respetar las validaciones de dependencias existentes entre preguntas al determinar qué pasos son navegables.

#### Scenario: Navegación respetando dependencias activas
- **GIVEN** la pregunta #8 tiene dependencia_previa: "Activo"
- **AND** la pregunta #7 no ha sido respondida
- **WHEN** el usuario intenta hacer clic en el paso #8
- **THEN** el sistema verifica la dependencia
- **AND** bloquea la navegación al paso #8
- **AND** muestra feedback visual de paso deshabilitado

#### Scenario: Navegación a pregunta con dependencia null (opcional)
- **GIVEN** la pregunta #2 tiene dependencia_previa: null (opcional)
- **AND** el usuario está en la pregunta #1
- **WHEN** el usuario hace clic en el paso #2
- **THEN** el sistema permite la navegación
- **AND** muestra la pregunta #2

### Requirement: Comportamiento Solo Desktop
El sistema SHALL implementar la navegación clickeable solo en vista desktop donde el sidebar es visible, manteniendo el comportamiento actual en móvil.

#### Scenario: Sidebar visible en desktop
- **GIVEN** el usuario accede en un dispositivo con ancho >= 1024px
- **WHEN** el sidebar se renderiza
- **THEN** los pasos son clickeables según las reglas de navegación
- **AND** los event listeners están activos

#### Scenario: Sidebar oculto en móvil
- **GIVEN** el usuario accede en un dispositivo con ancho < 1024px
- **WHEN** la página se carga
- **THEN** el sidebar tiene clase "hidden lg:block"
- **AND** la navegación clickeable no es visible
- **AND** el usuario navega solo con botones Anterior/Siguiente
