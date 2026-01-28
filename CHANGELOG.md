# Changelog

All notable changes to the Acesso U.Porto 2026 theme.

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
│   │   ├── blocks.css
│   │   └── editor.css
│   └── js/
│       └── main.js
├── blocks/
│   ├── course-accordion/
│   │   ├── block.json
│   │   ├── editor.js
│   │   └── render.php
│   ├── course-cards/
│   │   ├── block.json
│   │   ├── editor.js
│   │   └── render.php
│   ├── course-detail/
│   │   ├── block.json
│   │   ├── editor.js
│   │   └── render.php
│   ├── course-blocks.css
│   ├── cta/
│   ├── faculty-cards/
│   ├── hero/
│   ├── statistics/
│   ├── testimonials/
│   ├── timeline/
│   └── video-section/
├── inc/
│   ├── acf-course-fields.php
│   └── importer/
│       ├── acf-cursos-fields.php
│       ├── class-cursos-importer.php
│       ├── backups/
│       ├── Licenciaturas_Mestrados_Cursos_2026.csv
│       └── up_dges_courses.csv
├── templates/
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
└── CHANGELOG.md
```
