<?php
/**
 * The template for displaying single curso
 * Integrates with uporto-cursos-importer plugin
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post();
        $faculdades = get_the_terms(get_the_ID(), 'faculdades');
        $faculdade_names = $faculdades ? wp_list_pluck($faculdades, 'name') : array();

        // Get ACF fields
        $grau = get_field('grau');
        $info_extra = get_field('info_extra_curso');
        $duracao_ects = get_field('duracaoects');
        $vagas = get_field('vagas');
        $nota_ultimo = get_field('nota_do_ultimo_colocado');
        $provas = get_field('provas_de_ingresso');
        $classificacao = get_field('classificacao_minima');
        $formula = get_field('formula_de_calculo');
        $prerequisitos = get_field('prerequisitos');
        $descricao = get_field('cursos_descricao');
        $saidas = get_field('cursos_saidas_profissionais');
        $saber_mais = get_field('saber_mais');
        $destaque = get_field('destaque');
        $novo = get_field('novo');
    ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-curso'); ?>>
            <!-- Header -->
            <header class="curso-header">
                <div class="container">
                    <nav class="curso-breadcrumb" aria-label="Breadcrumb">
                        <a href="<?php echo esc_url(get_post_type_archive_link('cursos')); ?>">
                            <?php esc_html_e('Cursos', 'acesso-uporto'); ?>
                        </a>
                        <span aria-hidden="true">/</span>
                        <?php if ($faculdades) : ?>
                            <a href="<?php echo esc_url(add_query_arg('faculdade', $faculdades[0]->slug, get_post_type_archive_link('cursos'))); ?>">
                                <?php echo esc_html($faculdades[0]->name); ?>
                            </a>
                            <span aria-hidden="true">/</span>
                        <?php endif; ?>
                        <span class="current"><?php the_title(); ?></span>
                    </nav>

                    <div class="curso-header-badges">
                        <?php if ($destaque) : ?>
                            <span class="badge badge-destaque"><?php esc_html_e('Destaque', 'acesso-uporto'); ?></span>
                        <?php endif; ?>
                        <?php if ($novo) : ?>
                            <span class="badge badge-novo"><?php esc_html_e('Novo', 'acesso-uporto'); ?></span>
                        <?php endif; ?>
                    </div>

                    <h1 class="curso-title"><?php the_title(); ?></h1>

                    <?php if ($info_extra) : ?>
                        <p class="curso-info-extra"><?php echo esc_html($info_extra); ?></p>
                    <?php endif; ?>

                    <div class="curso-header-meta">
                        <?php if ($faculdades) : ?>
                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21h18M3 7v14M21 7v14M6 21V11M18 21V11M12 21V11M6 11H3a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3"/>
                                    <path d="M12 7V4M9 4h6"/>
                                </svg>
                                <span><?php echo esc_html(implode(', ', $faculdade_names)); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($grau) : ?>
                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                </svg>
                                <span><?php echo esc_html($grau); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($duracao_ects) : ?>
                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span><?php echo esc_html($duracao_ects); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="curso-content">
                <div class="container">
                    <div class="curso-layout">
                        <!-- Main Content -->
                        <div class="curso-main">
                            <?php if ($descricao) : ?>
                                <section class="curso-section">
                                    <h2><?php esc_html_e('Sobre o Curso', 'acesso-uporto'); ?></h2>
                                    <div class="curso-text">
                                        <?php echo wp_kses_post(wpautop($descricao)); ?>
                                    </div>
                                </section>
                            <?php endif; ?>

                            <?php if ($saidas) : ?>
                                <section class="curso-section">
                                    <h2><?php esc_html_e('Saídas Profissionais', 'acesso-uporto'); ?></h2>
                                    <div class="curso-text">
                                        <?php echo wp_kses_post(wpautop($saidas)); ?>
                                    </div>
                                </section>
                            <?php endif; ?>

                            <!-- Provas de Ingresso -->
                            <?php if (!empty($provas['provas'])) : ?>
                                <section class="curso-section curso-provas-section">
                                    <h2><?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?>
                                        <?php if (!empty($provas['ano_das_provas'])) : ?>
                                            <span class="year-badge"><?php echo esc_html($provas['ano_das_provas']); ?></span>
                                        <?php endif; ?>
                                    </h2>
                                    <?php if (!empty($provas['expressao'])) : ?>
                                        <p class="provas-expressao"><?php echo esc_html($provas['expressao']); ?></p>
                                    <?php endif; ?>
                                    <div class="provas-list">
                                        <?php echo esc_html($provas['provas']); ?>
                                    </div>
                                </section>
                            <?php endif; ?>

                            <!-- Classificação e Fórmula -->
                            <section class="curso-section">
                                <h2><?php esc_html_e('Critérios de Seleção', 'acesso-uporto'); ?></h2>
                                <div class="criterios-grid">
                                    <?php if (!empty($classificacao['nota_de_candidatura']) || !empty($classificacao['nota_prova_de_ingresso'])) : ?>
                                        <div class="criterio-card">
                                            <h3><?php esc_html_e('Classificação Mínima', 'acesso-uporto'); ?>
                                                <?php if (!empty($classificacao['ano_da_classificacao'])) : ?>
                                                    <span class="year-badge"><?php echo esc_html($classificacao['ano_da_classificacao']); ?></span>
                                                <?php endif; ?>
                                            </h3>
                                            <dl>
                                                <?php if (!empty($classificacao['nota_de_candidatura'])) : ?>
                                                    <div class="criterio-item">
                                                        <dt><?php esc_html_e('Nota de Candidatura', 'acesso-uporto'); ?></dt>
                                                        <dd><?php echo esc_html($classificacao['nota_de_candidatura']); ?></dd>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($classificacao['nota_prova_de_ingresso'])) : ?>
                                                    <div class="criterio-item">
                                                        <dt><?php esc_html_e('Prova de Ingresso', 'acesso-uporto'); ?></dt>
                                                        <dd><?php echo esc_html($classificacao['nota_prova_de_ingresso']); ?></dd>
                                                    </div>
                                                <?php endif; ?>
                                            </dl>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($formula['percentagem_secundario']) || !empty($formula['nota_prova_de_ingresso'])) : ?>
                                        <div class="criterio-card">
                                            <h3><?php esc_html_e('Fórmula de Cálculo', 'acesso-uporto'); ?>
                                                <?php if (!empty($formula['ano_da_formula'])) : ?>
                                                    <span class="year-badge"><?php echo esc_html($formula['ano_da_formula']); ?></span>
                                                <?php endif; ?>
                                            </h3>
                                            <dl>
                                                <?php if (!empty($formula['percentagem_secundario'])) : ?>
                                                    <div class="criterio-item">
                                                        <dt><?php esc_html_e('Ensino Secundário', 'acesso-uporto'); ?></dt>
                                                        <dd><?php echo esc_html($formula['percentagem_secundario']); ?></dd>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($formula['nota_prova_de_ingresso'])) : ?>
                                                    <div class="criterio-item">
                                                        <dt><?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?></dt>
                                                        <dd><?php echo esc_html($formula['nota_prova_de_ingresso']); ?></dd>
                                                    </div>
                                                <?php endif; ?>
                                            </dl>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </section>

                            <?php if ($prerequisitos) : ?>
                                <section class="curso-section curso-prerequisitos">
                                    <h2><?php esc_html_e('Pré-requisitos', 'acesso-uporto'); ?></h2>
                                    <div class="prerequisitos-box">
                                        <?php echo esc_html($prerequisitos); ?>
                                    </div>
                                </section>
                            <?php endif; ?>
                        </div>

                        <!-- Sidebar -->
                        <aside class="curso-sidebar">
                            <!-- Key Stats Card -->
                            <div class="curso-card curso-stats-card">
                                <h3><?php esc_html_e('Informação Chave', 'acesso-uporto'); ?></h3>

                                <!-- Vagas -->
                                <?php if (!empty($vagas['fase_1'])) : ?>
                                    <div class="stat-item">
                                        <span class="stat-label">
                                            <?php esc_html_e('Vagas', 'acesso-uporto'); ?>
                                            <?php if (!empty($vagas['ano_das_vagas'])) : ?>
                                                <small>(<?php echo esc_html($vagas['ano_das_vagas']); ?>)</small>
                                            <?php endif; ?>
                                        </span>
                                        <div class="stat-phases">
                                            <span class="stat-value"><?php echo esc_html($vagas['fase_1']); ?></span>
                                            <?php if (!empty($vagas['fase_2'])) : ?>
                                                <span class="phase-divider">|</span>
                                                <span class="stat-value-secondary"><?php echo esc_html($vagas['fase_2']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Nota Último Colocado -->
                                <?php if (!empty($nota_ultimo['notas']['fase_1'])) : ?>
                                    <div class="stat-item stat-highlight">
                                        <span class="stat-label">
                                            <?php esc_html_e('Nota Último Colocado', 'acesso-uporto'); ?>
                                            <?php if (!empty($nota_ultimo['ano_ultimo_classificado'])) : ?>
                                                <small>(<?php echo esc_html($nota_ultimo['ano_ultimo_classificado']); ?>)</small>
                                            <?php endif; ?>
                                        </span>
                                        <div class="stat-phases">
                                            <span class="stat-value gradient-text"><?php echo esc_html($nota_ultimo['notas']['fase_1']); ?></span>
                                            <?php if (!empty($nota_ultimo['notas']['fase_2'])) : ?>
                                                <span class="phase-divider">|</span>
                                                <span class="stat-value-secondary"><?php echo esc_html($nota_ultimo['notas']['fase_2']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="stat-help"><?php esc_html_e('1ª Fase | 2ª Fase', 'acesso-uporto'); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- CTA Card -->
                            <div class="curso-card curso-cta-card">
                                <h3><?php esc_html_e('Candidata-te', 'acesso-uporto'); ?></h3>
                                <p><?php esc_html_e('Começa a tua candidatura à Universidade do Porto.', 'acesso-uporto'); ?></p>
                                <a href="#candidatura" class="btn btn-primary btn-block">
                                    <?php esc_html_e('Candidatar', 'acesso-uporto'); ?>
                                </a>

                                <?php if ($saber_mais && !empty($saber_mais['url'])) : ?>
                                    <a href="<?php echo esc_url($saber_mais['url']); ?>"
                                       class="btn btn-secondary btn-block"
                                       target="<?php echo esc_attr($saber_mais['target'] ?? '_self'); ?>">
                                        <?php echo esc_html($saber_mais['title'] ?? __('Saber Mais', 'acesso-uporto')); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Share Card -->
                            <div class="curso-card curso-share-card">
                                <h4><?php esc_html_e('Partilhar', 'acesso-uporto'); ?></h4>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                       target="_blank" rel="noopener" class="share-btn facebook" aria-label="Share on Facebook">
                                        <?php echo acesso_get_icon('facebook'); ?>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                       target="_blank" rel="noopener" class="share-btn twitter" aria-label="Share on Twitter">
                                        <?php echo acesso_get_icon('twitter'); ?>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                       target="_blank" rel="noopener" class="share-btn linkedin" aria-label="Share on LinkedIn">
                                        <?php echo acesso_get_icon('linkedin'); ?>
                                    </a>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<style>
/* Header */
.single-curso .curso-header {
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    color: var(--color-white);
    padding: calc(80px + var(--spacing-xl)) 0 var(--spacing-xl);
}

.single-curso .curso-breadcrumb {
    font-size: 0.875rem;
    margin-bottom: var(--spacing-md);
    opacity: 0.8;
}

.single-curso .curso-breadcrumb a {
    color: var(--color-white);
}

.single-curso .curso-breadcrumb a:hover {
    text-decoration: underline;
}

.single-curso .curso-breadcrumb span {
    margin: 0 var(--spacing-xs);
}

.curso-header-badges {
    display: flex;
    gap: var(--spacing-xs);
    margin-bottom: var(--spacing-sm);
}

.badge {
    display: inline-block;
    padding: 4px 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: var(--radius-full);
}

.badge-destaque {
    background: rgba(255, 255, 255, 0.2);
    color: var(--color-white);
}

.badge-novo {
    background: var(--color-cyan);
    color: var(--color-dark);
}

.single-curso .curso-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    margin-bottom: var(--spacing-sm);
    color: var(--color-white);
}

.curso-info-extra {
    font-size: 1.125rem;
    opacity: 0.9;
    margin-bottom: var(--spacing-md);
}

.curso-header-meta {
    display: flex;
    gap: var(--spacing-lg);
    flex-wrap: wrap;
}

.curso-header-meta .meta-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    font-size: 1rem;
}

.curso-header-meta svg {
    opacity: 0.8;
}

/* Content Layout */
.curso-content {
    padding: var(--spacing-xl) 0;
}

.curso-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: var(--spacing-lg);
}

/* Main Content */
.curso-section {
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid #eee;
}

.curso-section:last-child {
    border-bottom: none;
}

.curso-section h2 {
    font-size: 1.5rem;
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.year-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 2px 8px;
    background: #f5f5f5;
    border-radius: var(--radius-full);
    color: #666;
}

.curso-text {
    line-height: 1.8;
}

.curso-text p {
    margin-bottom: var(--spacing-md);
}

/* Provas Section */
.provas-expressao {
    font-style: italic;
    color: #666;
    margin-bottom: var(--spacing-sm);
}

.provas-list {
    background: #f9f9f9;
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
    font-weight: 500;
    line-height: 1.8;
}

/* Criterios Grid */
.criterios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

.criterio-card {
    background: #f9f9f9;
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
}

.criterio-card h3 {
    font-size: 1rem;
    margin-bottom: var(--spacing-sm);
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    flex-wrap: wrap;
}

.criterio-card dl {
    margin: 0;
}

.criterio-item {
    display: flex;
    justify-content: space-between;
    padding: var(--spacing-xs) 0;
    border-bottom: 1px solid #eee;
}

.criterio-item:last-child {
    border-bottom: none;
}

.criterio-item dt {
    color: #666;
    font-size: 0.875rem;
}

.criterio-item dd {
    margin: 0;
    font-weight: 700;
    color: var(--color-purple);
}

/* Prerequisitos */
.prerequisitos-box {
    background: rgba(255, 107, 107, 0.1);
    border-left: 4px solid var(--color-coral);
    padding: var(--spacing-md);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    color: #333;
}

/* Sidebar */
.curso-sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.curso-card {
    background: var(--color-white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-md);
}

.curso-card h3 {
    font-size: 1.125rem;
    margin-bottom: var(--spacing-md);
    padding-bottom: var(--spacing-sm);
    border-bottom: 2px solid var(--color-purple);
}

.curso-card h4 {
    font-size: 1rem;
    margin-bottom: var(--spacing-sm);
}

/* Stats Card */
.stat-item {
    padding: var(--spacing-sm) 0;
    border-bottom: 1px solid #eee;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.stat-label small {
    font-weight: normal;
    text-transform: none;
}

.stat-phases {
    display: flex;
    align-items: baseline;
    gap: var(--spacing-xs);
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-dark);
}

.stat-highlight .stat-value {
    font-size: 2rem;
}

.stat-value-secondary {
    font-size: 1.25rem;
    font-weight: 600;
    color: #666;
}

.phase-divider {
    color: #ccc;
}

.stat-help {
    display: block;
    font-size: 0.6875rem;
    color: #999;
    margin-top: 4px;
}

/* CTA Card */
.curso-cta-card {
    background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-pink) 100%);
    color: var(--color-white);
}

.curso-cta-card h3 {
    color: var(--color-white);
    border-bottom-color: rgba(255, 255, 255, 0.3);
}

.curso-cta-card p {
    opacity: 0.9;
    margin-bottom: var(--spacing-md);
}

.btn-block {
    display: block;
    width: 100%;
    text-align: center;
    margin-bottom: var(--spacing-sm);
}

.btn-block:last-child {
    margin-bottom: 0;
}

.curso-cta-card .btn-primary {
    background: var(--color-white);
    color: var(--color-purple);
}

.curso-cta-card .btn-secondary {
    background: transparent;
    border-color: rgba(255, 255, 255, 0.5);
    color: var(--color-white);
}

/* Share Card */
.share-buttons {
    display: flex;
    gap: var(--spacing-sm);
}

.share-btn {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 50%;
    color: #666;
    transition: all var(--transition-fast);
}

.share-btn:hover {
    background: var(--color-purple);
    color: var(--color-white);
}

.share-btn svg {
    width: 20px;
    height: 20px;
}

/* Responsive */
@media (max-width: 992px) {
    .curso-layout {
        grid-template-columns: 1fr;
    }

    .curso-sidebar {
        order: -1;
    }

    .curso-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .curso-header-meta {
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .criterios-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
