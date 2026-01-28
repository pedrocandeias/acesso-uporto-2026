<?php
/**
 * Course Accordion Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? __('Cursos', 'acesso-uporto');
$show_filters = $attributes['showFilters'] ?? true;
$filter_faculty = $attributes['filterFaculty'] ?? 0;
$show_destaque_only = $attributes['showDestaqueOnly'] ?? false;
$limit = $attributes['limit'] ?? 10;

$block_id = 'courses-' . uniqid();

// Build query args
$args = array(
    'post_type'      => 'cursos',
    'posts_per_page' => $limit,
    'orderby'        => 'title',
    'order'          => 'ASC',
);

if ($filter_faculty) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'faculdades',
            'field'    => 'term_id',
            'terms'    => $filter_faculty,
        ),
    );
}

if ($show_destaque_only) {
    $args['meta_query'] = array(
        array(
            'key'     => 'destaque',
            'value'   => '1',
            'compare' => '=',
        ),
    );
}

$query = new WP_Query($args);
$courses = array();

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $faculdades = get_the_terms($post_id, 'faculdades');

        // Get ACF fields if available, otherwise get post meta
        if (function_exists('get_field')) {
            $grau = get_field('grau', $post_id);
            $duracao = get_field('duracaoects', $post_id);
            $vagas = get_field('vagas', $post_id);
            $nota = get_field('nota_do_ultimo_colocado', $post_id);
            $provas = get_field('provas_de_ingresso', $post_id);
            $destaque = get_field('destaque', $post_id);
            $novo = get_field('novo', $post_id);
        } else {
            $grau = get_post_meta($post_id, 'grau', true);
            $duracao = get_post_meta($post_id, 'duracaoects', true);
            $vagas = get_post_meta($post_id, 'vagas', true);
            $nota = get_post_meta($post_id, 'nota_do_ultimo_colocado', true);
            $provas = get_post_meta($post_id, 'provas_de_ingresso', true);
            $destaque = get_post_meta($post_id, 'destaque', true);
            $novo = get_post_meta($post_id, 'novo', true);
        }

        $courses[] = array(
            'id'       => $post_id,
            'name'     => get_the_title(),
            'faculty'  => $faculdades && !is_wp_error($faculdades) ? $faculdades[0]->name : '',
            'faculty_slug' => $faculdades && !is_wp_error($faculdades) ? $faculdades[0]->slug : '',
            'grau'     => $grau,
            'duracao'  => $duracao,
            'vagas'    => $vagas,
            'nota'     => $nota,
            'provas'   => $provas,
            'destaque' => $destaque,
            'novo'     => $novo,
            'link'     => get_permalink(),
        );
    }
    wp_reset_postdata();
}

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'courses-section section',
));
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center mb-4"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <?php if ($show_filters) : ?>
            <?php
            $faculties = get_terms(array(
                'taxonomy'   => 'faculdades',
                'hide_empty' => true,
            ));
            ?>
            <?php if (!empty($faculties) && !is_wp_error($faculties)) : ?>
                <div class="courses-filters">
                    <button class="filter-btn active" data-filter="all">
                        <?php esc_html_e('Todos', 'acesso-uporto'); ?>
                    </button>
                    <?php foreach (array_slice($faculties, 0, 8) as $faculty) : ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr($faculty->slug); ?>">
                            <?php echo esc_html($faculty->name); ?>
                        </button>
                    <?php endforeach; ?>
                    <?php if (count($faculties) > 8) : ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>" class="filter-btn filter-more">
                            <?php esc_html_e('Ver Todos...', 'acesso-uporto'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($courses)) : ?>
            <div class="course-accordion">
                <?php foreach ($courses as $index => $course) : ?>
                    <div class="course-item" data-index="<?php echo esc_attr($index); ?>" data-faculty="<?php echo esc_attr($course['faculty_slug']); ?>">
                        <div class="course-header" role="button" tabindex="0" aria-expanded="false">
                            <div class="course-header-content">
                                <?php if (!empty($course['destaque']) || !empty($course['novo'])) : ?>
                                    <div class="course-badges">
                                        <?php if (!empty($course['destaque'])) : ?>
                                            <span class="badge badge-destaque"><?php esc_html_e('Destaque', 'acesso-uporto'); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($course['novo'])) : ?>
                                            <span class="badge badge-novo"><?php esc_html_e('Novo', 'acesso-uporto'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="course-name"><?php echo esc_html($course['name']); ?></h3>
                                <div class="course-header-meta">
                                    <span class="course-faculty"><?php echo esc_html($course['faculty']); ?></span>
                                    <?php if (!empty($course['grau'])) : ?>
                                        <span class="course-grau"><?php echo esc_html($course['grau']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="course-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                            </div>
                        </div>
                        <div class="course-content">
                            <div class="course-meta">
                                <?php if (!empty($course['duracao'])) : ?>
                                    <div class="course-meta-item">
                                        <span class="course-meta-label"><?php esc_html_e('Duração / ECTS', 'acesso-uporto'); ?></span>
                                        <span class="course-meta-value"><?php echo esc_html($course['duracao']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (is_array($course['vagas']) && !empty($course['vagas']['fase_1'])) : ?>
                                    <div class="course-meta-item">
                                        <span class="course-meta-label">
                                            <?php esc_html_e('Vagas', 'acesso-uporto'); ?>
                                            <?php if (!empty($course['vagas']['ano_das_vagas'])) : ?>
                                                (<?php echo esc_html($course['vagas']['ano_das_vagas']); ?>)
                                            <?php endif; ?>
                                        </span>
                                        <span class="course-meta-value"><?php echo esc_html($course['vagas']['fase_1']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (is_array($course['nota']) && !empty($course['nota']['notas']['fase_1'])) : ?>
                                    <div class="course-meta-item">
                                        <span class="course-meta-label">
                                            <?php esc_html_e('Nota Último Colocado', 'acesso-uporto'); ?>
                                            <?php if (!empty($course['nota']['ano_ultimo_classificado'])) : ?>
                                                (<?php echo esc_html($course['nota']['ano_ultimo_classificado']); ?>)
                                            <?php endif; ?>
                                        </span>
                                        <span class="course-meta-value course-meta-highlight"><?php echo esc_html($course['nota']['notas']['fase_1']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (is_array($course['provas']) && !empty($course['provas']['provas'])) : ?>
                                    <div class="course-meta-item course-meta-full">
                                        <span class="course-meta-label">
                                            <?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?>
                                            <?php if (!empty($course['provas']['ano_das_provas'])) : ?>
                                                <?php echo esc_html($course['provas']['ano_das_provas']); ?>
                                            <?php endif; ?>
                                        </span>
                                        <?php if (!empty($course['provas']['expressao'])) : ?>
                                            <span class="course-meta-subtext"><?php echo esc_html($course['provas']['expressao']); ?></span>
                                        <?php endif; ?>
                                        <span class="course-meta-value"><?php echo esc_html($course['provas']['provas']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($course['link'])) : ?>
                                <a href="<?php echo esc_url($course['link']); ?>" class="btn btn-pink">
                                    <?php esc_html_e('Ver Curso', 'acesso-uporto'); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="courses-cta text-center mt-4">
                <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>" class="btn btn-secondary">
                    <?php esc_html_e('Ver Todos os Cursos', 'acesso-uporto'); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        <?php else : ?>
            <p class="text-center"><?php esc_html_e('Nenhum curso disponível.', 'acesso-uporto'); ?></p>
        <?php endif; ?>
    </div>
</section>

<script>
(function() {
    var container = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!container) return;

    // Accordion functionality
    var headers = container.querySelectorAll('.course-header');
    headers.forEach(function(header) {
        header.addEventListener('click', function() {
            var item = this.closest('.course-item');
            var isActive = item.classList.contains('active');

            container.querySelectorAll('.course-item.active').forEach(function(activeItem) {
                if (activeItem !== item) {
                    activeItem.classList.remove('active');
                    activeItem.querySelector('.course-header').setAttribute('aria-expanded', 'false');
                }
            });

            item.classList.toggle('active');
            this.setAttribute('aria-expanded', !isActive);
        });

        header.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });

    // Filter functionality
    var filterBtns = container.querySelectorAll('.filter-btn[data-filter]');
    var courseItems = container.querySelectorAll('.course-item');

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var filter = this.dataset.filter;

            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');

            courseItems.forEach(function(item) {
                if (filter === 'all' || item.dataset.faculty === filter) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('active');
                }
            });
        });
    });
})();
</script>
