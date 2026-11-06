---
name: Swiss Editorial Commerce
colors:
  surface: '#FFFFFF'
  surface-dim: '#dcd9db'
  surface-bright: '#fcf8fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f6f3f5'
  surface-container: '#f0edef'
  surface-container-high: '#eae7e9'
  surface-container-highest: '#e4e2e4'
  on-surface: '#1b1b1d'
  on-surface-variant: '#45464d'
  inverse-surface: '#303032'
  inverse-on-surface: '#f3f0f2'
  outline: '#76777d'
  outline-variant: '#c6c6cd'
  surface-tint: '#565e74'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#131b2e'
  on-primary-container: '#7c839b'
  inverse-primary: '#bec6e0'
  secondary: '#904d00'
  on-secondary: '#ffffff'
  secondary-container: '#fe932c'
  on-secondary-container: '#663500'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#271901'
  on-tertiary-container: '#98805d'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2fd'
  primary-fixed-dim: '#bec6e0'
  on-primary-fixed: '#131b2e'
  on-primary-fixed-variant: '#3f465c'
  secondary-fixed: '#ffdcc3'
  secondary-fixed-dim: '#ffb77d'
  on-secondary-fixed: '#2f1500'
  on-secondary-fixed-variant: '#6e3900'
  tertiary-fixed: '#fcdeb5'
  tertiary-fixed-dim: '#dec29a'
  on-tertiary-fixed: '#271901'
  on-tertiary-fixed-variant: '#574425'
  background: '#F8FAFC'
  on-background: '#1b1b1d'
  surface-variant: '#e4e2e4'
  border: '#E2E8F0'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 44px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-sm:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 24px
  margin: 32px
  space-xs: 4px
  space-sm: 8px
  space-md: 16px
  space-lg: 24px
  space-xl: 48px
---

## Brand & Style

This design system embodies a Swiss Editorial Commerce aesthetic, characterized by rigorous typographic hierarchy, high functional clarity, and restrained ornamentation. The target audience—discerning shoppers and digital natives valuing content-first experiences—will experience a calm, authoritative, and frictionless environment. 

The emotional response is one of precision, reliability, and sophisticated curation. We utilize a minimalism-inspired framework rooted in strict structural grids, generous whitespace, and purposeful contrast.

## Colors

The color palette is deliberately restrained to let photography and editorial content take precedence. The foundation relies on a crisp background (`#F8FAFC`) paired with pure white surfaces. 

Typography and primary structural elements use deep ink (`#0F172A`), ensuring optimal contrast and readability. The primary accent (`#D97706`) is reserved strictly for high-priority interactive elements, calls to action, and focal conversion points.

## Typography

The typographic system relies exclusively on Inter, delivering a systematic, utilitarian, and exceptionally legible corporate ecommerce aesthetic. Scale is strictly modular, maintaining precise mathematical proportions between levels. 

For viewports below 768px, scale down display sizes (`headline-xl` and `headline-lg`) to prevent awkward line wrapping while preserving editorial impact.

## Layout & Spacing

A strict mathematical grid governs the layout framework, utilizing a fluid 12-column grid system paired with consistent structural margins. Alignment is absolute, reinforcing the editorial rhythm. 

Spacing scales exponentially to maintain whitespace discipline across breakpoints. On mobile devices, outer margins collapse to 16px, while desktop viewports expand to 32px or greater to emphasize content containers.

## Elevation & Depth

Depth is conveyed through a low-contrast outline technique rather than heavy drop shadows. Surfaces rely on structural crispness: flat white containers are separated from the light background using a delicate 1px solid border (`#E2E8F0`). 

This approach maintains a clean, paper-like editorial feel without unnecessary visual noise.

## Shapes

The shape language employs minimal corner radiuses between 2px and 4px. This introduces very slight softening to containers, buttons, and input fields while preserving a precise, architectural silhouette. Pill shapes and heavy roundness are strictly avoided.

## Components

### Buttons
Primary buttons feature the accent color (`#D97706`) with white text, a minimum height of 44px, and subtle 2px–4px corner rounding. Secondary actions use outlined variants with a 1px border matching the text color and a transparent background.

### Cards
Product and content cards utilize a pure white surface against the `#F8FAFC` background, framed by a micro-border of 1px solid `#E2E8F0` with no drop shadows.

### Input Fields
Form inputs are spacious, featuring visible top-aligned labels, a 1px solid border, a 2px–4px radius, and clear contextual error messaging placed directly below the field.

### Lists & Dividers
Lists rely on hairline horizontal rules (`#E2E8F0`) to separate items cleanly without cluttering the interface.

### Checkboxes & Radios
Custom inputs maintain sharp, square geometry (2px radius for checkboxes) with high-contrast active states in the primary ink color.