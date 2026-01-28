<?php
/**
 * ACF Fields for Cursos CPT
 * Registers all ACF fields used by the importer
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Fields for Cursos
 */
function acesso_register_cursos_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_cursos_main',
        'title' => 'Informação do Curso',
        'fields' => array(
            // Grau
            array(
                'key' => 'field_cursos_grau',
                'label' => 'Grau',
                'name' => 'grau',
                'type' => 'text',
                'instructions' => 'Ex: Licenciatura - 1º ciclo, Mestrado Integrado',
            ),
            // Info extra
            array(
                'key' => 'field_cursos_info_extra',
                'label' => 'Informações Adicionais',
                'name' => 'info_extra_curso',
                'type' => 'text',
                'instructions' => 'Ex: em parceria com...',
            ),
            // Duração/ECTS
            array(
                'key' => 'field_cursos_duracao',
                'label' => 'Duração / ECTS',
                'name' => 'duracaoects',
                'type' => 'text',
                'instructions' => 'Ex: 3 anos / 180 ECTS',
            ),
            // Vagas (group)
            array(
                'key' => 'field_cursos_vagas',
                'label' => 'Vagas',
                'name' => 'vagas',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_vagas_ano',
                        'label' => 'Ano',
                        'name' => 'ano_das_vagas',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_vagas_fase1',
                        'label' => '1ª Fase',
                        'name' => 'fase_1',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_vagas_fase2',
                        'label' => '2ª Fase',
                        'name' => 'fase_2',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_vagas_fase3',
                        'label' => '3ª Fase',
                        'name' => 'fase_3',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                ),
            ),
            // Nota do último colocado (group)
            array(
                'key' => 'field_cursos_nota_ultimo',
                'label' => 'Nota do Último Colocado',
                'name' => 'nota_do_ultimo_colocado',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_nota_ano',
                        'label' => 'Ano',
                        'name' => 'ano_ultimo_classificado',
                        'type' => 'text',
                        'wrapper' => array('width' => '100'),
                    ),
                    array(
                        'key' => 'field_nota_notas',
                        'label' => 'Notas por Fase',
                        'name' => 'notas',
                        'type' => 'group',
                        'layout' => 'row',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_nota_fase1',
                                'label' => '1ª Fase',
                                'name' => 'fase_1',
                                'type' => 'text',
                                'wrapper' => array('width' => '33'),
                            ),
                            array(
                                'key' => 'field_nota_fase2',
                                'label' => '2ª Fase',
                                'name' => 'fase_2',
                                'type' => 'text',
                                'wrapper' => array('width' => '33'),
                            ),
                            array(
                                'key' => 'field_nota_fase3',
                                'label' => '3ª Fase',
                                'name' => 'fase_3',
                                'type' => 'text',
                                'wrapper' => array('width' => '33'),
                            ),
                        ),
                    ),
                ),
            ),
            // Provas de Ingresso (group)
            array(
                'key' => 'field_cursos_provas',
                'label' => 'Provas de Ingresso',
                'name' => 'provas_de_ingresso',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_provas_ano',
                        'label' => 'Ano',
                        'name' => 'ano_das_provas',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_provas_expressao',
                        'label' => 'Expressão',
                        'name' => 'expressao',
                        'type' => 'text',
                        'instructions' => 'Ex: Um dos seguintes conjuntos:',
                        'wrapper' => array('width' => '75'),
                    ),
                    array(
                        'key' => 'field_provas_lista',
                        'label' => 'Provas',
                        'name' => 'provas',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            // Classificação Mínima (group)
            array(
                'key' => 'field_cursos_classificacao',
                'label' => 'Classificação Mínima',
                'name' => 'classificacao_minima',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_class_ano',
                        'label' => 'Ano',
                        'name' => 'ano_da_classificacao',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_class_candidatura',
                        'label' => 'Nota de Candidatura',
                        'name' => 'nota_de_candidatura',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_class_prova',
                        'label' => 'Prova de Ingresso',
                        'name' => 'nota_prova_de_ingresso',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                ),
            ),
            // Fórmula de Cálculo (group)
            array(
                'key' => 'field_cursos_formula',
                'label' => 'Fórmula de Cálculo',
                'name' => 'formula_de_calculo',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_formula_ano',
                        'label' => 'Ano',
                        'name' => 'ano_da_formula',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_formula_secundario',
                        'label' => '% Secundário',
                        'name' => 'percentagem_secundario',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_formula_prova',
                        'label' => '% Provas',
                        'name' => 'nota_prova_de_ingresso',
                        'type' => 'text',
                        'wrapper' => array('width' => '33'),
                    ),
                ),
            ),
            // Pré-requisitos
            array(
                'key' => 'field_cursos_prerequisitos',
                'label' => 'Pré-requisitos',
                'name' => 'prerequisitos',
                'type' => 'textarea',
                'rows' => 2,
            ),
            // Saber mais (link)
            array(
                'key' => 'field_cursos_saber_mais',
                'label' => 'Link Saber Mais',
                'name' => 'saber_mais',
                'type' => 'link',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cursos',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ));

    // Descrição e Saídas
    acf_add_local_field_group(array(
        'key' => 'group_cursos_descricao',
        'title' => 'Descrição do Curso',
        'fields' => array(
            array(
                'key' => 'field_cursos_descricao',
                'label' => 'Descrição',
                'name' => 'cursos_descricao',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_cursos_saidas',
                'label' => 'Saídas Profissionais',
                'name' => 'cursos_saidas_profissionais',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cursos',
                ),
            ),
        ),
        'menu_order' => 10,
        'position' => 'normal',
    ));

    // Destaque e Novo
    acf_add_local_field_group(array(
        'key' => 'group_cursos_badges',
        'title' => 'Destaque',
        'fields' => array(
            array(
                'key' => 'field_cursos_destaque',
                'label' => 'Curso em Destaque',
                'name' => 'destaque',
                'type' => 'true_false',
                'ui' => 1,
                'ui_on_text' => 'Sim',
                'ui_off_text' => 'Não',
            ),
            array(
                'key' => 'field_cursos_novo',
                'label' => 'Curso Novo',
                'name' => 'novo',
                'type' => 'true_false',
                'ui' => 1,
                'ui_on_text' => 'Sim',
                'ui_off_text' => 'Não',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cursos',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
    ));
}
add_action('acf/init', 'acesso_register_cursos_acf_fields', 5);
