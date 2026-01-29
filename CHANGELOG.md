# Changelog

All notable changes to the Acesso U.Porto 2026 theme.

## [1.2.1] - 2026-01-29

### Added
- feat(templates): add Home Page template with pre-placed blocks
  - templates/template-home.php page template
  - Automatic default content for empty front pages
  - Full home page layout with all section blocks

- feat(patterns): add block patterns for Acesso U.Porto
  - "Home Page Completa" pattern with full layout
  - Individual section patterns (Hero, Statistics, Testimonials, CTA)
  - patterns/home-page.php with complete markup
  - Block pattern category "Acesso U.Porto" in inserter

- feat(front-page): auto-populate with default blocks
  - front-page.php shows default content if page is empty
  - Uses acesso_get_default_home_content() function
  - Renders all custom blocks via the_content filter

- feat(home): default home page sections (10 blocks)
  1. Hero - Full-screen with rotating words, gradient, CTA buttons
  2. Statistics - 5-column animated counters (Faculties, Students, etc.)
  3. Feature Cards - 4 cards (Excellence, International, Research, Community)
  4. Course Cards - Featured courses grid with filters
  5. Testimonials - Student testimonials carousel (3 students)
  6. Timeline - 3 application phases (Candidaturas, Colocações, Início)
  7. Video Section - Embedded video with poster
  8. Faculty Cards - 8 faculty cards with acronyms
  9. FAQ Accordion - 5 common questions with answers
  10. CTA - Final call-to-action with gradient background

### Changed
- refactor(functions): include block-patterns.php

## [1.2.0] - 2026-01-29

### Added
- feat(blocks): convert all remaining ACF blocks to native Gutenberg
  - Hero Section block with rotating text animation, gradient overlays, background images
  - Statistics block with animated counters, multiple grid layouts (2-5 columns), icon styles
  - Testimonials block with carousel/grid modes, autoplay, navigation dots
  - Timeline block with horizontal/vertical layouts, colored phase icons
  - CTA block with gradient/dark/light/image styles, dual buttons
  - Video Section block with YouTube/Vimeo support, poster images, play overlay
  - Faculty Cards block with image overlays, acronyms, hover effects

- feat(blocks): add new Feature Cards block
  - Customizable icon grid for university highlights
  - Multiple style variants: default, elevated, bordered, gradient, minimal
  - 2-6 column layouts with responsive breakpoints
  - 16 icon options (building, groups, science, library, globe, etc.)

- feat(blocks): add new FAQ Accordion block
  - Expandable Q&A items with smooth animations
  - Style variants: default, cards, minimal, bordered
  - Optional question numbering
  - Allow multiple or single item open modes

- feat(styles): comprehensive block styles in assets/css/blocks.css
  - UP.pt Acesso design system CSS variables (navy, gold, purple, pink)
  - Complete styling for all 12 Gutenberg blocks
  - Responsive breakpoints (1024px, 768px, 576px)
  - Animation keyframes (bounce, fadeIn, slideDown)

### Changed
- refactor(functions): register all blocks as native Gutenberg
  - Hero, Statistics, Testimonials, Feature Cards, Timeline
  - CTA, Video Section, FAQ Accordion, Faculty Cards
  - All blocks now work without ACF PRO dependency
  - Blocks appear under "Acesso U.Porto" category in inserter

- refactor(blocks): standardized block file structure
  - block.json for metadata and attributes
  - editor.js with InspectorControls for settings
  - render.php for server-side frontend rendering
  - editor.asset.php for dependencies

### Technical
- Each block includes:
  - Multiple style/layout variants configurable in editor
  - Full responsive design
  - Accessibility features (ARIA labels, keyboard navigation)
  - Inline JavaScript for interactivity (carousels, accordions, counters)

## [1.1.0] - 2026-01-28

### Added
- feat(blocks): add native Gutenberg Course Cards block
  - Grid layouts: 2/3/4 columns and carousel
  - Card styles: default, gradient, bordered, minimal, dark
  - Faculty filter buttons
  - Filter by type (all, destaque, novo)
  - Configurable course limit and CTA button

- feat(blocks): add native Gutenberg Course Detail block
  - Display comprehensive course information
  - Multiple display styles: full, header, stats, info, description
  - Works with current course or selected course
  - Shows all ACF fields: vagas, notas, provas, formula, etc.

- feat(blocks): add native Gutenberg Course Accordion block
  - Expandable course listings with accordion animation
  - Faculty filter buttons
  - Filter by destaque only option
  - Keyboard accessibility support

- feat(importer): integrate uporto-cursos-importer into theme
  - Add CSV import functionality at Cursos > Importar CSV
  - Support for new format (Licenciaturas_Mestrados_Cursos_2026.csv)
  - Support for legacy DGES format (up_dges_courses.csv)
  - Backup/restore functionality with JSON exports
  - Dry-run mode for testing imports
  - Options: skip, update, or archive existing courses

- feat(importer): add ACF field definitions for cursos CPT
  - Register all ACF fields programmatically
  - Fields: grau, info_extra, duracaoects, vagas, nota_ultimo, provas, etc.
  - Nested group fields for structured data

- feat(theme): add course-blocks.css stylesheet
  - Shared styles for all course blocks
  - Responsive grid layouts
  - Dark mode variant support
  - Editor placeholder styles

### Changed
- refactor(blocks): convert course blocks from ACF to native Gutenberg
  - Remove ACF PRO dependency for course blocks
  - Use block.json for block registration
  - Use register_block_type() instead of acf_register_block_type()
  - Add editor.js with InspectorControls for block settings

- refactor(functions): separate ACF and native block registration
  - Native blocks registered on 'init' hook
  - ACF blocks only registered if ACF PRO available
  - Course blocks work without ACF PRO installed

- fix(blocks): add accordion toggle JavaScript to course-accordion
  - Fix missing accordion expand/collapse functionality
  - Add keyboard navigation support (Enter/Space)
  - Close other items when opening new one

### Removed
- remove(blocks): delete old ACF-based course block templates
  - Remove course-accordion.php (replaced by render.php)
  - Remove course-cards.php (replaced by render.php)
  - Remove course-detail.php (replaced by render.php)

## [1.0.0] - 2026-01-28

### Added
- feat(theme): initial theme setup
  - Theme supports: title-tag, post-thumbnails, html5, custom-logo
  - Editor styles and block styles support
  - Responsive embeds and wide alignments

- feat(theme): add theme.json configuration
  - Custom color palette (purple, pink, dark, cyan, lavender, coral)
  - Gradient presets (purple-pink)
  - Typography settings with Barlow font family
  - Spacing scale and layout settings

- feat(theme): add CSS custom properties
  - Color variables matching site design
  - Typography variables (font-primary, font-display)
  - Spacing scale (xs to xxl)
  - Border radius and transition variables

- feat(blocks): add ACF blocks (require ACF PRO)
  - Hero Section with rotating text
  - Statistics counter section
  - Testimonials carousel
  - Timeline phases
  - Call to Action section
  - Faculty Cards grid
  - Video Section embed

- feat(cpt): register custom post types
  - Cursos CPT (fallback if plugin not active)
  - Testimonial CPT

- feat(taxonomy): register custom taxonomies
  - Faculdades taxonomy (fallback if plugin not active)

- feat(templates): add theme templates
  - header.php with navigation
  - footer.php with social links
  - front-page.php
  - page.php
  - single.php
  - single-cursos.php for course details
  - archive.php
  - archive-cursos.php with search/filters
  - 404.php
  - search.php
  - index.php

- feat(theme): add helper functions
  - acesso_get_icon() for SVG icons
  - acesso_get_social_links() for social media URLs
  - acesso_get_curso_display_data() for course data
  - acesso_get_featured_cursos() for featured courses
  - acesso_get_new_cursos() for new courses
  - acesso_get_cursos_by_faculty() for faculty filtering

- feat(navigation): add custom nav walker
  - Acesso_Nav_Walker class for menu styling
  - Support for active states

- feat(theme): add ACF options page
  - Theme Options for social links
  - Footer text configuration

- feat(assets): enqueue Google Fonts
  - Barlow (400, 500, 600, 700)
  - Barlow Semi Condensed (600, 700, 900)

### Security
- feat(importer): add backup directory protection
  - .htaccess to deny direct access
  - index.php silence file

---

## File Structure

```
acesso-uporto-2026/
├── assets/
│   ├── css/
│   │   ├── blocks.css          # Comprehensive block styles
│   │   └── editor.css
│   └── js/
│       └── main.js
├── blocks/
│   ├── course-accordion/       # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── course-cards/           # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── course-detail/          # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── cta/                    # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── faculty-cards/          # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── faq-accordion/          # Native Gutenberg block (NEW)
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── feature-cards/          # Native Gutenberg block (NEW)
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── hero/                   # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── statistics/             # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── testimonials/           # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── timeline/               # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   ├── video-section/          # Native Gutenberg block
│   │   ├── block.json
│   │   ├── editor.asset.php
│   │   ├── editor.js
│   │   └── render.php
│   └── course-blocks.css       # Course block specific styles
├── inc/
│   ├── acf-course-fields.php
│   ├── block-patterns.php      # Block patterns & default home content
│   ├── customizer.php
│   └── importer/
│       ├── acf-cursos-fields.php
│       ├── class-cursos-importer.php
│       └── backups/
├── patterns/
│   └── home-page.php           # Full home page block pattern
├── templates/
│   └── template-home.php       # Home Page template
├── 404.php
├── archive.php
├── archive-cursos.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── search.php
├── single.php
├── single-cursos.php
├── style.css
├── theme.json
├── README.md
└── CHANGELOG.md
```
