<?php
/**
 * Acesso U.Porto 2026 Theme Functions
 *
 * @package AcessoUPorto
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ACESSO_THEME_VERSION', '1.1.0');
define('ACESSO_THEME_DIR', get_template_directory());
define('ACESSO_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function acesso_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Add editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Purple', 'acesso-uporto'),
            'slug'  => 'purple',
            'color' => '#572ddf',
        ),
        array(
            'name'  => __('Pink', 'acesso-uporto'),
            'slug'  => 'pink',
            'color' => '#da2489',
        ),
        array(
            'name'  => __('Dark', 'acesso-uporto'),
            'slug'  => 'dark',
            'color' => '#060221',
        ),
        array(
            'name'  => __('Cyan', 'acesso-uporto'),
            'slug'  => 'cyan',
            'color' => '#00d084',
        ),
        array(
            'name'  => __('Lavender', 'acesso-uporto'),
            'slug'  => 'lavender',
            'color' => '#8887e2',
        ),
        array(
            'name'  => __('Coral', 'acesso-uporto'),
            'slug'  => 'coral',
            'color' => '#ff6b6b',
        ),
        array(
            'name'  => __('White', 'acesso-uporto'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ));

    // Add editor gradient presets
    add_theme_support('editor-gradient-presets', array(
        array(
            'name'     => __('Purple to Pink', 'acesso-uporto'),
            'gradient' => 'linear-gradient(135deg, #572ddf 0%, #da2489 100%)',
            'slug'     => 'purple-pink',
        ),
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'acesso-uporto'),
        'footer'  => __('Footer Menu', 'acesso-uporto'),
        'social'  => __('Social Menu', 'acesso-uporto'),
    ));

    // Load text domain
    load_theme_textdomain('acesso-uporto', ACESSO_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'acesso_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function acesso_enqueue_assets() {
    // Google Fonts - Barlow
    wp_enqueue_style(
        'acesso-google-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Semi+Condensed:wght@600;700;900&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'acesso-style',
        get_stylesheet_uri(),
        array('acesso-google-fonts'),
        ACESSO_THEME_VERSION
    );

    // Block styles
    wp_enqueue_style(
        'acesso-blocks',
        ACESSO_THEME_URI . '/assets/css/blocks.css',
        array('acesso-style'),
        ACESSO_THEME_VERSION
    );

    // Course blocks styles
    wp_enqueue_style(
        'acesso-course-blocks',
        ACESSO_THEME_URI . '/blocks/course-blocks.css',
        array('acesso-style'),
        ACESSO_THEME_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'acesso-main',
        ACESSO_THEME_URI . '/assets/js/main.js',
        array(),
        ACESSO_THEME_VERSION,
        true
    );

    // Localize script
    wp_localize_script('acesso-main', 'acessoData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('acesso_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'acesso_enqueue_assets');

/**
 * Enqueue Editor Styles
 */
function acesso_enqueue_editor_assets() {
    wp_enqueue_style(
        'acesso-google-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Semi+Condensed:wght@600;700;900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'acesso-editor-style',
        ACESSO_THEME_URI . '/assets/css/editor.css',
        array('acesso-google-fonts'),
        ACESSO_THEME_VERSION
    );

    // Course blocks styles for editor
    wp_enqueue_style(
        'acesso-course-blocks-editor',
        ACESSO_THEME_URI . '/blocks/course-blocks.css',
        array(),
        ACESSO_THEME_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'acesso_enqueue_editor_assets');

/**
 * Register Native Gutenberg Blocks
 */
function acesso_register_native_blocks() {
    // Course Blocks
    register_block_type(ACESSO_THEME_DIR . '/blocks/course-accordion');
    register_block_type(ACESSO_THEME_DIR . '/blocks/course-cards');
    register_block_type(ACESSO_THEME_DIR . '/blocks/course-detail');

    // Hero Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/hero');

    // Statistics Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/statistics');

    // Testimonials Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/testimonials');

    // Feature Cards Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/feature-cards');

    // Timeline Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/timeline');

    // CTA Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/cta');

    // Video Section Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/video-section');

    // FAQ Accordion Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/faq-accordion');

    // Faculty Cards Block
    register_block_type(ACESSO_THEME_DIR . '/blocks/faculty-cards');

    // Icon Box Block (migração ld_icon_box)
    register_block_type(ACESSO_THEME_DIR . '/blocks/icon-box');

    // Tabs (migração ld_tabs / ld_tab_section)
    register_block_type(ACESSO_THEME_DIR . '/blocks/tabs');
    register_block_type(ACESSO_THEME_DIR . '/blocks/tab');

    // Modal (migração ld_modal_window)
    register_block_type(ACESSO_THEME_DIR . '/blocks/modal');

    // Menu de navegação (migração ld_custom_menu)
    register_block_type(ACESSO_THEME_DIR . '/blocks/anchor-menu');
}
add_action('init', 'acesso_register_native_blocks');

/**
 * Register ACF Blocks (only if ACF PRO is available)
 */
function acesso_register_acf_blocks() {
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Hero Block
    acf_register_block_type(array(
        'name'            => 'hero',
        'title'           => __('Hero Section', 'acesso-uporto'),
        'description'     => __('Full-width hero section with rotating text.', 'acesso-uporto'),
        'render_template' => 'blocks/hero/hero.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'cover-image',
        'keywords'        => array('hero', 'banner', 'header'),
        'supports'        => array(
            'align' => array('full'),
            'mode'  => false,
        ),
        'example'         => array(
            'attributes' => array(
                'mode' => 'preview',
            ),
        ),
    ));

    // Statistics Block
    acf_register_block_type(array(
        'name'            => 'statistics',
        'title'           => __('Statistics', 'acesso-uporto'),
        'description'     => __('Counter statistics section.', 'acesso-uporto'),
        'render_template' => 'blocks/statistics/statistics.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'chart-bar',
        'keywords'        => array('stats', 'numbers', 'counter'),
        'supports'        => array(
            'align' => array('full', 'wide'),
        ),
    ));

    // Testimonials Block
    acf_register_block_type(array(
        'name'            => 'testimonials',
        'title'           => __('Testimonials', 'acesso-uporto'),
        'description'     => __('Student testimonials carousel.', 'acesso-uporto'),
        'render_template' => 'blocks/testimonials/testimonials.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'format-quote',
        'keywords'        => array('testimonials', 'students', 'carousel'),
        'supports'        => array(
            'align' => array('full', 'wide'),
        ),
    ));

    // Timeline Block
    acf_register_block_type(array(
        'name'            => 'timeline',
        'title'           => __('Timeline', 'acesso-uporto'),
        'description'     => __('Application timeline phases.', 'acesso-uporto'),
        'render_template' => 'blocks/timeline/timeline.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'clock',
        'keywords'        => array('timeline', 'phases', 'dates'),
        'supports'        => array(
            'align' => array('wide'),
        ),
    ));

    // CTA Block
    acf_register_block_type(array(
        'name'            => 'cta',
        'title'           => __('Call to Action', 'acesso-uporto'),
        'description'     => __('Call to action section.', 'acesso-uporto'),
        'render_template' => 'blocks/cta/cta.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'megaphone',
        'keywords'        => array('cta', 'button', 'action'),
        'supports'        => array(
            'align' => array('full', 'wide'),
        ),
    ));

    // Faculty Cards Block
    acf_register_block_type(array(
        'name'            => 'faculty-cards',
        'title'           => __('Faculty Cards', 'acesso-uporto'),
        'description'     => __('Grid of faculty cards.', 'acesso-uporto'),
        'render_template' => 'blocks/faculty-cards/faculty-cards.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'building',
        'keywords'        => array('faculty', 'cards', 'grid'),
        'supports'        => array(
            'align' => array('wide'),
        ),
    ));

    // Video Section Block
    acf_register_block_type(array(
        'name'            => 'video-section',
        'title'           => __('Video Section', 'acesso-uporto'),
        'description'     => __('Video embed section.', 'acesso-uporto'),
        'render_template' => 'blocks/video-section/video-section.php',
        'category'        => 'acesso-blocks',
        'icon'            => 'video-alt3',
        'keywords'        => array('video', 'youtube', 'embed'),
        'supports'        => array(
            'align' => array('full', 'wide'),
        ),
    ));
}
add_action('acf/init', 'acesso_register_acf_blocks');

/**
 * Register ACF Block Category
 */
function acesso_block_categories($categories) {
    return array_merge(
        array(
            array(
                'slug'  => 'acesso-blocks',
                'title' => __('Acesso U.Porto', 'acesso-uporto'),
                'icon'  => 'university',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'acesso_block_categories', 10, 1);

/**
 * Register ACF Fields
 */
function acesso_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Hero Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_hero_block',
        'title'    => 'Hero Block',
        'fields'   => array(
            array(
                'key'   => 'field_hero_pretitle',
                'label' => 'Pre-title',
                'name'  => 'pretitle',
                'type'  => 'text',
                'default_value' => 'ISTO É',
            ),
            array(
                'key'   => 'field_hero_rotating_words',
                'label' => 'Rotating Words',
                'name'  => 'rotating_words',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_hero_word',
                        'label' => 'Word',
                        'name'  => 'word',
                        'type'  => 'text',
                    ),
                ),
                'min' => 1,
            ),
            array(
                'key'   => 'field_hero_title',
                'label' => 'Main Title',
                'name'  => 'title',
                'type'  => 'text',
                'default_value' => 'U.PORTO',
            ),
            array(
                'key'   => 'field_hero_buttons',
                'label' => 'Buttons',
                'name'  => 'buttons',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_hero_btn_text',
                        'label' => 'Button Text',
                        'name'  => 'text',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_hero_btn_url',
                        'label' => 'Button URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ),
                    array(
                        'key'   => 'field_hero_btn_style',
                        'label' => 'Button Style',
                        'name'  => 'style',
                        'type'  => 'select',
                        'choices' => array(
                            'primary' => 'Primary (Gradient)',
                            'white'   => 'White',
                            'secondary' => 'Secondary (Outline)',
                        ),
                    ),
                ),
                'max' => 3,
            ),
            array(
                'key'   => 'field_hero_background',
                'label' => 'Background Image',
                'name'  => 'background_image',
                'type'  => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/hero',
                ),
            ),
        ),
    ));

    // Statistics Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_statistics_block',
        'title'    => 'Statistics Block',
        'fields'   => array(
            array(
                'key'   => 'field_stats_items',
                'label' => 'Statistics',
                'name'  => 'statistics',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_stat_number',
                        'label' => 'Number',
                        'name'  => 'number',
                        'type'  => 'number',
                    ),
                    array(
                        'key'   => 'field_stat_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_stat_suffix',
                        'label' => 'Suffix',
                        'name'  => 'suffix',
                        'type'  => 'text',
                        'instructions' => 'E.g., +, %, etc.',
                    ),
                ),
                'min' => 1,
                'max' => 6,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/statistics',
                ),
            ),
        ),
    ));

    // Course Accordion Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_course_accordion_block',
        'title'    => 'Course Accordion Block',
        'fields'   => array(
            array(
                'key'   => 'field_courses_title',
                'label' => 'Section Title',
                'name'  => 'section_title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_courses_items',
                'label' => 'Courses',
                'name'  => 'courses',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_course_name',
                        'label' => 'Course Name',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_faculty',
                        'label' => 'Faculty',
                        'name'  => 'faculty',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_degree',
                        'label' => 'Degree Type',
                        'name'  => 'degree',
                        'type'  => 'select',
                        'choices' => array(
                            'licenciatura' => 'Licenciatura',
                            'mestrado' => 'Mestrado Integrado',
                        ),
                    ),
                    array(
                        'key'   => 'field_course_vacancies',
                        'label' => 'Vacancies',
                        'name'  => 'vacancies',
                        'type'  => 'number',
                    ),
                    array(
                        'key'   => 'field_course_exams',
                        'label' => 'Required Exams',
                        'name'  => 'exams',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_min_grade',
                        'label' => 'Minimum Grade',
                        'name'  => 'min_grade',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_course_link',
                        'label' => 'Course Link',
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

    // Testimonials Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_testimonials_block',
        'title'    => 'Testimonials Block',
        'fields'   => array(
            array(
                'key'   => 'field_testimonials_title',
                'label' => 'Section Title',
                'name'  => 'section_title',
                'type'  => 'text',
                'default_value' => 'Os teus futuros colegas',
            ),
            array(
                'key'   => 'field_testimonials_items',
                'label' => 'Testimonials',
                'name'  => 'testimonials',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_testimonial_image',
                        'label' => 'Photo',
                        'name'  => 'image',
                        'type'  => 'image',
                        'return_format' => 'array',
                    ),
                    array(
                        'key'   => 'field_testimonial_name',
                        'label' => 'Name',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_testimonial_course',
                        'label' => 'Course',
                        'name'  => 'course',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_testimonial_quote',
                        'label' => 'Quote',
                        'name'  => 'quote',
                        'type'  => 'textarea',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/testimonials',
                ),
            ),
        ),
    ));

    // Timeline Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_timeline_block',
        'title'    => 'Timeline Block',
        'fields'   => array(
            array(
                'key'   => 'field_timeline_title',
                'label' => 'Section Title',
                'name'  => 'section_title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_timeline_phases',
                'label' => 'Phases',
                'name'  => 'phases',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_phase_icon',
                        'label' => 'Icon',
                        'name'  => 'icon',
                        'type'  => 'select',
                        'choices' => array(
                            'calendar' => 'Calendar',
                            'edit'     => 'Edit/Write',
                            'check'    => 'Check/Complete',
                            'clock'    => 'Clock',
                            'star'     => 'Star',
                        ),
                    ),
                    array(
                        'key'   => 'field_phase_color',
                        'label' => 'Color',
                        'name'  => 'color',
                        'type'  => 'select',
                        'choices' => array(
                            'cyan'     => 'Cyan',
                            'lavender' => 'Lavender',
                            'coral'    => 'Coral',
                            'purple'   => 'Purple',
                            'pink'     => 'Pink',
                        ),
                    ),
                    array(
                        'key'   => 'field_phase_label',
                        'label' => 'Phase Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_phase_title',
                        'label' => 'Title',
                        'name'  => 'title',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_phase_dates',
                        'label' => 'Dates',
                        'name'  => 'dates',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_phase_description',
                        'label' => 'Description',
                        'name'  => 'description',
                        'type'  => 'textarea',
                    ),
                ),
                'min' => 1,
                'max' => 5,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/timeline',
                ),
            ),
        ),
    ));

    // CTA Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_cta_block',
        'title'    => 'CTA Block',
        'fields'   => array(
            array(
                'key'   => 'field_cta_title',
                'label' => 'Title',
                'name'  => 'title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_text',
                'label' => 'Text',
                'name'  => 'text',
                'type'  => 'textarea',
            ),
            array(
                'key'   => 'field_cta_button_text',
                'label' => 'Button Text',
                'name'  => 'button_text',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_cta_button_url',
                'label' => 'Button URL',
                'name'  => 'button_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_cta_style',
                'label' => 'Style',
                'name'  => 'style',
                'type'  => 'select',
                'choices' => array(
                    'gradient' => 'Gradient Background',
                    'dark'     => 'Dark Background',
                    'light'    => 'Light Background',
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/cta',
                ),
            ),
        ),
    ));

    // Faculty Cards Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_faculty_cards_block',
        'title'    => 'Faculty Cards Block',
        'fields'   => array(
            array(
                'key'   => 'field_faculty_title',
                'label' => 'Section Title',
                'name'  => 'section_title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_faculty_items',
                'label' => 'Faculties',
                'name'  => 'faculties',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_faculty_name',
                        'label' => 'Name',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_faculty_acronym',
                        'label' => 'Acronym',
                        'name'  => 'acronym',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_faculty_image',
                        'label' => 'Image',
                        'name'  => 'image',
                        'type'  => 'image',
                        'return_format' => 'array',
                    ),
                    array(
                        'key'   => 'field_faculty_link',
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
                    'value'    => 'acf/faculty-cards',
                ),
            ),
        ),
    ));

    // Video Section Block Fields
    acf_add_local_field_group(array(
        'key'      => 'group_video_section_block',
        'title'    => 'Video Section Block',
        'fields'   => array(
            array(
                'key'   => 'field_video_title',
                'label' => 'Title',
                'name'  => 'title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_video_url',
                'label' => 'Video URL',
                'name'  => 'video_url',
                'type'  => 'url',
                'instructions' => 'YouTube or Vimeo URL',
            ),
            array(
                'key'   => 'field_video_poster',
                'label' => 'Poster Image',
                'name'  => 'poster',
                'type'  => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'block',
                    'operator' => '==',
                    'value'    => 'acf/video-section',
                ),
            ),
        ),
    ));

    // Theme Options Page Fields
    acf_add_local_field_group(array(
        'key'      => 'group_theme_options',
        'title'    => 'Theme Options',
        'fields'   => array(
            array(
                'key'   => 'field_social_facebook',
                'label' => 'Facebook URL',
                'name'  => 'facebook_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_instagram',
                'label' => 'Instagram URL',
                'name'  => 'instagram_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_twitter',
                'label' => 'Twitter/X URL',
                'name'  => 'twitter_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_youtube',
                'label' => 'YouTube URL',
                'name'  => 'youtube_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_linkedin',
                'label' => 'LinkedIn URL',
                'name'  => 'linkedin_url',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_footer_text',
                'label' => 'Footer Text',
                'name'  => 'footer_text',
                'type'  => 'textarea',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'acesso_register_acf_fields');

/**
 * Register ACF Options Page
 */
function acesso_register_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => __('Theme Options', 'acesso-uporto'),
        'menu_title' => __('Theme Options', 'acesso-uporto'),
        'menu_slug'  => 'theme-options',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-customizer',
    ));
}
add_action('acf/init', 'acesso_register_options_page');

/**
 * Register Custom Post Types
 * Note: The 'cursos' CPT is registered by the uporto-cursos-importer plugin
 * We only register additional CPTs here
 */
function acesso_register_post_types() {
    // Register cursos CPT if plugin is not active (fallback)
    if (!post_type_exists('cursos')) {
        register_post_type('cursos', array(
            'labels' => array(
                'name'          => __('Cursos', 'acesso-uporto'),
                'singular_name' => __('Curso', 'acesso-uporto'),
                'add_new'       => __('Adicionar Curso', 'acesso-uporto'),
                'add_new_item'  => __('Adicionar Novo Curso', 'acesso-uporto'),
                'edit_item'     => __('Editar Curso', 'acesso-uporto'),
                'view_item'     => __('Ver Curso', 'acesso-uporto'),
                'search_items'  => __('Pesquisar Cursos', 'acesso-uporto'),
            ),
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => array('slug' => 'cursos'),
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-welcome-learn-more',
        ));
    }

    // Testimonials CPT
    register_post_type('testimonial', array(
        'labels' => array(
            'name'          => __('Testemunhos', 'acesso-uporto'),
            'singular_name' => __('Testemunho', 'acesso-uporto'),
            'add_new'       => __('Adicionar Testemunho', 'acesso-uporto'),
            'add_new_item'  => __('Adicionar Novo Testemunho', 'acesso-uporto'),
            'edit_item'     => __('Editar Testemunho', 'acesso-uporto'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'supports'     => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-format-quote',
    ));
}
add_action('init', 'acesso_register_post_types');

/**
 * Register Taxonomies
 * Note: The 'faculdades' taxonomy is registered by the uporto-cursos-importer plugin
 */
function acesso_register_taxonomies() {
    // Register faculdades taxonomy if plugin is not active (fallback)
    if (!taxonomy_exists('faculdades')) {
        register_taxonomy('faculdades', 'cursos', array(
            'labels' => array(
                'name'          => __('Faculdades', 'acesso-uporto'),
                'singular_name' => __('Faculdade', 'acesso-uporto'),
                'search_items'  => __('Pesquisar Faculdades', 'acesso-uporto'),
                'all_items'     => __('Todas as Faculdades', 'acesso-uporto'),
                'edit_item'     => __('Editar Faculdade', 'acesso-uporto'),
                'add_new_item'  => __('Adicionar Nova Faculdade', 'acesso-uporto'),
            ),
            'hierarchical' => true,
            'public'       => true,
            'rewrite'      => array('slug' => 'faculdade'),
            'show_in_rest' => true,
        ));
    }
}
add_action('init', 'acesso_register_taxonomies');

/**
 * Custom Walker for Navigation
 */
class Acesso_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        $class_names = join(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array(
            'title'  => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel'    => !empty($item->xfn) ? $item->xfn : '',
            'href'   => !empty($item->url) ? $item->url : '',
        );

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $item_output = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Get Social Links
 */
function acesso_get_social_links() {
    $social = array();

    if (function_exists('get_field')) {
        $platforms = array('facebook', 'instagram', 'twitter', 'youtube', 'linkedin');

        foreach ($platforms as $platform) {
            $url = get_field($platform . '_url', 'option');
            if ($url) {
                $social[$platform] = $url;
            }
        }
    }

    return $social;
}

/**
 * Get SVG Icon
 */
function acesso_get_icon($name, $class = '') {
    $icons = array(
        'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>',
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>',
        'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33zM9.75 15.02V8.48L15.5 11.75l-5.75 3.27z"/></svg>',
        'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
        'calendar'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'edit'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
        'check'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
        'clock'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'star'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'plus'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
        'menu'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'close'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'play'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>',
    );

    if (!isset($icons[$name])) {
        return '';
    }

    $svg = $icons[$name];

    if ($class) {
        $svg = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $svg);
    }

    return $svg;
}

/**
 * Include Additional Files
 */
require_once ACESSO_THEME_DIR . '/inc/customizer.php';
require_once ACESSO_THEME_DIR . '/inc/acf-course-fields.php';
require_once ACESSO_THEME_DIR . '/inc/block-patterns.php';
require_once ACESSO_THEME_DIR . '/inc/github-update-check.php';
require_once ACESSO_THEME_DIR . '/inc/theme-updater-page.php';

// Cursos Importer (integrated from uporto-cursos-importer plugin)
require_once ACESSO_THEME_DIR . '/inc/importer/acf-cursos-fields.php';
require_once ACESSO_THEME_DIR . '/inc/importer/class-cursos-importer.php';

// Initialize the Cursos Importer in admin
if (is_admin()) {
    new Acesso_Cursos_Importer();
}

/**
 * Admin Notice for ACF
 */
function acesso_acf_notice() {
    if (!function_exists('acf_register_block_type')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Acesso U.Porto Theme:</strong> This theme requires Advanced Custom Fields PRO for full functionality. <a href="https://www.advancedcustomfields.com/pro/" target="_blank">Get ACF PRO</a></p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'acesso_acf_notice');

/**
 * Disable Gutenberg for certain post types
 */
function acesso_disable_gutenberg($can_edit, $post_type) {
    if (in_array($post_type, array('testimonial'))) {
        return false;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'acesso_disable_gutenberg', 10, 2);
