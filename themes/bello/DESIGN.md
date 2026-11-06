---
name: Marvens Shop
colors:
  surface: '#fff8f5'
  surface-dim: '#e9d7cb'
  surface-bright: '#fff8f5'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#fff1e9'
  surface-container: '#fdeade'
  surface-container-high: '#f7e5d9'
  surface-container-highest: '#f2dfd3'
  on-surface: '#231a13'
  on-surface-variant: '#554336'
  inverse-surface: '#392e26'
  inverse-on-surface: '#ffede3'
  outline: '#887364'
  outline-variant: '#dbc2b0'
  surface-tint: '#904d00'
  primary: '#8d4b00'
  on-primary: '#ffffff'
  primary-container: '#b15f00'
  on-primary-container: '#fffbff'
  inverse-primary: '#ffb77d'
  secondary: '#565e74'
  on-secondary: '#ffffff'
  secondary-container: '#dae2fd'
  on-secondary-container: '#5c647a'
  tertiary: '#006096'
  on-tertiary: '#ffffff'
  tertiary-container: '#007abd'
  on-tertiary-container: '#fdfcff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdcc3'
  primary-fixed-dim: '#ffb77d'
  on-primary-fixed: '#2f1500'
  on-primary-fixed-variant: '#6e3900'
  secondary-fixed: '#dae2fd'
  secondary-fixed-dim: '#bec6e0'
  on-secondary-fixed: '#131b2e'
  on-secondary-fixed-variant: '#3f465c'
  tertiary-fixed: '#cee5ff'
  tertiary-fixed-dim: '#96ccff'
  on-tertiary-fixed: '#001d32'
  on-tertiary-fixed-variant: '#004a75'
  background: '#F8FAFC'
  on-background: '#231a13'
  surface-variant: '#f2dfd3'
  text: '#0F172A'
  border: '#E2E8F0'
typography:
  headline-xl:
    fontFamily: Space Grotesk
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Space Grotesk
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Space Grotesk
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-sm:
    fontFamily: Space Grotesk
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
  gutter: 1.5rem
  margin: 2rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 3rem
---

## Brand & Style

This design system delivers a Swiss editorial approach tailored for high-end digital commerce. The identity bridges pristine legibility with trusted editorial commerce structure, projecting absolute reliability, clarity, and sophistication. 

The emotional response is one of calm assurance, intellectual curation, and effortless transactions. The design style relies on stark structural grids, generous whitespace, pristine typographic hierarchy, and a restrained chromatic palette that elevates the merchandised products above interface noise.

## Colors

The color system is rigorously restrained, prioritizing neutral architecture over decorative hues. The dominant background tone provides a cool, paper-like canvas (`#F8FAFC`), while deep slate (`#0F172A`) commands all typographic and structural ink hierarchy. 

The single chromatic accent is an amber-gold (`#D97706`), deployed exclusively for high-priority calls to action, active states, and deliberate focal points. Borders and structural dividers use a refined, low-contrast grey (`#E2E8F0`) to segment content without visual weight.

## Typography

Typography acts as the primary architectural element. `Space Grotesk` provides a geometric, authoritative voice for all headlines and display roles, utilizing tight tracking to achieve a modern editorial feel. `Inter` serves as the workhorse for body copy, product descriptions, and microcopy, engineered for immaculate legibility at small sizes. 

Hierarchy is strictly maintained through size, weight, and baseline grid alignment rather than color variation.

## Layout & Spacing

The layout model is built upon a strict mathematical grid system with explicit alignments and rigid vertical rhythm. Content is organized within a fluid container framework bounded by generous outer margins (`2rem` on desktop, scaling down to `1rem` on mobile) and consistent `1.5rem` gutters. 

Whitespace is treated as a structural material, separating editorial spreads, product grids, and checkout flows with mathematical predictability. Breakpoints occur at standard intervals (mobile: 0px–639px, tablet: 640px–1023px, desktop: 1024px+), where column counts dynamically shift from 2 to 4 to 12.

## Elevation & Depth

Depth is conveyed entirely through flat structural boundaries and subtle tonal layers rather than simulated drop shadows or ambient glows. 

The interface relies on low-contrast 1px outlines (`#E2E8F0`) to demarcate cards, navigation bars, and structural containers against the background canvas. Hover and active states are communicated through subtle background shifts or ink inversion, preserving the paper-like, Swiss editorial crispness.

## Shapes

The shape language reflects precision and engineered restraint, adhering strictly to a 2px to 4px border-radius scale (`roundedness`: `1`). 

Interactive elements, cards, and containers reject heavily rounded pills or organic curves in favor of crisp, micro-chamfered corners. This architectural sharpness reinforces the professional, publication-grade trustworthiness of the platform.

## Components

### Buttons
Primary actions utilize solid ink (`#0F172A`) or primary accent fills (`#D97706`) with sharp 2px-4px radii, utilizing `Space Grotesk` or `Inter` for bold, tracked-out label text. Secondary actions use ghost styles with a 1px solid border (`#E2E8F0`) and text matching the base ink color.

### Input Fields
Form controls feature a pristine white or background-tinted surface, bound by a 1px `#E2E8F0` border. Focus states transition the border instantly to the primary accent color without outer glows. Labels are always positioned externally for maximum scanning efficiency.

### Cards
Product and editorial cards use flat white surfaces bounded by 1px solid borders. Images sit flush within the top edge, while typographic metadata is cleanly aligned to an underlying baseline grid with strict padding tiers.

### Chips & Tags
Compact metadata labels and filters use understated neutral fills with 1px borders, adopting sharp corners and small-cap typography.

### Checkboxes & Radios
Custom inputs use crisp square or circular geometry with a 2px stroke width, swapping to solid primary fills upon selection.