# Landing Page Specification Delta

## MODIFIED Requirements

### Requirement: Color Palette
The landing page SHALL use corporate orange color palette while maintaining light theme.

**Previous**: Blue-based color scheme (cb-primary: #3d4f6d)
**Updated**: Orange-based corporate color scheme (cb-primary: #F97316)

#### Scenario: Primary branding colors
- **WHEN** displaying branded elements (buttons, accents, highlights)
- **THEN** the system SHALL use orange #F97316 as primary color
- **AND** the system SHALL use #EA580C for hover states
- **AND** the system SHALL use #FDBA74 for secondary accents

#### Scenario: Hero section gradient
- **WHEN** rendering hero section background
- **THEN** the system SHALL apply gradient using corporate orange tones
- **AND** the system SHALL maintain visual appeal and contrast

#### Scenario: Call-to-action buttons
- **WHEN** displaying CTA buttons
- **THEN** the system SHALL use .btn-primary-custom with corporate orange

### Requirement: Typography
The landing page SHALL use Inter font family loaded locally instead of Google Fonts.

**Previous**: Inter from Google Fonts CDN
**Updated**: Inter from local /shared/fonts/inter/

#### Scenario: Font loading
- **WHEN** the page loads
- **THEN** the system SHALL load Inter fonts from /shared/fonts/inter/
- **AND** the system SHALL NOT request fonts from fonts.googleapis.com

#### Scenario: Font weights
- **WHEN** styling text content
- **THEN** the system SHALL use Inter weights 300-800 available locally
- **AND** the system SHALL maintain existing weight assignments

### Requirement: Component Framework
The landing page SHALL continue using DaisyUI 4.4.19 with updated corporate configuration.

**Previous**: DaisyUI 4.4.19 with custom blue palette
**Updated**: DaisyUI 4.4.19 with corporate orange palette

#### Scenario: Navbar styling
- **WHEN** rendering navigation bar
- **THEN** the system SHALL use DaisyUI navbar components
- **AND** the system SHALL apply corporate colors to active states and hover effects

#### Scenario: Service cards
- **WHEN** displaying service offerings
- **THEN** the system SHALL use DaisyUI card components
- **AND** the system SHALL apply corporate orange for icons and accents

#### Scenario: Timeline component
- **WHEN** rendering project timeline
- **THEN** the system SHALL use corporate orange for active/completed steps
- **AND** the system SHALL maintain visual hierarchy

### Requirement: Tailwind Configuration
The landing page SHALL update Tailwind custom configuration with corporate colors.

**Previous Configuration**:
```javascript
colors: {
  'cb-primary': '#3d4f6d',
  'cb-secondary': '#2a3a52',
  'cb-accent': '#ffa600',
}
```

**Updated Configuration**:
```javascript
colors: {
  'cb-primary': '#F97316',
  'cb-secondary': '#EA580C',
  'cb-accent': '#F97316',
}
```

#### Scenario: Tailwind color utilities
- **WHEN** using Tailwind color classes (text-cb-primary, bg-cb-primary)
- **THEN** the system SHALL render with updated orange values
- **AND** the system SHALL maintain all existing color utility usage

## ADDED Requirements

### Requirement: Design System Alignment
The landing page SHALL align with corporate design system while maintaining light theme.

#### Scenario: Theme mode
- **WHEN** page loads
- **THEN** the system SHALL use data-theme="light" (not night)
- **AND** the system SHALL apply corporate orange palette to light theme

#### Scenario: Component consistency
- **WHEN** using shared components (buttons, cards)
- **THEN** the system SHALL follow design system patterns from /shared/design-system/
- **AND** the system SHALL adapt patterns for light theme as needed

### Requirement: Performance Optimization
The landing page SHALL optimize resource loading for better performance.

#### Scenario: Font loading performance
- **WHEN** page loads
- **THEN** the system SHALL load fonts locally without external requests
- **AND** the system SHALL use font-display: swap for non-blocking render

#### Scenario: Asset optimization
- **WHEN** page loads
- **THEN** the system SHALL preload critical fonts
- **AND** the system SHALL defer non-critical resources

## RETAINED Requirements

### Requirement: Animations
The landing page SHALL maintain existing animation library and patterns.

**Note**: Animatiss library is retained as-is for existing animations

#### Scenario: Entrance animations
- **WHEN** page sections become visible
- **THEN** the system SHALL maintain existing Animatiss animations (fadeIn, zoomIn, fadeInUp)
- **AND** the system SHALL apply to same elements as before

#### Scenario: Floating elements
- **WHEN** background decorative elements are displayed
- **THEN** the system SHALL maintain custom float-animation CSS
- **AND** the system SHALL apply corporate orange colors to animated elements

### Requirement: Responsive Behavior
The landing page SHALL maintain existing responsive behavior patterns.

#### Scenario: Mobile navigation
- **WHEN** viewed on mobile (<1024px)
- **THEN** the system SHALL display hamburger menu
- **AND** the system SHALL maintain all navigation functionality

#### Scenario: Layout adaptation
- **WHEN** viewport size changes
- **THEN** the system SHALL adapt layout using existing breakpoints
- **AND** the system SHALL maintain content hierarchy
