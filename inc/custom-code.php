<?php
/**
 * Código Personalizado — CSS, JavaScript e código de Analytics.
 *
 * Acrescenta ao Personalizador um painel onde se pode injetar:
 *   - CSS personalizado (impresso no <head> dentro de <style>);
 *   - Código no <head> (meta tags, verificações, Google Analytics/GTM, etc.);
 *   - Código logo após a abertura do <body> (ex.: <noscript> do GTM);
 *   - Código antes de </body> (scripts de fim de página, chat, pixels).
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sanitiza CSS personalizado: remove tags HTML para não fechar o <style>.
 */
function acesso_sanitize_custom_css($css) {
    return wp_strip_all_tags((string) $css);
}

/**
 * Sanitiza código bruto (HTML/JS).
 *
 * Só quem tem a capacidade `unfiltered_html` (tipicamente administradores em
 * instalações single-site) pode guardar <script> e outro código arbitrário.
 * Para os restantes, aplica-se wp_kses_post por segurança.
 */
function acesso_sanitize_custom_code($code) {
    $code = (string) $code;
    if (current_user_can('unfiltered_html')) {
        return $code;
    }
    return wp_kses_post($code);
}

/**
 * Regista o painel e os controlos de código personalizado.
 */
function acesso_custom_code_customize_register($wp_customize) {

    $wp_customize->add_panel('acesso_custom_code_panel', array(
        'title'       => __('Código Personalizado', 'acesso-uporto'),
        'description' => __('Adicione CSS, JavaScript e código de analytics (Google Analytics, GTM, Meta Pixel, etc.). Use com cuidado: código inválido pode afetar o site.', 'acesso-uporto'),
        'priority'    => 200,
    ));

    // --- CSS personalizado ---
    $wp_customize->add_section('acesso_custom_css_section', array(
        'title'    => __('CSS Personalizado', 'acesso-uporto'),
        'panel'    => 'acesso_custom_code_panel',
        'priority' => 10,
    ));
    $wp_customize->add_setting('acesso_custom_css', array(
        'default'           => '',
        'sanitize_callback' => 'acesso_sanitize_custom_css',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_custom_css', array(
        'label'       => __('CSS Personalizado', 'acesso-uporto'),
        'description' => __('Regras CSS aplicadas a todo o site (sem etiquetas <style>). É impresso no <head> depois do CSS do tema.', 'acesso-uporto'),
        'section'     => 'acesso_custom_css_section',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows'           => 10,
            'spellcheck'     => 'false',
            'autocapitalize' => 'off',
            'autocomplete'   => 'off',
            'style'          => 'font-family: monospace;',
        ),
    ));

    // --- Código no <head> ---
    $wp_customize->add_section('acesso_head_code_section', array(
        'title'    => __('Código no <head>', 'acesso-uporto'),
        'panel'    => 'acesso_custom_code_panel',
        'priority' => 20,
    ));
    $wp_customize->add_setting('acesso_head_code', array(
        'default'           => '',
        'sanitize_callback' => 'acesso_sanitize_custom_code',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_head_code', array(
        'label'       => __('Código no <head>', 'acesso-uporto'),
        'description' => __('Ex.: Google Analytics (gtag.js), etiqueta principal do Google Tag Manager, meta tags de verificação. Cole o código completo, incluindo <script>.', 'acesso-uporto'),
        'section'     => 'acesso_head_code_section',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows'           => 8,
            'spellcheck'     => 'false',
            'autocapitalize' => 'off',
            'autocomplete'   => 'off',
            'style'          => 'font-family: monospace;',
        ),
    ));

    // --- Código após a abertura do <body> ---
    $wp_customize->add_section('acesso_body_open_code_section', array(
        'title'    => __('Código após <body>', 'acesso-uporto'),
        'panel'    => 'acesso_custom_code_panel',
        'priority' => 30,
    ));
    $wp_customize->add_setting('acesso_body_open_code', array(
        'default'           => '',
        'sanitize_callback' => 'acesso_sanitize_custom_code',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_body_open_code', array(
        'label'       => __('Código após a abertura do <body>', 'acesso-uporto'),
        'description' => __('Ex.: a etiqueta <noscript> do Google Tag Manager, que deve ficar logo a seguir à abertura do <body>.', 'acesso-uporto'),
        'section'     => 'acesso_body_open_code_section',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows'           => 6,
            'spellcheck'     => 'false',
            'autocapitalize' => 'off',
            'autocomplete'   => 'off',
            'style'          => 'font-family: monospace;',
        ),
    ));

    // --- Código antes de </body> ---
    $wp_customize->add_section('acesso_footer_code_section', array(
        'title'    => __('Código antes de </body>', 'acesso-uporto'),
        'panel'    => 'acesso_custom_code_panel',
        'priority' => 40,
    ));
    $wp_customize->add_setting('acesso_footer_code', array(
        'default'           => '',
        'sanitize_callback' => 'acesso_sanitize_custom_code',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_footer_code', array(
        'label'       => __('Código antes de </body>', 'acesso-uporto'),
        'description' => __('Ex.: scripts que devem carregar no fim da página (chat, pixels de conversão, scripts de terceiros).', 'acesso-uporto'),
        'section'     => 'acesso_footer_code_section',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows'           => 8,
            'spellcheck'     => 'false',
            'autocapitalize' => 'off',
            'autocomplete'   => 'off',
            'style'          => 'font-family: monospace;',
        ),
    ));
}
add_action('customize_register', 'acesso_custom_code_customize_register');

/**
 * Imprime o CSS personalizado no <head> (a seguir ao CSS do Personalizador).
 */
function acesso_output_custom_css() {
    $css = get_theme_mod('acesso_custom_css', '');
    if (trim($css) === '') {
        return;
    }
    echo "\n<style id=\"acesso-custom-css\">\n" . wp_strip_all_tags($css) . "\n</style>\n";
}
add_action('wp_head', 'acesso_output_custom_css', 101);

/**
 * Imprime o código do <head> (analytics, GTM, meta tags).
 */
function acesso_output_head_code() {
    if (is_admin()) {
        return;
    }
    $code = get_theme_mod('acesso_head_code', '');
    if (trim($code) !== '') {
        echo "\n" . $code . "\n";
    }
}
add_action('wp_head', 'acesso_output_head_code', 99);

/**
 * Imprime o código logo após a abertura do <body> (ex.: <noscript> do GTM).
 */
function acesso_output_body_open_code() {
    $code = get_theme_mod('acesso_body_open_code', '');
    if (trim($code) !== '') {
        echo "\n" . $code . "\n";
    }
}
add_action('wp_body_open', 'acesso_output_body_open_code', 5);

/**
 * Imprime o código antes de </body> (scripts de fim de página).
 */
function acesso_output_footer_code() {
    if (is_admin()) {
        return;
    }
    $code = get_theme_mod('acesso_footer_code', '');
    if (trim($code) !== '') {
        echo "\n" . $code . "\n";
    }
}
add_action('wp_footer', 'acesso_output_footer_code', 99);
