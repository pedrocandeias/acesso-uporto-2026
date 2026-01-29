<?php
/**
 * Course Cards Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? '';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$layout = $attributes['layout'] ?? 'grid-3';
$card_style = $attributes['cardStyle'] ?? 'default';
$filter_type = $attributes['filterType'] ?? 'all';
$filter_faculty = $attributes['filterFaculty'] ?? 0;
$limit = $attributes['limit'] ?? 6;
$show_filters = $attributes['showFilters'] ?? false;
$show_cta = $attributes['showCta'] ?? true;
$cta_text = $attributes['ctaText'] ?? __('Ver Todos os Cursos', 'acesso-uporto');

$block_id = 'course-cards-' . uniqid();

// Build query args
$args = array(
    'post_type'      => 'cursos',
    'posts_per_page' => $limit,
    'orderby'        => 'title',
    'order'          => 'ASC',
);

// Filter by faculty
if ($filter_faculty) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'faculdades',
            'field'    => 'term_id',
            'terms'    => $filter_faculty,
        ),
    );
}

// Filter by type (destaque/novo)
if ($filter_type === 'destaque') {
    $args['meta_query'] = array(
        array(
            'key'     => 'destaque',
            'value'   => '1',
            'compare' => '=',
        ),
    );
} elseif ($filter_type === 'novo') {
    $args['meta_query'] = array(
        array(
            'key'     => 'novo',
            'value'   => '1',
            'compare' => '=',
        ),
    );
}

$query = new WP_Query($args);

// Get grid class based on layout
$grid_class = 'course-cards-grid';
switch ($layout) {
    case 'grid-2':
        $grid_class .= ' grid-2-cols';
        break;
    case 'grid-3':
        $grid_class .= ' grid-3-cols';
        break;
    case 'grid-4':
        $grid_class .= ' grid-4-cols';
        break;
    case 'carousel':
        $grid_class .= ' carousel-layout';
        break;
}

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'course-cards-section section style-' . esc_attr($card_style),
));
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

        <?php if ($show_filters) : ?>
            <?php
            $faculties = get_terms(array(
                'taxonomy'   => 'faculdades',
                'hide_empty' => true,
            ));
            ?>
            <?php if (!empty($faculties) && !is_wp_error($faculties)) : ?>
                <div class="course-cards-filters">
                    <button class="filter-btn active" data-filter="all">
                        <?php esc_html_e('Todos', 'acesso-uporto'); ?>
                    </button>
                    <?php foreach (array_slice($faculties, 0, 6) as $faculty) : ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr($faculty->slug); ?>">
                            <?php echo esc_html($faculty->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($query->have_posts()) : ?>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();
                    $faculdades = get_the_terms($post_id, 'faculdades');
                    $faculty_name = $faculdades && !is_wp_error($faculdades) ? $faculdades[0]->name : '';
                    $faculty_slug = $faculdades && !is_wp_error($faculdades) ? $faculdades[0]->slug : '';

                    // Get ACF fields if available, otherwise get post meta
                    if (function_exists('get_field')) {
                        $grau = get_field('grau', $post_id);
                        $duracao = get_field('duracaoects', $post_id);
                        $vagas = get_field('vagas', $post_id);
                        $nota = get_field('nota_do_ultimo_colocado', $post_id);
                        $destaque = get_field('destaque', $post_id);
                        $novo = get_field('novo', $post_id);
                        $certificacao = get_field('certificacao', $post_id);
                        $selo = get_field('selo', $post_id);
                    } else {
                        $grau = get_post_meta($post_id, 'grau', true);
                        $duracao = get_post_meta($post_id, 'duracaoects', true);
                        $vagas = get_post_meta($post_id, 'vagas', true);
                        $nota = get_post_meta($post_id, 'nota_do_ultimo_colocado', true);
                        $destaque = get_post_meta($post_id, 'destaque', true);
                        $novo = get_post_meta($post_id, 'novo', true);
                        $certificacao = get_post_meta($post_id, 'certificacao', true);
                        $selo = get_post_meta($post_id, 'selo', true);
                    }
                ?>
                    <article class="course-card" data-faculty="<?php echo esc_attr($faculty_slug); ?>">
                        <div class="course-card-inner">
                            <?php if ($destaque || $novo) : ?>
                                <div class="course-card-badges">
                                    <?php if ($destaque) : ?>
                                        <span class="badge badge-destaque"><?php esc_html_e('Destaque', 'acesso-uporto'); ?></span>
                                    <?php endif; ?>
                                    <?php if ($novo) : ?>
                                        <span class="badge badge-novo"><?php esc_html_e('Novo', 'acesso-uporto'); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="course-card-header">
                                <?php if ($faculty_name) : ?>
                                    <span class="course-card-faculty"><?php echo esc_html($faculty_name); ?></span>
                                <?php endif; ?>
                                <h3 class="course-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php if ($grau) : ?>
                                    <span class="course-card-grau"><?php echo esc_html($grau); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="course-card-meta">
                                <?php if ($duracao) : ?>
                                    <div class="course-card-meta-item">
                                        <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <span><?php echo esc_html($duracao); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (is_array($vagas) && !empty($vagas['fase_1'])) : ?>
                                    <div class="course-card-meta-item">
                                        <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        <span><?php echo esc_html($vagas['fase_1']); ?> <?php esc_html_e('vagas', 'acesso-uporto'); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (is_array($nota) && !empty($nota['notas']['fase_1'])) : ?>
                                    <div class="course-card-meta-item course-card-meta-highlight">
                                        <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        <span><?php esc_html_e('Última nota:', 'acesso-uporto'); ?> <strong><?php echo esc_html($nota['notas']['fase_1']); ?></strong></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($certificacao || $selo) : ?>
                                <div class="course-card-seals">
                                    <?php if ($certificacao) : ?>
                                        <img src="<?php echo esc_url($certificacao); ?>" alt="" class="course-card-seal">
                                    <?php endif; ?>
                                    <?php if ($selo) : ?>
                                        <img src="<?php echo esc_url($selo); ?>" alt="" class="course-card-seal">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="course-card-footer">
                                <a href="<?php the_permalink(); ?>" class="course-card-link">
                                    <?php esc_html_e('Ver Detalhes', 'acesso-uporto'); ?>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                        <polyline points="12 5 19 12 12 19"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>

            <?php if ($show_cta) : ?>
                <div class="course-cards-cta text-center">
                    <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>" class="btn btn-primary">
                        <?php echo esc_html($cta_text); ?>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p class="text-center no-courses"><?php esc_html_e('Nenhum curso encontrado.', 'acesso-uporto'); ?></p>
        <?php endif; ?>
    </div>
</section>

<script>
(function() {
    var container = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!container) return;

    var filterBtns = container.querySelectorAll('.filter-btn[data-filter]');
    var courseCards = container.querySelectorAll('.course-card');

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var filter = this.dataset.filter;

            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');

            courseCards.forEach(function(card) {
                if (filter === 'all' || card.dataset.faculty === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
})();
</script>
