# Frontend UI - Design System Specification Delta

## ADDED Requirements

### Requirement: Corporate Color Palette
The system SHALL provide a standardized corporate color palette based on orange theme for all frontend modules.

#### Scenario: Primary color usage
- **WHEN** a UI component requires primary branding color
- **THEN** the system SHALL use orange #F97316 as primary color

#### Scenario: Color consistency across modules
- **WHEN** a developer creates a new UI component in any module
- **THEN** the system SHALL enforce use of predefined color variables (--naranja-primario, --naranja-hover, --naranja-claro)

#### Scenario: Dark theme backgrounds
- **WHEN** rendering UI in dark theme mode
- **THEN** the system SHALL use #111827 as primary background color

### Requirement: DaisyUI Component Framework
The system SHALL use DaisyUI 4.4.19 as the standard component framework across all frontend modules.

#### Scenario: Component implementation
- **WHEN** a developer needs to create a button component
- **THEN** the system SHALL use DaisyUI button classes (.btn, .btn-primary-custom)

#### Scenario: Modal dialogs
- **WHEN** the system needs to display a modal dialog
- **THEN** the system SHALL use DaisyUI <dialog> element with .modal class

#### Scenario: Form inputs
- **WHEN** creating form input fields
- **THEN** the system SHALL use DaisyUI input classes (.input, .input-bordered)

### Requirement: Inter Typography
The system SHALL use Inter font family loaded locally across all frontend modules.

#### Scenario: Font loading
- **WHEN** a page is loaded
- **THEN** the system SHALL load Inter fonts from local shared directory (/shared/fonts/inter/)

#### Scenario: Font weights availability
- **WHEN** styling text content
- **THEN** the system SHALL provide Inter font weights from 300 (Light) to 800 (ExtraBold)

### Requirement: Shared Design Resources
The system SHALL maintain centralized design resources in a shared directory structure.

#### Scenario: Font access from modules
- **WHEN** any frontend module (requerimientos, api_tests, main) requires fonts
- **THEN** the system SHALL reference fonts from /shared/fonts/inter/

#### Scenario: Design documentation access
- **WHEN** a developer needs design guidelines
- **THEN** the system SHALL provide documentation in /shared/design-system/ directory

### Requirement: Theme Consistency
The system SHALL apply consistent theming approach across application modules.

#### Scenario: Dark theme for applications
- **WHEN** rendering administrative or work-oriented interfaces (api_tests, requerimientos)
- **THEN** the system SHALL apply data-theme="night" with corporate dark colors

#### Scenario: Landing page theme
- **WHEN** rendering the public landing page (main)
- **THEN** the system MAY use data-theme="light" with corporate color palette

### Requirement: Reusable Component Patterns
The system SHALL provide documented patterns for common UI components.

#### Scenario: Button patterns
- **WHEN** implementing a primary action button
- **THEN** the system SHALL provide .btn-primary-custom class with corporate orange color

#### Scenario: Card patterns
- **WHEN** displaying content in card format
- **THEN** the system SHALL use DaisyUI .card class with consistent styling

#### Scenario: Animation patterns
- **WHEN** adding entrance animations
- **THEN** the system SHALL use .fade-enter class or document new animation pattern

### Requirement: Accessibility Standards
The system SHALL ensure all UI components meet WCAG AA accessibility standards.

#### Scenario: Color contrast
- **WHEN** applying text color on background
- **THEN** the system SHALL maintain minimum contrast ratio of 4.5:1 for normal text

#### Scenario: Focus indicators
- **WHEN** a user navigates with keyboard
- **THEN** the system SHALL display visible focus outline using --naranja-primario color

#### Scenario: Screen reader compatibility
- **WHEN** using DaisyUI components
- **THEN** the system SHALL preserve semantic HTML and ARIA attributes

### Requirement: Responsive Design
The system SHALL ensure all UI components are responsive across mobile, tablet, and desktop viewports.

#### Scenario: Mobile-first approach
- **WHEN** implementing new UI components
- **THEN** the system SHALL use mobile-first responsive classes (Tailwind breakpoints)

#### Scenario: Viewport adaptation
- **WHEN** viewed on different screen sizes
- **THEN** the system SHALL adapt layout using DaisyUI responsive utilities and Tailwind breakpoints

### Requirement: Design System Documentation
The system SHALL provide comprehensive documentation for the design system.

#### Scenario: Component catalog
- **WHEN** a developer needs to use a component
- **THEN** the system SHALL provide documentation in /shared/design-system/components.md

#### Scenario: Color usage guide
- **WHEN** selecting colors for new features
- **THEN** the system SHALL provide palette documentation in /shared/design-system/colors.md

#### Scenario: Pattern examples
- **WHEN** implementing common UI patterns
- **THEN** the system SHALL provide examples in /shared/design-system/patterns.md
