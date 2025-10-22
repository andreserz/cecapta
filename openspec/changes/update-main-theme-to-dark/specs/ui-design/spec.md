## ADDED Requirements

### Requirement: Dark Theme Consistency
The system SHALL ensure all user-facing modules use a consistent dark theme (DaisyUI "night") to provide a unified visual experience across the entire application.

#### Scenario: Main module uses dark theme
- **GIVEN** a user navigates to the main landing page (`./main/`)
- **WHEN** the page loads
- **THEN** the page SHALL display with dark theme (data-theme="night")
- **AND** background colors SHALL be dark (gray-900, gray-800)
- **AND** text colors SHALL be light (gray-100, gray-300) for proper contrast

#### Scenario: Consistent theme across modules
- **GIVEN** a user navigates between different modules (main, requerimientos, dashboard)
- **WHEN** switching from one module to another
- **THEN** all modules SHALL maintain dark theme consistently
- **AND** the visual transition SHALL be seamless without jarring theme changes

### Requirement: Dark Theme Color Palette
The dark theme SHALL use the defined corporate color palette with appropriate dark mode adaptations while preserving brand colors.

#### Scenario: Background colors in dark theme
- **GIVEN** the main module is loaded
- **WHEN** rendering page elements
- **THEN** primary background SHALL be #111827 (gray-900)
- **AND** secondary background (cards, navbar) SHALL be #1F2937 (gray-800)
- **AND** tertiary background (elevated elements) SHALL be #374151 (gray-700)

#### Scenario: Text colors in dark theme
- **GIVEN** text elements on dark backgrounds
- **WHEN** rendering text content
- **THEN** primary headings SHALL use #F9FAFB (gray-100)
- **AND** secondary text SHALL use #D1D5DB (gray-300)
- **AND** muted text SHALL use #9CA3AF (gray-400)

#### Scenario: Corporate accent colors preserved
- **GIVEN** interactive elements and brand accents
- **WHEN** applying colors
- **THEN** primary orange SHALL remain #F97316
- **AND** hover orange SHALL remain #EA580C
- **AND** light orange SHALL remain #FDBA74
- **AND** these colors SHALL maintain WCAG AA contrast on dark backgrounds

### Requirement: Dark Theme Accessibility
The dark theme implementation SHALL meet WCAG 2.1 Level AA contrast requirements for all text and interactive elements.

#### Scenario: Text contrast validation
- **GIVEN** any text element on the page
- **WHEN** measuring contrast ratio
- **THEN** normal text SHALL have minimum 4.5:1 contrast ratio
- **AND** large text (18pt+ or 14pt+ bold) SHALL have minimum 3:1 contrast ratio
- **AND** interactive elements SHALL have minimum 3:1 contrast ratio

#### Scenario: Interactive element visibility
- **GIVEN** interactive elements (buttons, links, inputs)
- **WHEN** user hovers or focuses on element
- **THEN** element SHALL have clear visual feedback
- **AND** feedback SHALL maintain WCAG AA contrast requirements
- **AND** focus indicators SHALL be clearly visible

### Requirement: Dark Theme Visual Components
All visual components (navbar, hero, cards, forms) SHALL be adapted for optimal display in dark theme.

#### Scenario: Navbar in dark theme
- **GIVEN** the navigation bar component
- **WHEN** rendered in dark theme
- **THEN** navbar SHALL have dark background with glass effect
- **AND** navigation links SHALL be light colored (gray-100)
- **AND** hover states SHALL use orange accent (#F97316)
- **AND** mobile dropdown SHALL use dark background (gray-800)

#### Scenario: Hero section in dark theme
- **GIVEN** the hero landing section
- **WHEN** displayed on page load
- **THEN** hero SHALL have dark gradient background
- **AND** animated background elements SHALL be visible on dark
- **AND** text SHALL be white/light for maximum contrast
- **AND** call-to-action buttons SHALL use corporate orange

#### Scenario: Service cards in dark theme
- **GIVEN** service showcase cards
- **WHEN** displaying services section
- **THEN** cards SHALL have gray-800 background
- **AND** card borders SHALL be gray-700
- **AND** card text SHALL be light colored (gray-100, gray-300)
- **AND** hover effects SHALL be clearly visible
- **AND** shadows SHALL provide depth on dark background

#### Scenario: Forms in dark theme
- **GIVEN** contact or input forms
- **WHEN** user interacts with form fields
- **THEN** inputs SHALL have dark styling with light text
- **AND** placeholders SHALL be visible in gray-500
- **AND** labels SHALL be in gray-300
- **AND** validation states (error, success) SHALL be clearly visible
- **AND** submit button SHALL use corporate orange (#F97316)

### Requirement: Preserved Functionality in Dark Theme
All animations, interactions, and JavaScript functionality SHALL work identically in dark theme as they did in light theme.

#### Scenario: Animations function correctly
- **GIVEN** animated elements (hero floats, fade-ins, etc.)
- **WHEN** page loads and user interacts
- **THEN** all animations SHALL execute without visual glitches
- **AND** animation timing SHALL remain unchanged
- **AND** animated elements SHALL be clearly visible on dark backgrounds

#### Scenario: Interactive elements function correctly
- **GIVEN** any interactive component (buttons, forms, modals)
- **WHEN** user interacts with component
- **THEN** component SHALL function identically to light theme behavior
- **AND** no JavaScript errors SHALL occur
- **AND** state changes SHALL be visually clear

### Requirement: Responsive Dark Theme
The dark theme SHALL maintain visual quality and readability across all device sizes and screen types.

#### Scenario: Mobile display in dark theme
- **GIVEN** the page is viewed on mobile device (< 768px width)
- **WHEN** rendering all components
- **THEN** dark theme SHALL display correctly
- **AND** text SHALL remain readable
- **AND** interactive elements SHALL be easily tappable
- **AND** no layout breaking SHALL occur

#### Scenario: Desktop display in dark theme
- **GIVEN** the page is viewed on desktop (> 1024px width)
- **WHEN** rendering all components
- **THEN** dark theme SHALL display with full visual effects
- **AND** large text elements SHALL maintain proper hierarchy
- **AND** spacing and layout SHALL be optimal
- **AND** multi-column layouts SHALL display correctly
