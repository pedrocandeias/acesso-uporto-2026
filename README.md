# Acesso U.Porto 2026

A modern WordPress theme for the University of Porto enrollment portal, built with Gutenberg blocks and designed for the 2026 academic year.

![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue?logo=wordpress)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-purple?logo=php)
![License](https://img.shields.io/badge/License-GPL--2.0-green)

## Features

- **Native Gutenberg Blocks** - Course blocks work without ACF PRO
- **Integrated CSV Importer** - Import courses directly from CSV files
- **Responsive Design** - Mobile-first approach with modern CSS
- **Accessibility Ready** - WCAG compliant with keyboard navigation
- **Portuguese (PT) Language** - Full translation support

## Requirements

- WordPress 6.0 or higher
- PHP 8.0 or higher
- ACF (Free) for course data fields
- ACF PRO (Optional) for additional theme blocks

## Installation

1. Download or clone this repository:
   ```bash
   git clone https://github.com/uporto/acesso-uporto-2026.git
   ```

2. Move the theme folder to your WordPress themes directory:
   ```bash
   mv acesso-uporto-2026 /path/to/wordpress/wp-content/themes/
   ```

3. Activate the theme in WordPress Admin > Appearance > Themes

4. Install and activate [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) plugin

5. Import courses via Cursos > Importar CSV

## Blocks

### Native Gutenberg Blocks (No ACF PRO Required)

| Block | Description |
|-------|-------------|
| **Course Accordion** | Expandable course listings with faculty filters |
| **Course Cards** | Grid/carousel display with multiple style options |
| **Course Detail** | Comprehensive course information display |

### ACF PRO Blocks (Optional)

| Block | Description |
|-------|-------------|
| **Hero Section** | Full-width hero with rotating text animation |
| **Statistics** | Animated counter statistics |
| **Testimonials** | Student testimonials carousel |
| **Timeline** | Application phases timeline |
| **Call to Action** | CTA sections with gradient backgrounds |
| **Faculty Cards** | Faculty grid with images |
| **Video Section** | YouTube/Vimeo embed sections |

## Course Blocks Usage

### Course Cards

Display courses in a customizable card grid:

```
Settings:
- Layout: 2/3/4 columns or carousel
- Style: Default, Gradient, Bordered, Minimal, Dark
- Filter: All courses, Featured only, New only
- Faculty filter buttons
- Configurable limit and CTA
```

### Course Accordion

Expandable list with detailed course information:

```
Settings:
- Section title
- Faculty filter buttons
- Featured courses only toggle
- Course limit
```

### Course Detail

Show comprehensive information for a single course:

```
Settings:
- Source: Current course or select specific
- Display: Full, Header, Stats, Info, or Description only
```

## CSV Import

The theme includes an integrated CSV importer accessible at **Cursos > Importar CSV**.

### Supported Formats

1. **New Format** (`Licenciaturas_Mestrados_Cursos_2026.csv`)
   - Columns: Curso, Faculdade, Grau, Duração / ETCS, vagas_*, nota_do_ultimo_colocado_*, etc.

2. **Legacy DGES Format** (`up_dges_courses.csv`)
   - Columns: curso, unidade_organica, etc.

### Import Options

- **Skip existing** - Only create new courses
- **Update existing** - Update courses by title match
- **Archive all** - Set all existing to draft, then import

### Backup & Restore

- Create JSON backups before importing
- Download backups for external storage
- Restore from any saved backup
- Upload previously downloaded backups

## Theme Structure

```
acesso-uporto-2026/
├── assets/
│   ├── css/
│   └── js/
├── blocks/
│   ├── course-accordion/
│   ├── course-cards/
│   ├── course-detail/
│   ├── hero/
│   ├── statistics/
│   └── ...
├── inc/
│   ├── acf-course-fields.php
│   └── importer/
│       ├── class-cursos-importer.php
│       └── backups/
├── functions.php
├── style.css
├── theme.json
└── CHANGELOG.md
```

## Customization

### Colors

The theme uses CSS custom properties defined in `style.css`:

```css
:root {
    --color-purple: #572ddf;
    --color-pink: #da2489;
    --color-dark: #060221;
    --color-cyan: #00d084;
    --color-lavender: #8887e2;
    --color-coral: #ff6b6b;
}
```

### Typography

Primary fonts loaded from Google Fonts:
- **Barlow** - Body text (400, 500, 600, 700)
- **Barlow Semi Condensed** - Headings (600, 700, 900)

### Block Styles

Course block styles can be customized in `blocks/course-blocks.css`.

## Development

### Prerequisites

- Node.js 18+ (for build tools, if extending)
- Composer (optional, for PHP dependencies)
- Local WordPress environment (DDEV, Local, etc.)

### Local Development

```bash
# Clone the repository
git clone https://github.com/uporto/acesso-uporto-2026.git

# Navigate to theme directory
cd acesso-uporto-2026

# If using DDEV
ddev start
ddev launch
```

### Code Standards

- PHP: WordPress Coding Standards
- JavaScript: ES6+ with WordPress conventions
- CSS: BEM methodology with CSS custom properties

## Hooks & Filters

### Actions

```php
// After course import
do_action('acesso_after_course_import', $post_id, $data);

// Before backup restore
do_action('acesso_before_backup_restore', $backup_file);
```

### Filters

```php
// Modify course query args
apply_filters('acesso_course_query_args', $args);

// Customize course card output
apply_filters('acesso_course_card_data', $course_data, $post_id);
```

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit changes: `git commit -m 'feat: add my feature'`
4. Push to branch: `git push origin feature/my-feature`
5. Open a Pull Request

### Commit Convention

We use [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` New features
- `fix:` Bug fixes
- `docs:` Documentation changes
- `style:` Code style changes (formatting)
- `refactor:` Code refactoring
- `test:` Adding tests
- `chore:` Maintenance tasks

## License

This theme is licensed under the [GPL-2.0 License](https://www.gnu.org/licenses/gpl-2.0.html).

## Credits

- **Design**: Based on [acesso.uporto.pt](https://acesso.uporto.pt)
- **Development**: University of Porto Web Team
- **Icons**: Custom SVG icons
- **Fonts**: [Google Fonts - Barlow](https://fonts.google.com/specimen/Barlow)

## Support

For issues and feature requests, please use the [GitHub Issues](https://github.com/uporto/acesso-uporto-2026/issues) page.

---

Made with ❤️ for Universidade do Porto
