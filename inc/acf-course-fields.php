<?php
/**
 * ACF Fields for Theme - Integrates with uporto-cursos-importer plugin
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Update Course Accordion Block Fields
 */
function acesso_register_course_accordion_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Update Course Accordion Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_course_accordion_block',
        'title'    => 'Course Accordion Block',
        'fields'   => array(
            array(
                'key'   => 'field_courses_title',
                'label' => 'Título da Secção',
                'name'  => 'section_title',
                'type'  => 'text',
                'default_value' => 'Cursos',
            ),
            array(
                'key'   => 'field_courses_source',
                'label' => 'Fonte dos Cursos',
                'name'  => 'courses_source',
                'type'  => 'select',
                'choices' => array(
                    'auto'   => 'Automático (do CPT Cursos)',
                    'manual' => 'Manual',
                ),
                'default_value' => 'auto',
            ),
            array(
                'key'   => 'field_courses_limit',
                'label' => 'Limite de Cursos',
                'name'  => 'limit',
                'type'  => 'number',
                'default_value' => 10,
                'min'   => 1,
                'max'   => 100,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_courses_source',
                            'operator' => '==',
                            'value'    => 'auto',
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'field_courses_filter_faculty',
                'label' => 'Filtrar por Faculdade',
                'name'  => 'filter_faculty',
                'type'  => 'taxonomy',
                'taxonomy' => 'faculdades',
                'field_type' => 'select',
                'allow_null' => 1,
                'return_format' => 'id',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_courses_source',
                            'operator' => '==',
                            'value'    => 'auto',
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'field_courses_destaque_only',
                'label' => 'Mostrar Apenas Destaques',
                'name'  => 'show_destaque_only',
                'type'  => 'true_false',
                'default_value' => 0,
                'ui' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_courses_source',
                            'operator' => '==',
                            'value'    => 'auto',
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'field_courses_show_filters',
                'label' => 'Mostrar Filtros',
                'name'  => 'show_filters',
                'type'  => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_courses_source',
                            'operator' => '==',
                            'value'    => 'auto',
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'field_courses_items',
                'label' => 'Cursos (Manual)',
                'name'  => 'courses',
                'type'  => 'repeater',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_courses_source',
                            'operator' => '==',
                            'value'    => 'manual',
                        ),
                    ),
                ),
                'sub_fields' => array(
                    array(
                        'key'   => 'field_course_name',
                        'label' => 'Nome do Curso',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_faculty',
                        'label' => 'Faculdade',
                        'name'  => 'faculty',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_grau',
                        'label' => 'Grau',
                        'name'  => 'grau',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_duracao',
                        'label' => 'Duração / ECTS',
                        'name'  => 'duracao',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_link',
                        'label' => 'Link',
                        'name'  => 'link',
                        'type'  => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/course-accordion',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'acesso_register_course_accordion_fields');

/**
 * Register Course Cards Block Fields
 */
function acesso_register_course_cards_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_course_cards_block',
        'title'    => 'Course Cards Block',
        'fields'   => array(
            array(
                'key'   => 'field_cards_section_title',
                'label' => 'Título da Secção',
                'name'  => 'section_title',
                'type'  => 'text',
                'instructions' => 'Título principal da secção',
            ),
            array(
                'key'   => 'field_cards_section_subtitle',
                'label' => 'Subtítulo',
                'name'  => 'section_subtitle',
                'type'  => 'text',
                'instructions' => 'Texto descritivo abaixo do título',
            ),
            array(
                'key'   => 'field_cards_layout',
                'label' => 'Layout',
                'name'  => 'layout',
                'type'  => 'select',
                'choices' => array(
                    'grid-2'   => '2 Colunas',
                    'grid-3'   => '3 Colunas',
                    'grid-4'   => '4 Colunas',
                    'carousel' => 'Carrossel',
                ),
                'default_value' => 'grid-3',
            ),
            array(
                'key'   => 'field_cards_style',
                'label' => 'Estilo dos Cards',
                'name'  => 'card_style',
                'type'  => 'select',
                'choices' => array(
                    'default'  => 'Padrão (Sombra)',
                    'gradient' => 'Gradiente Suave',
                    'bordered' => 'Com Borda',
                    'minimal'  => 'Minimalista',
                    'dark'     => 'Fundo Escuro',
                ),
                'default_value' => 'default',
            ),
            array(
                'key'   => 'field_cards_filter_type',
                'label' => 'Filtrar por Tipo',
                'name'  => 'filter_type',
                'type'  => 'select',
                'choices' => array(
                    'all'      => 'Todos os Cursos',
                    'destaque' => 'Apenas Destaques',
                    'novo'     => 'Apenas Novos',
                ),
                'default_value' => 'all',
            ),
            array(
                'key'   => 'field_cards_filter_faculty',
                'label' => 'Filtrar por Faculdade',
                'name'  => 'filter_faculty',
                'type'  => 'taxonomy',
                'taxonomy' => 'faculdades',
                'field_type' => 'select',
                'allow_null' => 1,
                'return_format' => 'id',
            ),
            array(
                'key'   => 'field_cards_limit',
                'label' => 'Número de Cursos',
                'name'  => 'limit',
                'type'  => 'number',
                'default_value' => 6,
                'min'   => 1,
                'max'   => 50,
            ),
            array(
                'key'   => 'field_cards_show_filters',
                'label' => 'Mostrar Filtros de Faculdade',
                'name'  => 'show_filters',
                'type'  => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key'   => 'field_cards_show_cta',
                'label' => 'Mostrar Botão Ver Todos',
                'name'  => 'show_cta',
                'type'  => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key'   => 'field_cards_cta_text',
                'label' => 'Texto do Botão',
                'name'  => 'cta_text',
                'type'  => 'text',
                'default_value' => 'Ver Todos os Cursos',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_cards_show_cta',
                            'operator' => '==',
                            'value'    => '1',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/course-cards',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'acesso_register_course_cards_fields');

/**
 * Register Course Detail Block Fields
 */
function acesso_register_course_detail_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_course_detail_block',
        'title'    => 'Course Detail Block',
        'fields'   => array(
            array(
                'key'   => 'field_detail_course_source',
                'label' => 'Fonte do Curso',
                'name'  => 'course_source',
                'type'  => 'select',
                'choices' => array(
                    'current' => 'Curso Atual (usar em páginas de curso)',
                    'select'  => 'Selecionar Curso',
                ),
                'default_value' => 'current',
                'instructions' => 'Use "Curso Atual" em templates de curso individual ou selecione um curso específico.',
            ),
            array(
                'key'   => 'field_detail_selected_course',
                'label' => 'Selecionar Curso',
                'name'  => 'selected_course',
                'type'  => 'post_object',
                'post_type' => array('cursos'),
                'return_format' => 'id',
                'allow_null' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_detail_course_source',
                            'operator' => '==',
                            'value'    => 'select',
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'field_detail_display_style',
                'label' => 'Estilo de Exibição',
                'name'  => 'display_style',
                'type'  => 'select',
                'choices' => array(
                    'full'        => 'Completo (todas as secções)',
                    'header'      => 'Apenas Cabeçalho',
                    'stats'       => 'Apenas Estatísticas',
                    'info'        => 'Apenas Informações Detalhadas',
                    'description' => 'Apenas Descrição',
                ),
                'default_value' => 'full',
                'instructions' => 'Escolha quais secções mostrar.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/course-detail',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'acesso_register_course_detail_fields');

/**
 * Register Testimonial CPT Fields
 */
function acesso_register_testimonial_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_testimonial_details',
        'title'    => 'Detalhes do Testemunho',
        'fields'   => array(
            array(
                'key'   => 'field_testimonial_student_name',
                'label' => 'Nome do Estudante',
                'name'  => 'student_name',
                'type'  => 'text',
                'required' => 1,
            ),
            array(
                'key'   => 'field_testimonial_course_name',
                'label' => 'Curso',
                'name'  => 'course_name',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_testimonial_year',
                'label' => 'Ano',
                'name'  => 'year',
                'type'  => 'text',
                'instructions' => 'Ex: "2º Ano" ou "Licenciado 2024"',
            ),
            array(
                'key'   => 'field_testimonial_quote',
                'label' => 'Citação',
                'name'  => 'quote',
                'type'  => 'textarea',
                'rows'  => 4,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'testimonial',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'acesso_register_testimonial_acf_fields');

/**
 * Helper function to get course data for display
 */
function acesso_get_curso_display_data($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $faculdades = get_the_terms($post_id, 'faculdades');

    return array(
        'id'          => $post_id,
        'title'       => get_the_title($post_id),
        'permalink'   => get_permalink($post_id),
        'faculdade'   => $faculdades ? $faculdades[0]->name : '',
        'faculdades'  => $faculdades ? wp_list_pluck($faculdades, 'name') : array(),
        'grau'        => get_field('grau', $post_id),
        'info_extra'  => get_field('info_extra_curso', $post_id),
        'duracao_ects' => get_field('duracaoects', $post_id),
        'vagas'       => get_field('vagas', $post_id),
        'nota_ultimo' => get_field('nota_do_ultimo_colocado', $post_id),
        'provas'      => get_field('provas_de_ingresso', $post_id),
        'classificacao' => get_field('classificacao_minima', $post_id),
        'formula'     => get_field('formula_de_calculo', $post_id),
        'prerequisitos' => get_field('prerequisitos', $post_id),
        'descricao'   => get_field('cursos_descricao', $post_id),
        'saidas'      => get_field('cursos_saidas_profissionais', $post_id),
        'saber_mais'  => get_field('saber_mais', $post_id),
        'destaque'    => get_field('destaque', $post_id),
        'novo'        => get_field('novo', $post_id),
    );
}

/**
 * Get featured courses
 */
function acesso_get_featured_cursos($limit = 6) {
    $args = array(
        'post_type'      => 'cursos',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => 'destaque',
                'value'   => '1',
                'compare' => '=',
            ),
        ),
        'orderby' => 'title',
        'order'   => 'ASC',
    );

    return new WP_Query($args);
}

/**
 * Get new courses
 */
function acesso_get_new_cursos($limit = 6) {
    $args = array(
        'post_type'      => 'cursos',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => 'novo',
                'value'   => '1',
                'compare' => '=',
            ),
        ),
        'orderby' => 'title',
        'order'   => 'ASC',
    );

    return new WP_Query($args);
}

/**
 * Get courses by faculty
 */
function acesso_get_cursos_by_faculty($faculty_slug, $limit = -1) {
    $args = array(
        'post_type'      => 'cursos',
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => 'faculdades',
                'field'    => 'slug',
                'terms'    => $faculty_slug,
            ),
        ),
        'orderby' => 'title',
        'order'   => 'ASC',
    );

    return new WP_Query($args);
}
