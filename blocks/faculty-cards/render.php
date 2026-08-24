<?php
/**
 * Faculty Cards Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? 'Faculdades';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$faculties = $attributes['faculties'] ?? [];
$columns = $attributes['columns'] ?? 4;
$variant = $attributes['variant'] ?? 'default';
// Backward compat: this visual variant was a string attribute named "style" before the
// rename to "variant". WordPress now treats the reserved "style" as an object (spacing/
// typography supports) and strips the legacy string from $attributes, so recover it from
// the raw parsed block attributes. A string value unambiguously means legacy saved content.
$legacy_variant = isset($block->parsed_block['attrs']['style']) ? $block->parsed_block['attrs']['style'] : null;
if (is_string($legacy_variant) && $legacy_variant !== '') {
    $variant = $legacy_variant;
}
$show_acronym = $attributes['showAcronym'] ?? true;

$block_id = 'faculty-cards-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'faculty-cards-section style-' . esc_attr($variant),
));

// If no faculties defined, try to load from taxonomy
if (empty($faculties) && taxonomy_exists('faculdades')) {
    $terms = get_terms(array(
        'taxonomy' => 'faculdades',
        'hide_empty' => false,
    ));

    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            // Logo da faculdade (campo ACF na taxonomia: ID de anexo).
            $img_id = get_term_meta($term->term_id, 'course_taxonomy_image', true)
                ?: get_term_meta($term->term_id, 'image', true);
            // Salta termos sem logo (proposta, duplicados, etc.).
            if (empty($img_id)) {
                continue;
            }
            $img_url = is_numeric($img_id) ? wp_get_attachment_url($img_id) : $img_id;
            $faculties[] = array(
                'name' => $term->name,
                'acronym' => get_term_meta($term->term_id, 'acronym', true) ?: '',
                'image' => $img_url ?: '',
                'link' => get_term_link($term),
            );
        }
    }
}

if (empty($faculties)) {
    return;
}

$grid_class = 'faculty-cards-grid cols-' . esc_attr($columns);
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if ($section_title || $section_subtitle) : ?>
            <div class="section-header text-center">
                <?php if ($section_title) : ?>
                    <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>
                <?php if ($section_subtitle) : ?>
                    <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo $grid_class; ?>">
            <?php foreach ($faculties as $faculty) :
                $name = $faculty['name'] ?? '';
                $acronym = $faculty['acronym'] ?? '';
                $image = $faculty['image'] ?? '';
                $link = $faculty['link'] ?? '';
                $has_link = !empty($link);
                $tag = $has_link ? 'a' : 'div';
                $link_attr = $has_link ? ' href="' . esc_url($link) . '" aria-label="' . esc_attr($name) . '"' : '';
            ?>
                <<?php echo $tag; ?> class="faculty-card"<?php echo $link_attr; ?>>
                    <div class="faculty-card-inner">
                        <?php if ($image) : ?>
                            <div class="faculty-card-image" title="<?php echo esc_attr($name); ?>" style="background-image: url('<?php echo esc_url($image); ?>');">
                            </div>
                        <?php else : ?>
                            <div class="faculty-card-image faculty-card-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="40" height="40">
                                    <rect x="4" y="2" width="16" height="20" rx="2"/>
                                    <line x1="9" y1="6" x2="9" y2="6.01"/>
                                    <line x1="15" y1="6" x2="15" y2="6.01"/>
                                    <line x1="9" y1="10" x2="9" y2="10.01"/>
                                    <line x1="15" y1="10" x2="15" y2="10.01"/>
                                    <line x1="9" y1="14" x2="9" y2="14.01"/>
                                    <line x1="15" y1="14" x2="15" y2="14.01"/>
                                    <path d="M9 22v-4h6v4"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="faculty-card-overlay"></div>

                        <div class="faculty-card-content">
                            <?php if ($show_acronym && $acronym) : ?>
                                <span class="faculty-acronym"><?php echo esc_html($acronym); ?></span>
                            <?php endif; ?>
                            <?php if ($name) : ?>
                                <h3 class="faculty-name"><?php echo esc_html($name); ?></h3>
                            <?php endif; ?>
                            <?php if ($has_link) : ?>
                                <span class="faculty-link-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Faculty Cards Styles */
.faculty-cards-section {
    padding: var(--spacing-xxl, 4rem) 0;
}

.faculty-cards-grid {
    display: grid;
    gap: var(--spacing-lg, 2rem);
}

.faculty-cards-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
.faculty-cards-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
.faculty-cards-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }
.faculty-cards-grid.cols-5 { grid-template-columns: repeat(5, 1fr); }
.faculty-cards-grid.cols-6 { grid-template-columns: repeat(6, 1fr); }

.faculty-card {
    display: block;
    text-decoration: none;
    color: inherit;
}

.faculty-card-inner {
    position: relative;
    height: 280px;
    border-radius: var(--radius-lg, 12px);
    overflow: hidden;
    transition: transform 0.3s ease;
}

a.faculty-card:hover .faculty-card-inner {
    transform: scale(1.02);
}

.faculty-card-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    transition: transform 0.3s ease;
}

.faculty-card:hover .faculty-card-image {
    transform: scale(1.05);
}

.faculty-card-placeholder {
    background: var(--color-blue, #2B2E6F);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.5);
}

.faculty-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(17,17,17,0.9) 0%, rgba(17,17,17,0.3) 50%, transparent 100%);
}

.faculty-card-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: var(--spacing-lg, 2rem);
    color: var(--color-white, #fff);
}

.faculty-acronym {
    display: inline-block;
    font-family: var(--font-ui, 'Blinker', sans-serif);
    font-size: 0.6875rem;
    font-weight: var(--font-ui-weight, 900);
    text-transform: var(--ui-text-transform, uppercase);
    letter-spacing: 0.1em;
    background: var(--color-yellow, #FFF100);
    color: var(--color-ink, #111111);
    border: 2px solid var(--color-ink, #111111);
    padding: 4px 9px;
    border-radius: var(--radius-sm, 0);
    margin-bottom: var(--spacing-xs, 0.5rem);
}

.faculty-name {
    font-family: var(--font-ui, 'Blinker', sans-serif);
    font-size: 1.1875rem;
    font-weight: var(--font-ui-weight, 900);
    margin: 0;
    line-height: 1.25;
}

.faculty-link-icon {
    position: absolute;
    bottom: var(--spacing-lg, 2rem);
    right: var(--spacing-lg, 2rem);
    width: 38px;
    height: 38px;
    border-radius: 0;
    border: 2px solid var(--color-ink, #111111);
    box-shadow: 3px 3px 0 var(--color-ink, #111111);
    background: var(--color-yellow, #FFF100);
    color: var(--color-ink, #111111);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.faculty-card:hover .faculty-link-icon {
    opacity: 1;
    transform: translateX(0);
}

/* Style Variants */
.style-overlay .faculty-card-overlay {
    background: rgba(38,34,97,0.82);
}

.style-cards .faculty-card-inner {
    height: auto;
    border: var(--border-hard, 3px solid #111);
    box-shadow: var(--shadow-hard, 6px 6px 0 #111);
}

.style-cards .faculty-card-image {
    position: relative;
    height: 180px;
}

.style-cards .faculty-card-overlay {
    display: none;
}

.style-cards .faculty-card-content {
    position: relative;
    background: var(--color-panel, #ededed);
    color: var(--color-ink, #111111);
    border-top: 3px solid var(--color-ink, #111111);
    padding: var(--spacing-md, 1rem);
}

.style-cards .faculty-acronym,
.style-cards .faculty-link-icon {
    background: var(--color-yellow, #FFF100);
    color: var(--color-ink, #111111);
}

.style-minimal .faculty-card-inner {
    height: 200px;
}

.style-minimal .faculty-card-overlay {
    background: rgba(17,17,17,0.6);
}

/* Estilo "logos": mural de logos — cartão branco, logo contido e centrado */
.style-logos .faculty-card-inner {
    height: 150px;
    background: var(--color-white, #fff);
    border: var(--border-hard, 3px solid #111);
    box-shadow: var(--shadow-hard-sm, 4px 4px 0 #111);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.75rem;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.style-logos a.faculty-card:hover .faculty-card-inner {
    box-shadow: var(--shadow-lg, 0 8px 30px rgba(0,0,0,0.12));
    transform: translateY(-4px);
}

.style-logos .faculty-card-image {
    position: relative;
    top: auto;
    left: auto;
    right: auto;
    bottom: auto;
    width: 100%;
    height: 100%;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.style-logos .faculty-card:hover .faculty-card-image {
    transform: none;
}

.style-logos .faculty-card-overlay,
.style-logos .faculty-card-content {
    display: none;
}

/* Responsive */
@media (max-width: 1024px) {
    .faculty-cards-grid.cols-5,
    .faculty-cards-grid.cols-6 {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .faculty-cards-grid.cols-3,
    .faculty-cards-grid.cols-4,
    .faculty-cards-grid.cols-5,
    .faculty-cards-grid.cols-6 {
        grid-template-columns: repeat(2, 1fr);
    }

    .faculty-card-inner {
        height: 220px;
    }
}

@media (max-width: 576px) {
    .faculty-cards-grid.cols-2,
    .faculty-cards-grid.cols-3,
    .faculty-cards-grid.cols-4,
    .faculty-cards-grid.cols-5,
    .faculty-cards-grid.cols-6 {
        grid-template-columns: 1fr;
    }
}
</style>
