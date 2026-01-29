<?php
/**
 * Course Detail Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$course_source = $attributes['courseSource'] ?? 'current';
$selected_course = $attributes['selectedCourse'] ?? 0;
$display_style = $attributes['displayStyle'] ?? 'full';

// Section visibility - use individual toggles or fallback to display_style presets
$show_header = $attributes['showHeader'] ?? ($display_style === 'full' || $display_style === 'header');
$show_stats = $attributes['showStats'] ?? ($display_style === 'full' || $display_style === 'stats');
$show_provas = $attributes['showProvas'] ?? ($display_style === 'full' || $display_style === 'info');
$show_classificacao = $attributes['showClassificacao'] ?? ($display_style === 'full' || $display_style === 'info');
$show_formula = $attributes['showFormula'] ?? ($display_style === 'full' || $display_style === 'info');
$show_prerequisitos = $attributes['showPrerequisitos'] ?? ($display_style === 'full' || $display_style === 'info');
$show_descricao = $attributes['showDescricao'] ?? ($display_style === 'full' || $display_style === 'description');
$show_saidas = $attributes['showSaidas'] ?? ($display_style === 'full' || $display_style === 'description');
$show_cta = $attributes['showCta'] ?? ($display_style === 'full' || $display_style === 'header');

$block_id = 'course-detail-' . uniqid();

// Get course ID
$course_id = null;
if ($course_source === 'current' && is_singular('cursos')) {
    $course_id = get_the_ID();
} elseif ($course_source === 'select' && $selected_course) {
    $course_id = $selected_course;
}

// If no course found, show message
if (!$course_id) {
    $wrapper_attributes = get_block_wrapper_attributes(array(
        'class' => 'course-detail-empty',
    ));
    echo '<div ' . $wrapper_attributes . '>';
    echo '<p style="padding: 40px; text-align: center; background: #f5f5f5; border-radius: 8px; color: #666;">';
    echo esc_html__('Selecione um curso ou use este bloco numa página de curso individual.', 'acesso-uporto');
    echo '</p></div>';
    return;
}

// Get course data
$course_title = get_the_title($course_id);
$faculdades = get_the_terms($course_id, 'faculdades');
$faculty_name = $faculdades && !is_wp_error($faculdades) ? $faculdades[0]->name : '';

// Get fields (ACF or post meta fallback)
if (function_exists('get_field')) {
    $grau = get_field('grau', $course_id);
    $info_extra = get_field('info_extra_curso', $course_id);
    $duracao = get_field('duracaoects', $course_id);
    $vagas = get_field('vagas', $course_id);
    $nota_ultimo = get_field('nota_do_ultimo_colocado', $course_id);
    $provas = get_field('provas_de_ingresso', $course_id);
    $classificacao = get_field('classificacao_minima', $course_id);
    $formula = get_field('formula_de_calculo', $course_id);
    $prerequisitos = get_field('prerequisitos', $course_id);
    $descricao = get_field('cursos_descricao', $course_id);
    $saidas = get_field('cursos_saidas_profissionais', $course_id);
    $saber_mais = get_field('saber_mais', $course_id);
    $destaque = get_field('destaque', $course_id);
    $novo = get_field('novo', $course_id);
    $certificacao = get_field('certificacao', $course_id);
    $selo = get_field('selo', $course_id);
} else {
    $grau = get_post_meta($course_id, 'grau', true);
    $info_extra = get_post_meta($course_id, 'info_extra_curso', true);
    $duracao = get_post_meta($course_id, 'duracaoects', true);
    $vagas = get_post_meta($course_id, 'vagas', true);
    $nota_ultimo = get_post_meta($course_id, 'nota_do_ultimo_colocado', true);
    $provas = get_post_meta($course_id, 'provas_de_ingresso', true);
    $classificacao = get_post_meta($course_id, 'classificacao_minima', true);
    $formula = get_post_meta($course_id, 'formula_de_calculo', true);
    $prerequisitos = get_post_meta($course_id, 'prerequisitos', true);
    $descricao = get_post_meta($course_id, 'cursos_descricao', true);
    $saidas = get_post_meta($course_id, 'cursos_saidas_profissionais', true);
    $saber_mais = get_post_meta($course_id, 'saber_mais', true);
    $destaque = get_post_meta($course_id, 'destaque', true);
    $novo = get_post_meta($course_id, 'novo', true);
    $certificacao = get_post_meta($course_id, 'certificacao', true);
    $selo = get_post_meta($course_id, 'selo', true);
}

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'course-detail style-' . esc_attr($display_style),
));
?>

<div <?php echo $wrapper_attributes; ?>>

    <?php if ($show_header) : ?>
    <div class="course-detail-header">
        <div class="course-detail-header-content">
            <?php if ($destaque || $novo) : ?>
                <div class="course-badges">
                    <?php if ($destaque) : ?>
                        <span class="badge badge-destaque"><?php esc_html_e('Destaque', 'acesso-uporto'); ?></span>
                    <?php endif; ?>
                    <?php if ($novo) : ?>
                        <span class="badge badge-novo"><?php esc_html_e('Novo', 'acesso-uporto'); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($faculty_name) : ?>
                <span class="course-detail-faculty"><?php echo esc_html($faculty_name); ?></span>
            <?php endif; ?>

            <h1 class="course-detail-title"><?php echo esc_html($course_title); ?></h1>

            <?php if ($grau || $info_extra) : ?>
                <div class="course-detail-subtitle">
                    <?php if ($grau) : ?>
                        <span class="course-grau"><?php echo esc_html($grau); ?></span>
                    <?php endif; ?>
                    <?php if ($info_extra) : ?>
                        <span class="course-info-extra"><?php echo esc_html($info_extra); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($certificacao || $selo) : ?>
                <div class="course-detail-seals">
                    <?php if ($certificacao) : ?>
                        <img src="<?php echo esc_url($certificacao); ?>" alt="<?php esc_attr_e('Certificação', 'acesso-uporto'); ?>" class="course-seal course-certificacao">
                    <?php endif; ?>
                    <?php if ($selo) : ?>
                        <img src="<?php echo esc_url($selo); ?>" alt="<?php esc_attr_e('Selo', 'acesso-uporto'); ?>" class="course-seal course-selo">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($show_stats) : ?>
    <div class="course-detail-stats">
        <?php if ($duracao) : ?>
            <div class="stat-item">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label"><?php esc_html_e('Duração / ECTS', 'acesso-uporto'); ?></span>
                    <span class="stat-value"><?php echo esc_html($duracao); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (is_array($vagas) && (!empty($vagas['fase_1']) || !empty($vagas['fase_2']) || !empty($vagas['fase_3']))) : ?>
            <div class="stat-item stat-multi">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">
                        <?php esc_html_e('Vagas', 'acesso-uporto'); ?>
                        <?php if (!empty($vagas['ano_das_vagas'])) : ?>
                            <small>(<?php echo esc_html($vagas['ano_das_vagas']); ?>)</small>
                        <?php endif; ?>
                    </span>
                    <div class="stat-phases">
                        <?php if (!empty($vagas['fase_1'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('1ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($vagas['fase_1']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($vagas['fase_2'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('2ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($vagas['fase_2']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($vagas['fase_3'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('3ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($vagas['fase_3']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $has_notas = is_array($nota_ultimo) && is_array($nota_ultimo['notas'] ?? null) &&
                     (!empty($nota_ultimo['notas']['fase_1']) || !empty($nota_ultimo['notas']['fase_2']) || !empty($nota_ultimo['notas']['fase_3']));
        ?>
        <?php if ($has_notas) : ?>
            <div class="stat-item stat-highlight stat-multi">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">
                        <?php esc_html_e('Nota Último Colocado', 'acesso-uporto'); ?>
                        <?php if (!empty($nota_ultimo['ano_ultimo_classificado'])) : ?>
                            <small>(<?php echo esc_html($nota_ultimo['ano_ultimo_classificado']); ?>)</small>
                        <?php endif; ?>
                    </span>
                    <div class="stat-phases">
                        <?php if (!empty($nota_ultimo['notas']['fase_1'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('1ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($nota_ultimo['notas']['fase_1']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($nota_ultimo['notas']['fase_2'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('2ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($nota_ultimo['notas']['fase_2']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($nota_ultimo['notas']['fase_3'])) : ?>
                            <div class="phase-item">
                                <span class="phase-label"><?php esc_html_e('3ª Fase', 'acesso-uporto'); ?></span>
                                <span class="phase-value"><?php echo esc_html($nota_ultimo['notas']['fase_3']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php
    // Check if any info section should be shown
    $show_info_sections = $show_provas || $show_classificacao || $show_formula || $show_prerequisitos;
    ?>
    <?php if ($show_info_sections) : ?>
    <div class="course-detail-sections">

        <?php if ($show_provas && is_array($provas) && !empty($provas['provas'])) : ?>
        <div class="course-section">
            <h3 class="course-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
                <?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?>
                <?php if (!empty($provas['ano_das_provas'])) : ?>
                    <small><?php echo esc_html($provas['ano_das_provas']); ?></small>
                <?php endif; ?>
            </h3>
            <div class="course-section-content">
                <?php if (!empty($provas['expressao'])) : ?>
                    <p class="provas-expressao"><?php echo esc_html($provas['expressao']); ?></p>
                <?php endif; ?>
                <p class="provas-lista"><?php echo nl2br(esc_html($provas['provas'])); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($show_classificacao && is_array($classificacao) && (!empty($classificacao['nota_de_candidatura']) || !empty($classificacao['nota_prova_de_ingresso']))) : ?>
        <div class="course-section">
            <h3 class="course-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="16"/>
                </svg>
                <?php esc_html_e('Classificação Mínima', 'acesso-uporto'); ?>
                <?php if (!empty($classificacao['ano_da_classificacao'])) : ?>
                    <small>(<?php echo esc_html($classificacao['ano_da_classificacao']); ?>)</small>
                <?php endif; ?>
            </h3>
            <div class="course-section-content course-section-grid">
                <?php if (!empty($classificacao['nota_de_candidatura'])) : ?>
                    <div class="grid-item">
                        <span class="item-label"><?php esc_html_e('Nota de Candidatura', 'acesso-uporto'); ?></span>
                        <span class="item-value"><?php echo esc_html($classificacao['nota_de_candidatura']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($classificacao['nota_prova_de_ingresso'])) : ?>
                    <div class="grid-item">
                        <span class="item-label"><?php esc_html_e('Prova de Ingresso', 'acesso-uporto'); ?></span>
                        <span class="item-value"><?php echo esc_html($classificacao['nota_prova_de_ingresso']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($show_formula && is_array($formula) && (!empty($formula['percentagem_secundario']) || !empty($formula['nota_prova_de_ingresso']))) : ?>
        <div class="course-section">
            <h3 class="course-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                </svg>
                <?php esc_html_e('Fórmula de Cálculo', 'acesso-uporto'); ?>
                <?php if (!empty($formula['ano_da_formula'])) : ?>
                    <small>(<?php echo esc_html($formula['ano_da_formula']); ?>)</small>
                <?php endif; ?>
            </h3>
            <div class="course-section-content course-section-grid">
                <?php if (!empty($formula['percentagem_secundario'])) : ?>
                    <div class="grid-item">
                        <span class="item-label"><?php esc_html_e('Classificação Secundário', 'acesso-uporto'); ?></span>
                        <span class="item-value"><?php echo esc_html($formula['percentagem_secundario']); ?>%</span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($formula['nota_prova_de_ingresso'])) : ?>
                    <div class="grid-item">
                        <span class="item-label"><?php esc_html_e('Provas de Ingresso', 'acesso-uporto'); ?></span>
                        <span class="item-value"><?php echo esc_html($formula['nota_prova_de_ingresso']); ?>%</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($show_prerequisitos && $prerequisitos) : ?>
        <div class="course-section">
            <h3 class="course-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <?php esc_html_e('Pré-requisitos', 'acesso-uporto'); ?>
            </h3>
            <div class="course-section-content">
                <p><?php echo nl2br(esc_html($prerequisitos)); ?></p>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <?php if (($show_descricao && $descricao) || ($show_saidas && $saidas)) : ?>
    <div class="course-detail-descriptions">
        <?php if ($show_descricao && $descricao) : ?>
        <div class="course-description">
            <h3><?php esc_html_e('Sobre o Curso', 'acesso-uporto'); ?></h3>
            <div class="description-content">
                <?php echo wp_kses_post($descricao); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($show_saidas && $saidas) : ?>
        <div class="course-description">
            <h3><?php esc_html_e('Saídas Profissionais', 'acesso-uporto'); ?></h3>
            <div class="description-content">
                <?php echo wp_kses_post($saidas); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($show_cta && is_array($saber_mais) && !empty($saber_mais['url'])) : ?>
    <div class="course-detail-cta">
        <a href="<?php echo esc_url($saber_mais['url']); ?>"
           class="btn btn-primary"
           <?php echo !empty($saber_mais['target']) ? 'target="' . esc_attr($saber_mais['target']) . '"' : ''; ?>>
            <?php echo esc_html(!empty($saber_mais['title']) ? $saber_mais['title'] : __('Saber Mais', 'acesso-uporto')); ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
        </a>
    </div>
    <?php endif; ?>

</div>
