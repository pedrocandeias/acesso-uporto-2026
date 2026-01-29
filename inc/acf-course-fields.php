<?php
/**
 * ACF Fields for Theme - Helper functions and Testimonial CPT fields
 *
 * Note: Course blocks (accordion, cards, detail) are now native Gutenberg blocks.
 * ACF fields for cursos CPT are registered in inc/importer/acf-cursos-fields.php
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

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
