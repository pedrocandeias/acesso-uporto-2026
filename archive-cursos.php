<?php
/**
 * The template for displaying cursos archive
 * Integrates with uporto-cursos-importer plugin
 *
 * @package AcessoUPorto
 */

get_header();

// Get filter parameters
$filter_faculty = isset($_GET['faculdade']) ? sanitize_text_field($_GET['faculdade']) : '';
$filter_grau = isset($_GET['grau']) ? sanitize_text_field($_GET['grau']) : '';
$search_query = isset($_GET['curso']) ? sanitize_text_field($_GET['curso']) : '';
?>

<main id="main" class="site-main cursos-archive">
    <header class="cursos-header">
        <div class="container">
            <h1 class="page-title"><?php esc_html_e('Cursos', 'acesso-uporto'); ?></h1>
            <p class="page-description"><?php esc_html_e('Descobre todos os cursos disponíveis na Universidade do Porto.', 'acesso-uporto'); ?></p>
        </div>
    </header>

    <div class="container section">
        <!-- Filters -->
        <div class="cursos-filters-bar">
            <form class="cursos-search-form" method="get" action="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>">
                <div class="search-input-wrapper">
                    <input type="text"
                           name="curso"
                           placeholder="<?php esc_attr_e('Pesquisar curso...', 'acesso-uporto'); ?>"
                           value="<?php echo esc_attr($search_query); ?>"
                           class="cursos-search-input">
                    <button type="submit" class="cursos-search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                </div>

                <div class="filter-dropdowns">
                    <?php
                    // Get faculties
                    $faculties = get_terms(array(
                        'taxonomy'   => 'faculdades',
                        'hide_empty' => true,
                    ));
                    ?>
                    <?php if (!empty($faculties) && !is_wp_error($faculties)) : ?>
                        <select name="faculdade" class="filter-select">
                            <option value=""><?php esc_html_e('Todas as Faculdades', 'acesso-uporto'); ?></option>
                            <?php foreach ($faculties as $faculty) : ?>
                                <option value="<?php echo esc_attr($faculty->slug); ?>" <?php selected($filter_faculty, $faculty->slug); ?>>
                                    <?php echo esc_html($faculty->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <select name="grau" class="filter-select">
                        <option value=""><?php esc_html_e('Todos os Graus', 'acesso-uporto'); ?></option>
                        <option value="licenciatura" <?php selected($filter_grau, 'licenciatura'); ?>><?php esc_html_e('Licenciatura', 'acesso-uporto'); ?></option>
                        <option value="mestrado" <?php selected($filter_grau, 'mestrado'); ?>><?php esc_html_e('Mestrado Integrado', 'acesso-uporto'); ?></option>
                    </select>

                    <button type="submit" class="btn btn-primary"><?php esc_html_e('Filtrar', 'acesso-uporto'); ?></button>

                    <?php if ($filter_faculty || $filter_grau || $search_query) : ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>" class="btn btn-secondary">
                            <?php esc_html_e('Limpar', 'acesso-uporto'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <?php
        // Build query args
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'cursos',
            'posts_per_page' => 20,
            'paged'          => $paged,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );

        // Search filter
        if ($search_query) {
            $args['s'] = $search_query;
        }

        // Faculty filter
        if ($filter_faculty) {
            $args['tax_query'][] = array(
                'taxonomy' => 'faculdades',
                'field'    => 'slug',
                'terms'    => $filter_faculty,
            );
        }

        // Grau filter (ACF meta query)
        if ($filter_grau) {
            $grau_value = $filter_grau === 'licenciatura' ? 'Licenciatura' : 'Mestrado';
            $args['meta_query'][] = array(
                'key'     => 'grau',
                'value'   => $grau_value,
                'compare' => 'LIKE',
            );
        }

        $cursos_query = new WP_Query($args);
        ?>

        <?php if ($cursos_query->have_posts()) : ?>
            <p class="results-count">
                <?php
                printf(
                    esc_html(_n('%d curso encontrado', '%d cursos encontrados', $cursos_query->found_posts, 'acesso-uporto')),
                    $cursos_query->found_posts
                );
                ?>
            </p>

            <div class="course-accordion">
                <?php while ($cursos_query->have_posts()) : $cursos_query->the_post();
                    $faculdades = get_the_terms(get_the_ID(), 'faculdades');
                    $faculdade_names = $faculdades ? wp_list_pluck($faculdades, 'name') : array();

                    // Get ACF fields
                    $grau = get_field('grau');
                    $duracao_ects = get_field('duracaoects');
                    $vagas = get_field('vagas');
                    $nota_ultimo = get_field('nota_do_ultimo_colocado');
                    $provas = get_field('provas_de_ingresso');
                    $classificacao = get_field('classificacao_minima');
                    $destaque = get_field('destaque');
                    $novo = get_field('novo');
                ?>
                    <div class="course-item" data-course-id="<?php the_ID(); ?>">
                        <div class="course-header" role="button" tabindex="0" aria-expanded="false">
                            <div class="course-header-content">
                                <div class="course-badges">
                                    <?php if ($destaque) : ?>
                                        <span class="badge badge-destaque"><?php esc_html_e('Destaque', 'acesso-uporto'); ?></span>
                                    <?php endif; ?>
                                    <?php if ($novo) : ?>
                                        <span class="badge badge-novo"><?php esc_html_e('Novo', 'acesso-uporto'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="course-name"><?php the_title(); ?></h3>
                                <div class="course-header-meta">
                                    <span class="course-faculty"><?php echo esc_html(implode(', ', $faculdade_names)); ?></span>
                                    <?php if ($grau) : ?>
                                        <span class="course-grau"><?php echo esc_html($grau); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="course-toggle">
                                <?php echo acesso_get_icon('plus'); ?>
                            </div>
                        </div>

                        <div class="course-content">
                            <div class="course-details-grid">
                                <?php if ($duracao_ects) : ?>
                                    <div class="course-detail-item">
                                        <span class="detail-label"><?php esc_html_e('Duração / ECTS', 'acesso-uporto'); ?></span>
                                        <span class="detail-value"><?php echo esc_html($duracao_ects); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($vagas['fase_1'])) : ?>
                                    <div class="course-detail-item">
                                        <span class="detail-label"><?php esc_html_e('Vagas', 'acesso-uporto'); ?> <?php echo !empty($vagas['ano_das_vagas']) ? '(' . esc_html($vagas['ano_das_vagas']) . ')' : ''; ?></span>
                                        <span class="detail-value"><?php echo esc_html($vagas['fase_1']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($nota_ultimo['notas']['fase_1'])) : ?>
                                    <div class="course-detail-item">
                                        <span class="detail-label"><?php esc_html_e('Nota Último Colocado', 'acesso-uporto'); ?> <?php echo !empty($nota_ultimo['ano_ultimo_classificado']) ? '(' . esc_html($nota_ultimo['ano_ultimo_classificado']) . ')' : ''; ?></span>
                                        <span class="detail-value highlight"><?php echo esc_html($nota_ultimo['notas']['fase_1']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($classificacao['nota_de_candidatura'])) : ?>
                                    <div class="course-detail-item">
                                        <span class="detail-label"><?php esc_html_e('Classificação Mínima', 'acesso-uporto'); ?></span>
                                        <span class="detail-value"><?php echo esc_html($classificacao['nota_de_candidatura']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($provas['provas'])) : ?>
                                <div class="course-provas">
                                    <h4><?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?> <?php echo !empty($provas['ano_das_provas']) ? esc_html($provas['ano_das_provas']) : ''; ?></h4>
                                    <?php if (!empty($provas['expressao'])) : ?>
                                        <p class="provas-expressao"><?php echo esc_html($provas['expressao']); ?></p>
                                    <?php endif; ?>
                                    <p class="provas-list"><?php echo esc_html($provas['provas']); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="course-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-pink">
                                    <?php esc_html_e('Ver Curso', 'acesso-uporto'); ?>
                                    <?php echo acesso_get_icon('arrow-right'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            $big = 999999999;
            echo '<nav class="cursos-pagination">';
            echo paginate_links(array(
                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'    => '?paged=%#%',
                'current'   => max(1, $paged),
                'total'     => $cursos_query->max_num_pages,
                'prev_text' => '&laquo; ' . __('Anterior', 'acesso-uporto'),
                'next_text' => __('Seguinte', 'acesso-uporto') . ' &raquo;',
            ));
            echo '</nav>';
            ?>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e('Nenhum curso encontrado', 'acesso-uporto'); ?></h2>
                <p><?php esc_html_e('Tente ajustar os filtros de pesquisa.', 'acesso-uporto'); ?></p>
                <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Ver Todos os Cursos', 'acesso-uporto'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.cursos-archive .cursos-header {
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    color: var(--color-white);
    padding: calc(80px + var(--spacing-xl)) 0 var(--spacing-xl);
    text-align: center;
}

.cursos-archive .page-title {
    color: var(--color-white);
    margin-bottom: var(--spacing-sm);
}

.cursos-archive .page-description {
    font-size: 1.25rem;
    opacity: 0.9;
    margin: 0;
}

.cursos-filters-bar {
    background: var(--color-white);
    padding: var(--spacing-md);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-lg);
    margin-top: calc(-1 * var(--spacing-lg));
    position: relative;
    z-index: 10;
}

.cursos-search-form {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.search-input-wrapper {
    display: flex;
    position: relative;
}

.cursos-search-input {
    flex: 1;
    padding: 0.875rem 1rem;
    padding-right: 50px;
    border: 2px solid #e5e5e5;
    border-radius: var(--radius-full);
    font-family: var(--font-primary);
    font-size: 1rem;
    transition: border-color var(--transition-fast);
}

.cursos-search-input:focus {
    outline: none;
    border-color: var(--color-purple);
}

.cursos-search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    color: var(--color-white);
    border: none;
    border-radius: 50%;
    cursor: pointer;
}

.filter-dropdowns {
    display: flex;
    gap: var(--spacing-sm);
    flex-wrap: wrap;
    align-items: center;
}

.filter-select {
    padding: 0.625rem 1rem;
    border: 2px solid #e5e5e5;
    border-radius: var(--radius-full);
    font-family: var(--font-primary);
    font-size: 0.9375rem;
    background: var(--color-white);
    cursor: pointer;
    min-width: 180px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--color-purple);
}

.results-count {
    color: #666;
    margin-bottom: var(--spacing-md);
}

/* Course badges */
.course-badges {
    display: flex;
    gap: var(--spacing-xs);
    margin-bottom: var(--spacing-xs);
}

.badge {
    display: inline-block;
    padding: 2px 10px;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: var(--radius-full);
}

.badge-destaque {
    background: var(--gradient-primary);
    color: var(--color-white);
}

.badge-novo {
    background: var(--color-cyan);
    color: var(--color-dark);
}

.course-header-meta {
    display: flex;
    gap: var(--spacing-md);
    flex-wrap: wrap;
    font-size: 0.875rem;
    color: #666;
}

.course-grau {
    color: var(--color-purple);
    font-weight: 600;
}

/* Course details grid */
.course-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-md);
    padding-bottom: var(--spacing-md);
    border-bottom: 1px solid #eee;
}

.course-detail-item {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.75rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-value {
    font-weight: 600;
    color: var(--color-dark);
    font-size: 1.125rem;
}

.detail-value.highlight {
    color: var(--color-purple);
    font-size: 1.25rem;
}

/* Provas section */
.course-provas {
    margin-bottom: var(--spacing-md);
}

.course-provas h4 {
    font-size: 0.875rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--spacing-xs);
}

.provas-expressao {
    font-style: italic;
    color: #666;
    margin-bottom: var(--spacing-xs);
}

.provas-list {
    font-weight: 500;
}

/* Course actions */
.course-actions {
    display: flex;
    gap: var(--spacing-sm);
}

.course-actions .btn svg {
    width: 16px;
    height: 16px;
}

/* Pagination */
.cursos-pagination {
    display: flex;
    justify-content: center;
    gap: var(--spacing-xs);
    margin-top: var(--spacing-lg);
    flex-wrap: wrap;
}

.cursos-pagination .page-numbers {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 var(--spacing-sm);
    background: #f5f5f5;
    border-radius: var(--radius-md);
    font-weight: 600;
    color: var(--color-dark);
    text-decoration: none;
    transition: all var(--transition-fast);
}

.cursos-pagination .page-numbers:hover,
.cursos-pagination .page-numbers.current {
    background: var(--gradient-primary);
    color: var(--color-white);
}

@media (max-width: 768px) {
    .filter-dropdowns {
        flex-direction: column;
    }

    .filter-select {
        width: 100%;
    }

    .course-details-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

<?php
get_footer();
