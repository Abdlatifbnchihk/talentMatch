## Why

The current TalentMatch UI uses default Laravel Breeze styling with minimal design consistency. As an internal HR tool, it needs a professional, polished aesthetic that inspires confidence — similar to commercial SaaS products like Lever or Greenhouse. The current views lack a unified design system, consistent spacing, and modern UI patterns.

## What Changes

- Redesign `layouts/app.blade.php` with sticky navbar, left sidebar navigation, flash banners, and footer
- Redesign `auth/login.blade.php` with full-screen split layout (branded left + form right)
- Redesign `auth/register.blade.php` with same split layout + password strength indicator
- Redesign `offers/index.blade.php` with LinkedIn-style cards, search/filter, and empty state
- Redesign `offers/create.blade.php` and `offers/edit.blade.php` with two-column form + live preview
- Redesign `offers/show.blade.php` with stats bar, sortable candidate table, and tab filters
- Redesign `candidates/create.blade.php` with offer context card and CV paste area
- Redesign `candidates/show.blade.php` with donut score ring, three-column analysis layout, and skeleton loading
- Redesign `chat/show.blade.php` with full-height two-panel layout (already done in previous change, minor adjustments)
- Apply global design system: Inter font, indigo-600 primary, slate palette, consistent border radius, transitions

## Capabilities

### New Capabilities
- `ui-design-system`: Global design tokens, Inter font, color palette, border radius, transitions, Tailwind CDN
- `layout-navigation`: Sticky navbar, left sidebar with icons, flash banners, footer
- `auth-views-redesign`: Split-screen login/register with branded left panel
- `offers-list-redesign`: LinkedIn-style offer cards with search, filters, empty state
- `offers-form-redesign`: Two-column form with live preview, tag input, stepper, radio cards
- `offers-detail-redesign`: Offer header, stats bar, sortable/filterable candidate table
- `candidates-form-redesign`: Offer context card, CV paste area with tips
- `candidates-detail-redesign`: Donut score ring, three-column analysis, skeleton loading

### Modified Capabilities
- `chat-ui-redesign`: Minor adjustments to match new design system (slate palette, consistent spacing)

## Impact

- **Files modified**: 9 Blade view files
- **Dependencies**: Inter font (Google Fonts CDN), Tailwind CSS (CDN in layout)
- **No backend changes**: Controllers, routes, models unchanged
- **No API changes**: Data flow unchanged
- **CSS**: All styling via Tailwind utility classes, no custom CSS except keyframe animations
