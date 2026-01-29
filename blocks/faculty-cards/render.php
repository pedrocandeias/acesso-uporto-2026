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
$style = $attributes['style'] ?? 'default';
$show_acronym = $attributes['showAcronym'] ?? true;

$block_id = 'faculty-cards-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'faculty-cards-section style-' . esc_attr($style),
));

// If no faculties defined, try to load from taxonomy
if (empty($faculties) && taxonomy_exists('faculdades')) {
    $terms = get_terms(array(
        'taxonomy' => 'faculdades',
        'hide_empty' => false,
    ));

    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $faculties[] = array(
                'name' => $term->name,
                'acronym' => get_term_meta($term->term_id, 'acronym', true) ?: '',
                'image' => get_term_meta($term->term_id, 'image', true) ?: '',
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
                $link_attr = $has_link ? ' href="' . esc_url($link) . '"' : '';
            ?>
                <<?php echo $tag; ?> class="faculty-card"<?php echo $link_attr; ?>>
                    <div class="faculty-card-inner">
                        <?php if ($image) : ?>
                            <div class="faculty-card-image" style="background-image: url('<?php echo esc_url($image); ?>');">
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
    background: var(--gradient-primary, linear-gradient(135deg, #572ddf 0%, #da2489 100%));
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
    background: linear-gradient(to top, rgba(6,2,33,0.9) 0%, rgba(6,2,33,0.3) 50%, transparent 100%);
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
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    background: rgba(255,255,255,0.2);
    padding: 4px 10px;
    border-radius: var(--radius-full, 50px);
    margin-bottom: var(--spacing-xs, 0.5rem);
}

.faculty-name {
    font-family: var(--font-condensed, 'Barlow Semi Condensed', sans-serif);
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
}

.faculty-link-icon {
    position: absolute;
    bottom: var(--spacing-lg, 2rem);
    right: var(--spacing-lg, 2rem);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-white, #fff);
    color: var(--color-purple, #572ddf);
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
    background: linear-gradient(135deg, rgba(87,45,223,0.8) 0%, rgba(218,36,137,0.8) 100%);
}

.style-cards .faculty-card-inner {
    height: auto;
    box-shadow: var(--shadow-md, 0 4px 20px rgba(0,0,0,0.1));
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
    background: var(--color-white, #fff);
    color: var(--color-dark, #060221);
    padding: var(--spacing-md, 1rem);
}

.style-cards .faculty-acronym {
    background: var(--gradient-primary, linear-gradient(135deg, #572ddf 0%, #da2489 100%));
    color: var(--color-white, #fff);
}

.style-cards .faculty-link-icon {
    background: var(--gradient-primary, linear-gradient(135deg, #572ddf 0%, #da2489 100%));
    color: var(--color-white, #fff);
}

.style-minimal .faculty-card-inner {
    height: 200px;
}

.style-minimal .faculty-card-overlay {
    background: rgba(6,2,33,0.6);
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
