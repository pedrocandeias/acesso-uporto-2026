<?php
/**
 * Theme Customizer - Colors and Typography Options
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer settings
 */
function acesso_customize_register($wp_customize) {

    // =====================================================
    // LOGO & IDENTITY SECTION
    // =====================================================
    // O logo e o favicon usam a "Identidade do Site" do WordPress
    // (custom_logo + site_icon). Aqui só se acrescenta a altura do logo
    // a essa mesma secção, para não haver controlos de logo duplicados.
    $wp_customize->add_setting('acesso_logo_height', array(
        'default'           => '50',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_logo_height', array(
        'label'       => __('Altura do Logo (px)', 'acesso-uporto'),
        'description' => __('Altura máxima do logo no cabeçalho.', 'acesso-uporto'),
        'section'     => 'title_tagline',
        'type'        => 'number',
        'priority'    => 8,
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 150,
            'step' => 5,
        ),
    ));

    // =====================================================
    // APARÊNCIA
    // =====================================================
    $wp_customize->add_section('acesso_appearance', array(
        'title'    => __('Aparência', 'acesso-uporto'),
        'priority' => 25,
    ));
    $wp_customize->add_setting('acesso_corner_style', array(
        'default'           => 'rounded',
        'sanitize_callback' => 'acesso_sanitize_corner_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_corner_style', array(
        'label'       => __('Cantos', 'acesso-uporto'),
        'description' => __('Cantos das caixas, cartões e botões. (Ícones e avatares redondos mantêm-se.)', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'choices'     => array(
            'rounded' => __('Redondos (predefinição)', 'acesso-uporto'),
            'square'  => __('Retangulares', 'acesso-uporto'),
        ),
    ));

    // =====================================================
    // COLORS PANEL
    // =====================================================
    $wp_customize->add_panel('acesso_colors_panel', array(
        'title'       => __('Cores do Tema', 'acesso-uporto'),
        'description' => __('Personalize as cores do tema.', 'acesso-uporto'),
        'priority'    => 30,
    ));

    // --- Primary Colors Section ---
    $wp_customize->add_section('acesso_primary_colors', array(
        'title'    => __('Cores Principais', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 10,
    ));

    // Primary Color (Purple)
    $wp_customize->add_setting('acesso_color_primary', array(
        'default'           => '#572ddf',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_primary', array(
        'label'    => __('Cor Primária', 'acesso-uporto'),
        'description' => __('Cor principal do tema (botões, links, destaques).', 'acesso-uporto'),
        'section'  => 'acesso_primary_colors',
    )));

    // Secondary Color (Pink)
    $wp_customize->add_setting('acesso_color_secondary', array(
        'default'           => '#da2489',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_secondary', array(
        'label'    => __('Cor Secundária', 'acesso-uporto'),
        'description' => __('Cor secundária (hover, acentos).', 'acesso-uporto'),
        'section'  => 'acesso_primary_colors',
    )));

    // Dark Color
    $wp_customize->add_setting('acesso_color_dark', array(
        'default'           => '#060221',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_dark', array(
        'label'    => __('Cor Escura', 'acesso-uporto'),
        'description' => __('Cor para textos e fundos escuros.', 'acesso-uporto'),
        'section'  => 'acesso_primary_colors',
    )));

    // --- Text & Element Colors Section ---
    $wp_customize->add_section('acesso_text_colors', array(
        'title'    => __('Cores de Texto e Elementos', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 15,
    ));

    $acesso_text_color_fields = array(
        'acesso_color_text'        => array('#060221', __('Cor do Texto', 'acesso-uporto'), __('Cor do texto do corpo.', 'acesso-uporto')),
        'acesso_color_heading'     => array('#060221', __('Cor dos Títulos', 'acesso-uporto'), __('Cor dos títulos e cabeçalhos.', 'acesso-uporto')),
        'acesso_color_link'        => array('#572ddf', __('Cor dos Links', 'acesso-uporto'), __('Cor das ligações.', 'acesso-uporto')),
        'acesso_color_link_hover'  => array('#da2489', __('Cor dos Links (rato em cima)', 'acesso-uporto'), __('Cor das ligações no hover.', 'acesso-uporto')),
        'acesso_color_button_bg'   => array('#572ddf', __('Fundo dos Botões', 'acesso-uporto'), __('Cor de fundo dos botões primários.', 'acesso-uporto')),
        'acesso_color_button_text' => array('#ffffff', __('Texto dos Botões', 'acesso-uporto'), __('Cor do texto dos botões primários.', 'acesso-uporto')),
    );
    foreach ($acesso_text_color_fields as $acesso_tc_id => $acesso_tc_cfg) {
        $wp_customize->add_setting($acesso_tc_id, array(
            'default'           => $acesso_tc_cfg[0],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $acesso_tc_id, array(
            'label'       => $acesso_tc_cfg[1],
            'description' => $acesso_tc_cfg[2],
            'section'     => 'acesso_text_colors',
        )));
    }

    // --- Accent Colors Section ---
    $wp_customize->add_section('acesso_accent_colors', array(
        'title'    => __('Cores de Destaque', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 20,
    ));

    // Cyan
    $wp_customize->add_setting('acesso_color_cyan', array(
        'default'           => '#00d084',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_cyan', array(
        'label'   => __('Cyan / Verde', 'acesso-uporto'),
        'section' => 'acesso_accent_colors',
    )));

    // Lavender
    $wp_customize->add_setting('acesso_color_lavender', array(
        'default'           => '#8887e2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_lavender', array(
        'label'   => __('Lavanda', 'acesso-uporto'),
        'section' => 'acesso_accent_colors',
    )));

    // Coral
    $wp_customize->add_setting('acesso_color_coral', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_coral', array(
        'label'   => __('Coral', 'acesso-uporto'),
        'section' => 'acesso_accent_colors',
    )));

    // --- Gradient Section ---
    $wp_customize->add_section('acesso_gradient_colors', array(
        'title'    => __('Gradiente Principal', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 30,
    ));

    // Gradient Start Color
    $wp_customize->add_setting('acesso_gradient_start', array(
        'default'           => '#572ddf',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_gradient_start', array(
        'label'   => __('Cor Inicial do Gradiente', 'acesso-uporto'),
        'section' => 'acesso_gradient_colors',
    )));

    // Gradient End Color
    $wp_customize->add_setting('acesso_gradient_end', array(
        'default'           => '#da2489',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_gradient_end', array(
        'label'   => __('Cor Final do Gradiente', 'acesso-uporto'),
        'section' => 'acesso_gradient_colors',
    )));

    // Gradient Direction
    $wp_customize->add_setting('acesso_gradient_direction', array(
        'default'           => '135deg',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_gradient_direction', array(
        'label'   => __('Direção do Gradiente', 'acesso-uporto'),
        'section' => 'acesso_gradient_colors',
        'type'    => 'select',
        'choices' => array(
            '90deg'  => __('Horizontal (esquerda para direita)', 'acesso-uporto'),
            '180deg' => __('Vertical (cima para baixo)', 'acesso-uporto'),
            '135deg' => __('Diagonal (padrão)', 'acesso-uporto'),
            '45deg'  => __('Diagonal invertida', 'acesso-uporto'),
            '0deg'   => __('Vertical (baixo para cima)', 'acesso-uporto'),
        ),
    ));

    // =====================================================
    // TYPOGRAPHY PANEL
    // =====================================================
    $wp_customize->add_panel('acesso_typography_panel', array(
        'title'       => __('Tipografia', 'acesso-uporto'),
        'description' => __('Personalize as fontes do tema.', 'acesso-uporto'),
        'priority'    => 35,
    ));

    // --- Body Font Section ---
    $wp_customize->add_section('acesso_body_font', array(
        'title'    => __('Fonte do Corpo', 'acesso-uporto'),
        'panel'    => 'acesso_typography_panel',
        'priority' => 10,
    ));

    // Body Font Family
    $wp_customize->add_setting('acesso_font_body', array(
        'default'           => 'Barlow',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_body', array(
        'label'   => __('Fonte Principal', 'acesso-uporto'),
        'description' => __('Fonte usada para textos do corpo.', 'acesso-uporto'),
        'section' => 'acesso_body_font',
        'type'    => 'select',
        'choices' => acesso_get_google_fonts_list(),
    ));

    // Body Font — nome personalizado (qualquer Google Font)
    $wp_customize->add_setting('acesso_font_body_custom', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_body_custom', array(
        'label'       => __('Ou outra Google Font', 'acesso-uporto'),
        'description' => __('Escreve o nome exato de qualquer fonte de fonts.google.com (ex.: Blinker). Se preenchido, ignora a lista acima.', 'acesso-uporto'),
        'section'     => 'acesso_body_font',
        'type'        => 'text',
        'input_attrs' => array(
            'autocomplete'   => 'off',
            'autocorrect'    => 'off',
            'autocapitalize' => 'off',
            'spellcheck'     => 'false',
            'data-lpignore'  => 'true',
            'data-1p-ignore' => 'true',
            'data-form-type' => 'other',
        ),
    ));

    // Body Font Weight
    $wp_customize->add_setting('acesso_font_body_weight', array(
        'default'           => '400',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_font_body_weight', array(
        'label'   => __('Peso da Fonte', 'acesso-uporto'),
        'section' => 'acesso_body_font',
        'type'    => 'select',
        'choices' => array(
            '300' => __('Light (300)', 'acesso-uporto'),
            '400' => __('Regular (400)', 'acesso-uporto'),
            '500' => __('Medium (500)', 'acesso-uporto'),
            '600' => __('Semi-Bold (600)', 'acesso-uporto'),
            '700' => __('Bold (700)', 'acesso-uporto'),
        ),
    ));

    // --- Heading Font Section ---
    $wp_customize->add_section('acesso_heading_font', array(
        'title'    => __('Fonte dos Títulos', 'acesso-uporto'),
        'panel'    => 'acesso_typography_panel',
        'priority' => 20,
    ));

    // Heading Font Family
    $wp_customize->add_setting('acesso_font_heading', array(
        'default'           => 'Barlow Semi Condensed',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_heading', array(
        'label'   => __('Fonte dos Títulos', 'acesso-uporto'),
        'description' => __('Fonte usada para títulos H1-H6.', 'acesso-uporto'),
        'section' => 'acesso_heading_font',
        'type'    => 'select',
        'choices' => acesso_get_google_fonts_list(),
    ));

    // Heading Font — nome personalizado (qualquer Google Font)
    $wp_customize->add_setting('acesso_font_heading_custom', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_heading_custom', array(
        'label'       => __('Ou outra Google Font', 'acesso-uporto'),
        'description' => __('Escreve o nome exato de qualquer fonte de fonts.google.com (ex.: Pixelify Sans). Se preenchido, ignora a lista acima.', 'acesso-uporto'),
        'section'     => 'acesso_heading_font',
        'type'        => 'text',
        'input_attrs' => array(
            'autocomplete'   => 'off',
            'autocorrect'    => 'off',
            'autocapitalize' => 'off',
            'spellcheck'     => 'false',
            'data-lpignore'  => 'true',
            'data-1p-ignore' => 'true',
            'data-form-type' => 'other',
        ),
    ));

    // Heading Font Weight
    $wp_customize->add_setting('acesso_font_heading_weight', array(
        'default'           => '700',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_font_heading_weight', array(
        'label'   => __('Peso da Fonte', 'acesso-uporto'),
        'section' => 'acesso_heading_font',
        'type'    => 'select',
        'choices' => array(
            '400' => __('Regular (400)', 'acesso-uporto'),
            '500' => __('Medium (500)', 'acesso-uporto'),
            '600' => __('Semi-Bold (600)', 'acesso-uporto'),
            '700' => __('Bold (700)', 'acesso-uporto'),
            '800' => __('Extra-Bold (800)', 'acesso-uporto'),
            '900' => __('Black (900)', 'acesso-uporto'),
        ),
    ));

    // --- Menu Font Section ---
    $wp_customize->add_section('acesso_menu_font', array(
        'title'    => __('Fonte do Menu', 'acesso-uporto'),
        'panel'    => 'acesso_typography_panel',
        'priority' => 22,
    ));
    $wp_customize->add_setting('acesso_font_menu', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_menu', array(
        'label'       => __('Fonte do Menu', 'acesso-uporto'),
        'description' => __('Menu de navegação do cabeçalho. Deixa em "(usar predefinição)" para herdar.', 'acesso-uporto'),
        'section'     => 'acesso_menu_font',
        'type'        => 'select',
        'choices'     => array_merge(array('' => __('(usar predefinição)', 'acesso-uporto')), acesso_get_google_fonts_list()),
    ));
    $wp_customize->add_setting('acesso_font_menu_custom', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_menu_custom', array(
        'label'       => __('Ou outra Google Font', 'acesso-uporto'),
        'description' => __('Nome exato de qualquer fonte de fonts.google.com. Se preenchido, ignora a lista acima.', 'acesso-uporto'),
        'section'     => 'acesso_menu_font',
        'type'        => 'text',
        'input_attrs' => array(
            'autocomplete'   => 'off',
            'autocorrect'    => 'off',
            'autocapitalize' => 'off',
            'spellcheck'     => 'false',
            'data-lpignore'  => 'true',
            'data-1p-ignore' => 'true',
            'data-form-type' => 'other',
        ),
    ));

    // --- Footer Font Section ---
    $wp_customize->add_section('acesso_footer_font', array(
        'title'    => __('Fonte do Rodapé', 'acesso-uporto'),
        'panel'    => 'acesso_typography_panel',
        'priority' => 24,
    ));
    $wp_customize->add_setting('acesso_font_footer', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_footer', array(
        'label'       => __('Fonte do Rodapé', 'acesso-uporto'),
        'description' => __('Rodapé do site. Deixa em "(usar predefinição)" para herdar.', 'acesso-uporto'),
        'section'     => 'acesso_footer_font',
        'type'        => 'select',
        'choices'     => array_merge(array('' => __('(usar predefinição)', 'acesso-uporto')), acesso_get_google_fonts_list()),
    ));
    $wp_customize->add_setting('acesso_font_footer_custom', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_footer_custom', array(
        'label'       => __('Ou outra Google Font', 'acesso-uporto'),
        'description' => __('Nome exato de qualquer fonte de fonts.google.com. Se preenchido, ignora a lista acima.', 'acesso-uporto'),
        'section'     => 'acesso_footer_font',
        'type'        => 'text',
        'input_attrs' => array(
            'autocomplete'   => 'off',
            'autocorrect'    => 'off',
            'autocapitalize' => 'off',
            'spellcheck'     => 'false',
            'data-lpignore'  => 'true',
            'data-1p-ignore' => 'true',
            'data-form-type' => 'other',
        ),
    ));

    // --- Font Size Section ---
    $wp_customize->add_section('acesso_font_sizes', array(
        'title'    => __('Tamanhos de Fonte', 'acesso-uporto'),
        'panel'    => 'acesso_typography_panel',
        'priority' => 30,
    ));

    // Base Font Size
    $wp_customize->add_setting('acesso_font_size_base', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_font_size_base', array(
        'label'   => __('Tamanho do Texto do Corpo (px)', 'acesso-uporto'),
        'description' => __('Tamanho base do texto do corpo em pixels.', 'acesso-uporto'),
        'section' => 'acesso_font_sizes',
        'type'    => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Heading Scale (multiplicador dos títulos)
    $wp_customize->add_setting('acesso_font_heading_scale', array(
        'default'           => '100',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_font_heading_scale', array(
        'label'       => __('Escala dos Títulos (%)', 'acesso-uporto'),
        'description' => __('Aumenta ou diminui todos os títulos proporcionalmente, mantendo a responsividade. 100% = tamanho original.', 'acesso-uporto'),
        'section'     => 'acesso_font_sizes',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 70,
            'max'  => 160,
            'step' => 5,
        ),
    ));
}
add_action('customize_register', 'acesso_customize_register');

/**
 * Get list of popular Google Fonts
 */
function acesso_get_google_fonts_list() {
    return array(
        // Sans-serif fonts
        'Barlow'              => 'Barlow',
        'Barlow Semi Condensed' => 'Barlow Semi Condensed',
        'Barlow Condensed'    => 'Barlow Condensed',
        'Inter'               => 'Inter',
        'Roboto'              => 'Roboto',
        'Open Sans'           => 'Open Sans',
        'Lato'                => 'Lato',
        'Montserrat'          => 'Montserrat',
        'Poppins'             => 'Poppins',
        'Nunito'              => 'Nunito',
        'Nunito Sans'         => 'Nunito Sans',
        'Raleway'             => 'Raleway',
        'Ubuntu'              => 'Ubuntu',
        'Source Sans Pro'     => 'Source Sans Pro',
        'Work Sans'           => 'Work Sans',
        'Rubik'               => 'Rubik',
        'Outfit'              => 'Outfit',
        'DM Sans'             => 'DM Sans',
        'Plus Jakarta Sans'   => 'Plus Jakarta Sans',
        'Space Grotesk'       => 'Space Grotesk',
        'Manrope'             => 'Manrope',
        'Figtree'             => 'Figtree',
        'Blinker'             => 'Blinker',
        'Mulish'              => 'Mulish',
        'Karla'               => 'Karla',
        'Kanit'               => 'Kanit',
        'Josefin Sans'        => 'Josefin Sans',
        'Quicksand'           => 'Quicksand',
        'Cabin'               => 'Cabin',
        'Fira Sans'           => 'Fira Sans',
        'PT Sans'             => 'PT Sans',
        'Titillium Web'       => 'Titillium Web',
        'Sora'                => 'Sora',
        'Lexend'              => 'Lexend',
        'Public Sans'         => 'Public Sans',
        'Red Hat Display'     => 'Red Hat Display',
        'Albert Sans'         => 'Albert Sans',
        'Onest'               => 'Onest',
        'Schibsted Grotesk'   => 'Schibsted Grotesk',
        // Serif fonts
        'Playfair Display'    => 'Playfair Display',
        'Merriweather'        => 'Merriweather',
        'Lora'                => 'Lora',
        'PT Serif'            => 'PT Serif',
        'Libre Baskerville'   => 'Libre Baskerville',
        'Source Serif Pro'    => 'Source Serif Pro',
        'Crimson Text'        => 'Crimson Text',
        'EB Garamond'         => 'EB Garamond',
        'Cormorant Garamond'  => 'Cormorant Garamond',
        'Bitter'              => 'Bitter',
        'Spectral'            => 'Spectral',
        'Frank Ruhl Libre'    => 'Frank Ruhl Libre',
        // Display / decorative fonts
        'Oswald'              => 'Oswald',
        'Bebas Neue'          => 'Bebas Neue',
        'Anton'               => 'Anton',
        'Archivo Black'       => 'Archivo Black',
        'Pixelify Sans'       => 'Pixelify Sans',
        'Righteous'           => 'Righteous',
        'Fredoka'             => 'Fredoka',
        'Comfortaa'           => 'Comfortaa',
        'Bungee'              => 'Bungee',
        'Press Start 2P'      => 'Press Start 2P',
        'Orbitron'            => 'Orbitron',
        'Audiowide'           => 'Audiowide',
        'Sixtyfour'           => 'Sixtyfour',
        'Silkscreen'          => 'Silkscreen',
        'VT323'               => 'VT323',
        'Monoton'             => 'Monoton',
        'Lobster'             => 'Lobster',
        'Pacifico'            => 'Pacifico',
        'Caveat'              => 'Caveat',
        'Dancing Script'      => 'Dancing Script',
        'Permanent Marker'    => 'Permanent Marker',
        // Monospace
        'JetBrains Mono'      => 'JetBrains Mono',
        'Space Mono'          => 'Space Mono',
        'IBM Plex Mono'       => 'IBM Plex Mono',
        'Roboto Mono'         => 'Roboto Mono',
    );
}

/**
 * Sanitiza a opção de estilo de cantos.
 */
function acesso_sanitize_corner_style($value) {
    return in_array($value, array('rounded', 'square'), true) ? $value : 'rounded';
}

/**
 * Output custom CSS from Customizer settings
 */
function acesso_customizer_css() {
    // Get settings
    $primary      = get_theme_mod('acesso_color_primary', '#572ddf');
    $secondary    = get_theme_mod('acesso_color_secondary', '#da2489');
    $dark         = get_theme_mod('acesso_color_dark', '#060221');
    $cyan         = get_theme_mod('acesso_color_cyan', '#00d084');
    $lavender     = get_theme_mod('acesso_color_lavender', '#8887e2');
    $coral        = get_theme_mod('acesso_color_coral', '#ff6b6b');

    $gradient_start = get_theme_mod('acesso_gradient_start', '#572ddf');
    $gradient_end   = get_theme_mod('acesso_gradient_end', '#da2489');
    $gradient_dir   = get_theme_mod('acesso_gradient_direction', '135deg');

    // Cores de texto e elementos.
    $color_text        = get_theme_mod('acesso_color_text', '#060221');
    $color_heading     = get_theme_mod('acesso_color_heading', '#060221');
    $color_link        = get_theme_mod('acesso_color_link', '#572ddf');
    $color_link_hover  = get_theme_mod('acesso_color_link_hover', '#da2489');
    $color_button_bg   = get_theme_mod('acesso_color_button_bg', '#572ddf');
    $color_button_text = get_theme_mod('acesso_color_button_text', '#ffffff');

    $font_body         = get_theme_mod('acesso_font_body_custom', '') ?: get_theme_mod('acesso_font_body', 'Barlow');
    $font_body_weight  = get_theme_mod('acesso_font_body_weight', '400');
    $font_heading      = get_theme_mod('acesso_font_heading_custom', '') ?: get_theme_mod('acesso_font_heading', 'Barlow Semi Condensed');
    $font_heading_weight = get_theme_mod('acesso_font_heading_weight', '700');
    $font_size_base    = get_theme_mod('acesso_font_size_base', '16');

    // Fontes específicas (opcionais) do menu e do rodapé.
    $font_menu   = get_theme_mod('acesso_font_menu_custom', '') ?: get_theme_mod('acesso_font_menu', '');
    $font_footer = get_theme_mod('acesso_font_footer_custom', '') ?: get_theme_mod('acesso_font_footer', '');

    // Escala dos títulos (multiplicador). 100 = sem alteração.
    $heading_scale_pct = absint(get_theme_mod('acesso_font_heading_scale', 100));
    $heading_scale_pct = max(50, min(200, $heading_scale_pct ?: 100));
    $heading_scale     = round($heading_scale_pct / 100, 3);

    // Estilo dos cantos (redondos por defeito / retangulares).
    $corner_style = acesso_sanitize_corner_style(get_theme_mod('acesso_corner_style', 'rounded'));

    ?>
    <style type="text/css" id="acesso-customizer-css">
        :root {
            /* Colors */
            --color-primary: <?php echo esc_attr($primary); ?>;
            --color-secondary: <?php echo esc_attr($secondary); ?>;
            --color-dark: <?php echo esc_attr($dark); ?>;
            --color-cyan: <?php echo esc_attr($cyan); ?>;
            --color-lavender: <?php echo esc_attr($lavender); ?>;
            --color-coral: <?php echo esc_attr($coral); ?>;

            /* Text & element colors */
            --color-text: <?php echo esc_attr($color_text); ?>;
            --color-heading: <?php echo esc_attr($color_heading); ?>;
            --color-link: <?php echo esc_attr($color_link); ?>;
            --color-link-hover: <?php echo esc_attr($color_link_hover); ?>;
            --color-btn-bg: <?php echo esc_attr($color_button_bg); ?>;
            --color-btn-text: <?php echo esc_attr($color_button_text); ?>;

            /* Legacy color names for compatibility */
            --color-purple: <?php echo esc_attr($primary); ?>;
            --color-pink: <?php echo esc_attr($secondary); ?>;

            /* Gradient */
            --gradient-primary: linear-gradient(<?php echo esc_attr($gradient_dir); ?>, <?php echo esc_attr($gradient_start); ?> 0%, <?php echo esc_attr($gradient_end); ?> 100%);

            /* Typography */
            --font-primary: '<?php echo esc_attr($font_body); ?>', sans-serif;
            --font-condensed: '<?php echo esc_attr($font_heading); ?>', sans-serif;
            --font-display: '<?php echo esc_attr($font_heading); ?>', sans-serif;
            /* Sobrepor os presets do theme.json (usados por headings e blocos via .wp-block-*) */
            --wp--preset--font-family--barlow: '<?php echo esc_attr($font_body); ?>', sans-serif;
            --wp--preset--font-family--barlow-condensed: '<?php echo esc_attr($font_heading); ?>', sans-serif;
            --font-body-weight: <?php echo esc_attr($font_body_weight); ?>;
            --font-heading-weight: <?php echo esc_attr($font_heading_weight); ?>;
            --font-size-base: <?php echo esc_attr($font_size_base); ?>px;
<?php if ($corner_style === 'square') : ?>
            /* Cantos retangulares: anula os raios das caixas/cartões/botões */
            --radius-sm: 0;
            --radius-md: 0;
            --radius-lg: 0;
            --radius-full: 0;
<?php endif; ?>
        }

        /* Apply font family */
        body {
            font-family: var(--font-primary);
            font-weight: var(--font-body-weight);
            font-size: var(--font-size-base);
            color: var(--color-text);
        }

        h1, h2, h3, h4, h5, h6,
        .section-title,
        .hero-title {
            font-family: var(--font-display);
            font-weight: var(--font-heading-weight);
        }

        /* Cor dos títulos/cabeçalhos (.hero-title fica branco sobre o hero) */
        h1, h2, h3, h4, h5, h6, .wp-block-heading,
        .section-title, .feature-title, .icon-box-title, .faq-question,
        .stat-value, .statistics-section .stat-number, .timeline-title,
        .testimonial-name, .course-name, .phase-value {
            color: var(--color-heading);
        }
<?php if ($heading_scale_pct !== 100) : ?>
        /* Escala dos títulos (mantém o clamp responsivo, multiplicado). */
        :root { --heading-scale: <?php echo esc_attr($heading_scale); ?>; }
        :root .hero-title    { font-size: calc(clamp(3rem, 10vw, 8rem) * var(--heading-scale, 1)); }
        :root .section-title { font-size: calc(clamp(2rem, 4vw, 3rem) * var(--heading-scale, 1)); }
        :root h1 { font-size: calc(clamp(2.5rem, 5vw, 3.5rem) * var(--heading-scale, 1)); }
        :root h2 { font-size: calc(clamp(2rem, 4vw, 2.75rem) * var(--heading-scale, 1)); }
        :root h3 { font-size: calc(clamp(1.5rem, 3vw, 2rem) * var(--heading-scale, 1)); }
        :root h4 { font-size: calc(1.5rem * var(--heading-scale, 1)); }
<?php endif; ?>
<?php if ($font_menu) : ?>
        /* Fonte específica do menu */
        #site-navigation .nav-menu,
        #site-navigation .nav-menu a,
        .main-navigation .nav-menu,
        .main-navigation .nav-menu a {
            font-family: '<?php echo esc_attr($font_menu); ?>', sans-serif;
        }
<?php endif; ?>
<?php if ($font_footer) : ?>
        /* Fonte específica do rodapé */
        .site-footer,
        .site-footer a,
        .site-footer p,
        .footer-copyright {
            font-family: '<?php echo esc_attr($font_footer); ?>', sans-serif;
        }
<?php endif; ?>

        /* Apply colors */
        a {
            color: var(--color-link);
        }
        a:hover {
            color: var(--color-link-hover);
        }

        .btn-primary,
        button[type="submit"],
        input[type="submit"] {
            background: var(--color-btn-bg);
            color: var(--color-btn-text);
        }
        .btn-primary:hover,
        button[type="submit"]:hover,
        input[type="submit"]:hover {
            background: var(--color-btn-bg);
            filter: brightness(0.92);
        }

        /* Gradient backgrounds */
        .has-gradient-background,
        .hero-section,
        .cta-section.style-gradient {
            background: var(--gradient-primary);
        }

        /* Badge colors */
        .badge-destaque {
            background: var(--color-primary);
        }
        .badge-novo {
            background: var(--color-secondary);
        }

        /* Stat highlights */
        .stat-highlight .stat-value,
        .stat-highlight .phase-value {
            color: var(--color-primary);
        }

        /* Logo */
        .site-logo img,
        .custom-logo {
            max-height: <?php echo esc_attr(get_theme_mod('acesso_logo_height', '50')); ?>px;
            width: auto;
        }
    </style>
    <?php
}
add_action('wp_head', 'acesso_customizer_css', 100);

/**
 * Enqueue Google Fonts based on Customizer settings
 */
function acesso_customizer_fonts() {
    $font_body    = get_theme_mod('acesso_font_body_custom', '') ?: get_theme_mod('acesso_font_body', 'Barlow');
    $font_heading = get_theme_mod('acesso_font_heading_custom', '') ?: get_theme_mod('acesso_font_heading', 'Barlow Semi Condensed');

    $font_menu   = get_theme_mod('acesso_font_menu_custom', '') ?: get_theme_mod('acesso_font_menu', '');
    $font_footer = get_theme_mod('acesso_font_footer_custom', '') ?: get_theme_mod('acesso_font_footer', '');

    // Fontes já auto-alojadas no tema (assets/fonts/fonts.css) — não pedir à Google.
    $bundled = array('Barlow', 'Barlow Semi Condensed');

    // Construir só as fontes ADICIONAIS (não incluídas) para carregar da Google.
    $fonts = array();
    if ($font_body && !in_array($font_body, $bundled, true)) {
        $fonts[$font_body] = $font_body . ':wght@300;400;500;600;700';
    }
    if ($font_heading && !in_array($font_heading, $bundled, true) && !isset($fonts[$font_heading])) {
        $fonts[$font_heading] = $font_heading . ':wght@400;500;600;700;800;900';
    }
    foreach (array($font_menu, $font_footer) as $extra) {
        if ($extra && !in_array($extra, $bundled, true) && !isset($fonts[$extra])) {
            $fonts[$extra] = $extra . ':wght@300;400;500;600;700';
        }
    }

    // Se todas as fontes escolhidas já estão auto-alojadas, não há pedido à Google.
    if (empty($fonts)) {
        return;
    }

    $font_families = array_values($fonts);
    $font_string = implode('&family=', array_map('urlencode', $font_families));
    $google_fonts_url = 'https://fonts.googleapis.com/css2?family=' . $font_string . '&display=swap';

    wp_enqueue_style(
        'acesso-customizer-fonts',
        $google_fonts_url,
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'acesso_customizer_fonts', 5);

/**
 * Live preview JS for Customizer
 */
function acesso_customizer_preview_js() {
    wp_enqueue_script(
        'acesso-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview', 'jquery'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'acesso_customizer_preview_js');

/**
 * Get theme logo
 *
 * @param string $type 'default' or 'light' for dark backgrounds
 * @return string Logo HTML or empty string
 */
function acesso_get_logo() {
    // Usa o logo do core (Identidade do Site → custom_logo).
    $logo_id = get_theme_mod('custom_logo');
    if (!$logo_id) {
        return '';
    }
    $logo_url = wp_get_attachment_image_url($logo_id, 'full');
    if (!$logo_url) {
        return '';
    }
    $logo_height = get_theme_mod('acesso_logo_height', '50');

    return sprintf(
        '<a href="%s" class="site-logo custom-logo-link" rel="home"><img src="%s" alt="%s" class="custom-logo" style="max-height: %spx; width: auto;"></a>',
        esc_url(home_url('/')),
        esc_url($logo_url),
        esc_attr(get_bloginfo('name')),
        esc_attr($logo_height)
    );
}

