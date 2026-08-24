<?php
/**
 * Theme Customizer - Colors and Typography Options
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

// Preset de design system usado quando nada está escolhido.
if (!defined('ACESSO_DEFAULT_PRESET')) {
    define('ACESSO_DEFAULT_PRESET', 'retro-2026');
}

/**
 * Presets de design system.
 *
 * Cada campanha tem o seu. Para a campanha do ano seguinte acrescenta-se uma
 * entrada aqui e escolhe-se no Personalizador (Aparência → Design System) —
 * não é preciso mexer em CSS. Cada preset define os valores de arranque de
 * TODAS as opções de estilo; o que o utilizador guardar no Personalizador
 * sobrepõe-se ao preset, e "Repor as predefinições" apaga essas sobreposições
 * para o preset voltar a mandar.
 *
 * @return array<string, array{label: string, tokens: array<string, string>}>
 */
function acesso_style_presets() {
    return array(
        'retro-2026' => array(
            'label'  => __('Receção 2026 — Retro Gaming (8-bit)', 'acesso-uporto'),
            'tokens' => array(
                // Formas
                'acesso_corner_style'       => 'square',
                'acesso_border_width'       => '3',
                'acesso_shadow_style'       => 'hard',
                'acesso_shadow_offset'      => '6',
                'acesso_pixel_notch'        => '5',
                'acesso_texture'            => 'pixel',
                'acesso_section_rule'       => 'dashed',
                'acesso_display_shadow'     => 'hard',
                'acesso_ui_uppercase'       => '1',

                // Cores principais
                'acesso_color_primary'      => '#262261', // navy
                'acesso_color_secondary'    => '#E8196D', // magenta
                'acesso_color_dark'         => '#111111', // ink

                // Superfícies
                'acesso_color_accent'       => '#FFF100', // amarelo
                'acesso_color_panel'        => '#ededed',
                'acesso_color_paper'        => '#f1efe6',

                // Cores de destaque
                'acesso_color_cyan'         => '#00ADEE',
                'acesso_color_lavender'     => '#2B2E6F', // azul
                'acesso_color_coral'        => '#FF0000', // vermelho
                'acesso_color_lime'         => '#D6DE23',
                'acesso_color_green'        => '#009345',

                // Gradiente: plano (navy → navy)
                'acesso_gradient_start'     => '#262261',
                'acesso_gradient_end'       => '#262261',
                'acesso_gradient_direction' => '135deg',

                // Texto e elementos
                'acesso_color_text'         => '#111111',
                'acesso_color_heading'      => '#262261',
                'acesso_color_link'         => '#262261',
                'acesso_color_link_hover'   => '#E8196D',
                'acesso_color_button_bg'    => '#FFF100',
                'acesso_color_button_text'  => '#111111',

                // Tipografia: Jersey 10 (display) + Blinker (UI/corpo)
                'acesso_font_body'          => 'Blinker',
                'acesso_font_body_custom'   => '',
                'acesso_font_body_weight'   => '400',
                'acesso_font_heading'       => 'Jersey 10',
                'acesso_font_heading_custom' => '',
                'acesso_font_heading_weight' => '400',
                'acesso_font_menu'          => 'Jersey 10',
                'acesso_font_menu_custom'   => '',
                'acesso_font_footer'        => '',
                'acesso_font_footer_custom' => '',
                'acesso_font_size_base'     => '16',
                'acesso_font_heading_scale' => '100',
            ),
        ),

        'classico' => array(
            'label'  => __('Clássico — cantos suaves, gradiente', 'acesso-uporto'),
            'tokens' => array(
                // Formas
                'acesso_corner_style'       => 'rounded',
                'acesso_border_width'       => '0',
                'acesso_shadow_style'       => 'soft',
                'acesso_shadow_offset'      => '6',
                'acesso_pixel_notch'        => '0',
                'acesso_texture'            => 'none',
                'acesso_section_rule'       => 'none',
                'acesso_display_shadow'     => 'none',
                'acesso_ui_uppercase'       => '1',

                // Cores principais
                'acesso_color_primary'      => '#572ddf',
                'acesso_color_secondary'    => '#da2489',
                'acesso_color_dark'         => '#060221',

                // Superfícies
                'acesso_color_accent'       => '#efeaff',
                'acesso_color_panel'        => '#ffffff',
                'acesso_color_paper'        => '#ffffff',

                // Cores de destaque
                'acesso_color_cyan'         => '#00d084',
                'acesso_color_lavender'     => '#8887e2',
                'acesso_color_coral'        => '#ff6b6b',
                'acesso_color_lime'         => '#d6de23',
                'acesso_color_green'        => '#009345',

                // Gradiente da marca
                'acesso_gradient_start'     => '#572ddf',
                'acesso_gradient_end'       => '#da2489',
                'acesso_gradient_direction' => '135deg',

                // Texto e elementos
                'acesso_color_text'         => '#060221',
                'acesso_color_heading'      => '#060221',
                'acesso_color_link'         => '#572ddf',
                'acesso_color_link_hover'   => '#da2489',
                'acesso_color_button_bg'    => '#572ddf',
                'acesso_color_button_text'  => '#ffffff',

                // Tipografia
                'acesso_font_body'          => 'Barlow',
                'acesso_font_body_custom'   => '',
                'acesso_font_body_weight'   => '400',
                'acesso_font_heading'       => 'Barlow Semi Condensed',
                'acesso_font_heading_custom' => '',
                'acesso_font_heading_weight' => '700',
                'acesso_font_menu'          => '',
                'acesso_font_menu_custom'   => '',
                'acesso_font_footer'        => '',
                'acesso_font_footer_custom' => '',
                'acesso_font_size_base'     => '16',
                'acesso_font_heading_scale' => '100',
            ),
        ),
    );
}

/**
 * Preset de design system em uso.
 *
 * @return string
 */
function acesso_active_preset() {
    $preset  = get_theme_mod('acesso_style_preset', ACESSO_DEFAULT_PRESET);
    $presets = acesso_style_presets();
    return isset($presets[$preset]) ? $preset : ACESSO_DEFAULT_PRESET;
}

/**
 * Predefinições de estilo do preset ativo.
 *
 * Fonte única de verdade: usada pelos controlos do Personalizador, pelo CSS
 * gerado em acesso_customizer_css() e pela reposição em acesso_reset_design().
 *
 * Nota: `acesso_style_preset` não entra neste mapa de propósito — repor as
 * predefinições limpa as sobreposições, não a campanha escolhida.
 *
 * @return array<string, string>
 */
function acesso_theme_defaults() {
    $presets = acesso_style_presets();
    return $presets[acesso_active_preset()]['tokens'];
}

/**
 * Predefinição de uma opção do tema.
 *
 * @param string $key      Chave do theme_mod.
 * @param string $fallback Valor caso a chave não exista no mapa.
 * @return string
 */
function acesso_default($key, $fallback = '') {
    $defaults = acesso_theme_defaults();
    return array_key_exists($key, $defaults) ? $defaults[$key] : $fallback;
}

/**
 * Valor efetivo de uma opção: theme_mod guardado ou predefinição do preset.
 *
 * @param string $key Chave do theme_mod.
 * @return string
 */
function acesso_mod($key) {
    return get_theme_mod($key, acesso_default($key));
}

/**
 * Paleta do tema, derivada das opções em vigor.
 *
 * Usada pela paleta do editor (add_theme_support) e injetada no theme.json em
 * tempo de execução, para que o Gutenberg mostre sempre as cores da campanha
 * ativa em vez das que ficaram escritas no ficheiro.
 *
 * Os slugs antigos (purple/pink/lavender/coral) mantêm-se de propósito: há
 * conteúdo publicado com classes has-<slug>-background-color que partiria se
 * mudassem.
 *
 * @return array<int, array{slug: string, name: string, color: string}>
 */
function acesso_color_palette() {
    return array(
        array('slug' => 'purple',     'name' => __('Primária', 'acesso-uporto'),   'color' => acesso_mod('acesso_color_primary')),
        array('slug' => 'pink',       'name' => __('Secundária', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_secondary')),
        array('slug' => 'dark',       'name' => __('Contorno', 'acesso-uporto'),   'color' => acesso_mod('acesso_color_dark')),
        array('slug' => 'yellow',     'name' => __('Destaque', 'acesso-uporto'),   'color' => acesso_mod('acesso_color_accent')),
        array('slug' => 'cyan',       'name' => __('Destaque 1', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_cyan')),
        array('slug' => 'lavender',   'name' => __('Destaque 2', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_lavender')),
        array('slug' => 'coral',      'name' => __('Destaque 3', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_coral')),
        array('slug' => 'lime',       'name' => __('Destaque 4', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_lime')),
        array('slug' => 'green',      'name' => __('Destaque 5', 'acesso-uporto'), 'color' => acesso_mod('acesso_color_green')),
        array('slug' => 'light-gray', 'name' => __('Cartão', 'acesso-uporto'),     'color' => acesso_mod('acesso_color_panel')),
        array('slug' => 'paper',      'name' => __('Papel', 'acesso-uporto'),      'color' => acesso_mod('acesso_color_paper')),
        array('slug' => 'white',      'name' => __('Branco', 'acesso-uporto'),     'color' => '#ffffff'),
    );
}

/**
 * Gradientes do tema, derivados das opções em vigor.
 *
 * @return array<int, array{slug: string, name: string, gradient: string}>
 */
function acesso_color_gradients() {
    $start = acesso_mod('acesso_gradient_start');
    $end   = acesso_mod('acesso_gradient_end');
    $dir   = acesso_mod('acesso_gradient_direction');
    $dark  = acesso_mod('acesso_color_dark');

    return array(
        array(
            'slug'     => 'purple-pink',
            'name'     => __('Gradiente da marca', 'acesso-uporto'),
            'gradient' => sprintf('linear-gradient(%s, %s 0%%, %s 100%%)', $dir, $start, $end),
        ),
        array(
            'slug'     => 'pink-purple',
            'name'     => __('Gradiente da marca (invertido)', 'acesso-uporto'),
            'gradient' => sprintf('linear-gradient(%s, %s 0%%, %s 100%%)', $dir, $end, $start),
        ),
        array(
            'slug'     => 'purple-dark',
            'name'     => __('Marca para contorno', 'acesso-uporto'),
            'gradient' => sprintf('linear-gradient(180deg, %s 0%%, %s 100%%)', $start, $dark),
        ),
    );
}

/**
 * Injeta a paleta e os tipos em vigor no theme.json.
 *
 * O theme.json é um ficheiro estático e ganha à paleta do add_theme_support,
 * por isso sem este filtro o editor mostraria as cores da campanha de 2026
 * mesmo depois de o Personalizador as ter mudado.
 *
 * @param WP_Theme_JSON_Data $theme_json
 * @return WP_Theme_JSON_Data
 */
function acesso_filter_theme_json($theme_json) {
    $font_body    = acesso_mod('acesso_font_body_custom') ?: acesso_mod('acesso_font_body');
    $font_heading = acesso_mod('acesso_font_heading_custom') ?: acesso_mod('acesso_font_heading');

    return $theme_json->update_with(array(
        'version'  => 2,
        'settings' => array(
            'color' => array(
                // Reafirmados para que o seletor de cores continue a mostrar
                // só a paleta da campanha, como no theme.json.
                'defaultPalette'   => false,
                'defaultGradients' => false,
                'palette'          => acesso_color_palette(),
                'gradients'        => acesso_color_gradients(),
            ),
        ),
        'styles' => array(
            'typography' => array(
                'fontFamily' => sprintf("'%s', sans-serif", $font_body),
            ),
            'elements' => array(
                'h1' => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_heading))),
                'h2' => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_heading))),
                'h3' => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_body))),
                'h4' => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_body))),
            ),
            'blocks' => array(
                'core/heading' => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_heading))),
                'core/button'  => array('typography' => array('fontFamily' => sprintf("'%s', sans-serif", $font_body))),
            ),
        ),
    ));
}
add_filter('wp_theme_json_data_theme', 'acesso_filter_theme_json');

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
        'title'       => __('Aparência', 'acesso-uporto'),
        'description' => __('A linguagem visual da campanha: formas, sombras e textura. As cores e a tipografia estão nos painéis próprios.', 'acesso-uporto'),
        'priority'    => 25,
    ));

    // --- Design system da campanha ---
    $acesso_preset_choices = array();
    foreach (acesso_style_presets() as $acesso_preset_id => $acesso_preset) {
        $acesso_preset_choices[$acesso_preset_id] = $acesso_preset['label'];
    }
    $wp_customize->add_setting('acesso_style_preset', array(
        'default'           => ACESSO_DEFAULT_PRESET,
        'sanitize_callback' => 'acesso_sanitize_style_preset',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_style_preset', array(
        'label'       => __('Design System', 'acesso-uporto'),
        'description' => __('Define os valores de arranque de todas as opções de estilo. O que personalizares abaixo sobrepõe-se ao preset; "Repor as predefinições" limpa essas personalizações.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'select',
        'priority'    => 5,
        'choices'     => $acesso_preset_choices,
    ));

    $wp_customize->add_setting('acesso_corner_style', array(
        'default'           => acesso_default('acesso_corner_style'),
        'sanitize_callback' => 'acesso_sanitize_corner_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_corner_style', array(
        'label'       => __('Cantos', 'acesso-uporto'),
        'description' => __('Cantos das caixas, cartões e botões. (Ícones e avatares redondos mantêm-se.)', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'priority'    => 10,
        'choices'     => array(
            'square'  => __('Retangulares', 'acesso-uporto'),
            'rounded' => __('Redondos', 'acesso-uporto'),
        ),
    ));

    // --- Contorno ---
    $wp_customize->add_setting('acesso_border_width', array(
        'default'           => acesso_default('acesso_border_width'),
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_border_width', array(
        'label'       => __('Espessura do contorno (px)', 'acesso-uporto'),
        'description' => __('Contorno dos cartões, painéis e botões. 0 remove o contorno.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'number',
        'priority'    => 15,
        'input_attrs' => array('min' => 0, 'max' => 8, 'step' => 1),
    ));

    // --- Sombra ---
    $wp_customize->add_setting('acesso_shadow_style', array(
        'default'           => acesso_default('acesso_shadow_style'),
        'sanitize_callback' => 'acesso_sanitize_shadow_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_shadow_style', array(
        'label'       => __('Sombras', 'acesso-uporto'),
        'description' => __('Como as caixas assentam na página.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'priority'    => 20,
        'choices'     => array(
            'hard' => __('Dura (deslocada, sem desfoque)', 'acesso-uporto'),
            'soft' => __('Suave (desfocada)', 'acesso-uporto'),
            'none' => __('Sem sombra', 'acesso-uporto'),
        ),
    ));

    $wp_customize->add_setting('acesso_shadow_offset', array(
        'default'           => acesso_default('acesso_shadow_offset'),
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_shadow_offset', array(
        'label'       => __('Deslocamento da sombra (px)', 'acesso-uporto'),
        'description' => __('Só se aplica à sombra dura.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'number',
        'priority'    => 25,
        'input_attrs' => array('min' => 0, 'max' => 16, 'step' => 1),
    ));

    // --- Canto em pixel ---
    $wp_customize->add_setting('acesso_pixel_notch', array(
        'default'           => acesso_default('acesso_pixel_notch'),
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_pixel_notch', array(
        'label'       => __('Canto "mordido" dos botões (px)', 'acesso-uporto'),
        'description' => __('O recorte a pixel nos cantos dos botões. 0 desliga.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'number',
        'priority'    => 30,
        'input_attrs' => array('min' => 0, 'max' => 12, 'step' => 1),
    ));

    // --- Textura de fundo ---
    $wp_customize->add_setting('acesso_texture', array(
        'default'           => acesso_default('acesso_texture'),
        'sanitize_callback' => 'acesso_sanitize_texture',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_texture', array(
        'label'       => __('Textura de fundo', 'acesso-uporto'),
        'description' => __('Ruído de pixels no fundo do site e nas bandas escuras.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'priority'    => 35,
        'choices'     => array(
            'pixel' => __('Ruído de pixels', 'acesso-uporto'),
            'none'  => __('Sem textura', 'acesso-uporto'),
        ),
    ));

    // --- Régua dos títulos de secção ---
    $wp_customize->add_setting('acesso_section_rule', array(
        'default'           => acesso_default('acesso_section_rule'),
        'sanitize_callback' => 'acesso_sanitize_section_rule',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_section_rule', array(
        'label'       => __('Régua sob os títulos de secção', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'priority'    => 40,
        'choices'     => array(
            'dashed' => __('Tracejada a pixel', 'acesso-uporto'),
            'solid'  => __('Contínua', 'acesso-uporto'),
            'none'   => __('Nenhuma', 'acesso-uporto'),
        ),
    ));

    // --- Sombra dos títulos de display ---
    $wp_customize->add_setting('acesso_display_shadow', array(
        'default'           => acesso_default('acesso_display_shadow'),
        'sanitize_callback' => 'acesso_sanitize_display_shadow',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_display_shadow', array(
        'label'       => __('Sombra nos títulos grandes', 'acesso-uporto'),
        'description' => __('A sombra dura por baixo do título do hero e dos títulos de secção.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'radio',
        'priority'    => 45,
        'choices'     => array(
            'hard' => __('Dura', 'acesso-uporto'),
            'none' => __('Nenhuma', 'acesso-uporto'),
        ),
    ));

    // --- Caixa alta na interface ---
    $wp_customize->add_setting('acesso_ui_uppercase', array(
        'default'           => acesso_default('acesso_ui_uppercase'),
        'sanitize_callback' => 'acesso_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_ui_uppercase', array(
        'label'       => __('Interface em CAIXA ALTA', 'acesso-uporto'),
        'description' => __('Botões, navegação, etiquetas e nomes de cartões.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'checkbox',
        'priority'    => 50,
    ));

    // Reposição das predefinições do design system.
    $wp_customize->add_setting('acesso_reset_design', array(
        'default'           => false,
        'sanitize_callback' => 'acesso_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('acesso_reset_design', array(
        'label'       => __('Repor as predefinições do design system', 'acesso-uporto'),
        'description' => __('Ao guardar, apaga todas as personalizações de cor, forma e tipografia e volta aos valores do design system escolhido acima. Não afeta o logo, os menus nem os conteúdos.', 'acesso-uporto'),
        'section'     => 'acesso_appearance',
        'type'        => 'checkbox',
        'priority'    => 90,
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
        'default'           => acesso_default('acesso_color_primary'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_primary', array(
        'label'    => __('Cor Primária', 'acesso-uporto'),
        'description' => __('A cor da marca: bandas escuras, cabeçalho, títulos e links.', 'acesso-uporto'),
        'section'  => 'acesso_primary_colors',
    )));

    // Secondary Color (Pink)
    $wp_customize->add_setting('acesso_color_secondary', array(
        'default'           => acesso_default('acesso_color_secondary'),
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
        'default'           => acesso_default('acesso_color_dark'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_dark', array(
        'label'    => __('Cor de Contorno', 'acesso-uporto'),
        'description' => __('O preto do design system: contornos, sombras duras, rodapé e texto do corpo.', 'acesso-uporto'),
        'section'  => 'acesso_primary_colors',
    )));

    // --- Text & Element Colors Section ---
    $wp_customize->add_section('acesso_text_colors', array(
        'title'    => __('Cores de Texto e Elementos', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 15,
    ));

    $acesso_text_color_fields = array(
        'acesso_color_text'        => array(__('Cor do Texto', 'acesso-uporto'), __('Cor do texto do corpo.', 'acesso-uporto')),
        'acesso_color_heading'     => array(__('Cor dos Títulos', 'acesso-uporto'), __('Cor dos títulos e cabeçalhos.', 'acesso-uporto')),
        'acesso_color_link'        => array(__('Cor dos Links', 'acesso-uporto'), __('Cor das ligações.', 'acesso-uporto')),
        'acesso_color_link_hover'  => array(__('Cor dos Links (rato em cima)', 'acesso-uporto'), __('Cor das ligações no hover.', 'acesso-uporto')),
        'acesso_color_button_bg'   => array(__('Fundo dos Botões', 'acesso-uporto'), __('Cor de fundo dos botões primários.', 'acesso-uporto')),
        'acesso_color_button_text' => array(__('Texto dos Botões', 'acesso-uporto'), __('Cor do texto dos botões primários.', 'acesso-uporto')),
    );
    foreach ($acesso_text_color_fields as $acesso_tc_id => $acesso_tc_cfg) {
        $wp_customize->add_setting($acesso_tc_id, array(
            'default'           => acesso_default($acesso_tc_id),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $acesso_tc_id, array(
            'label'       => $acesso_tc_cfg[0],
            'description' => $acesso_tc_cfg[1],
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
        'default'           => acesso_default('acesso_color_cyan'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_cyan', array(
        'label'       => __('Destaque 1 (Cyan)', 'acesso-uporto'),
        'description' => __('Ícones, botões secundários e barras de nível.', 'acesso-uporto'),
        'section'     => 'acesso_accent_colors',
    )));

    // Lavender
    $wp_customize->add_setting('acesso_color_lavender', array(
        'default'           => acesso_default('acesso_color_lavender'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_lavender', array(
        'label'       => __('Destaque 2 (Azul)', 'acesso-uporto'),
        'description' => __('Fundos de vídeo e de imagens em falta.', 'acesso-uporto'),
        'section'     => 'acesso_accent_colors',
    )));

    // Coral
    $wp_customize->add_setting('acesso_color_coral', array(
        'default'           => acesso_default('acesso_color_coral'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_coral', array(
        'label'       => __('Destaque 3 (Vermelho)', 'acesso-uporto'),
        'description' => __('Alertas e a terceira fase da timeline.', 'acesso-uporto'),
        'section'     => 'acesso_accent_colors',
    )));

    // Lima
    $wp_customize->add_setting('acesso_color_lime', array(
        'default'           => acesso_default('acesso_color_lime'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_lime', array(
        'label'       => __('Destaque 4 (Lima)', 'acesso-uporto'),
        'description' => __('Disponível na paleta do editor.', 'acesso-uporto'),
        'section'     => 'acesso_accent_colors',
    )));

    // Verde
    $wp_customize->add_setting('acesso_color_green', array(
        'default'           => acesso_default('acesso_color_green'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_color_green', array(
        'label'       => __('Destaque 5 (Verde)', 'acesso-uporto'),
        'description' => __('Estados de sucesso e barras de progresso.', 'acesso-uporto'),
        'section'     => 'acesso_accent_colors',
    )));

    // --- Superfícies ---
    $wp_customize->add_section('acesso_surface_colors', array(
        'title'       => __('Superfícies', 'acesso-uporto'),
        'description' => __('Os fundos sobre os quais tudo assenta.', 'acesso-uporto'),
        'panel'       => 'acesso_colors_panel',
        'priority'    => 18,
    ));

    $acesso_surface_fields = array(
        'acesso_color_accent' => array(
            __('Cor de Destaque', 'acesso-uporto'),
            __('A cor "de aviso" do design system: etiquetas, hover de botões e chips ativos.', 'acesso-uporto'),
        ),
        'acesso_color_panel'  => array(
            __('Fundo dos Cartões', 'acesso-uporto'),
            __('Painéis, cartões e caixas de conteúdo.', 'acesso-uporto'),
        ),
        'acesso_color_paper'  => array(
            __('Fundo do Site', 'acesso-uporto'),
            __('O fundo geral das páginas, por baixo da textura.', 'acesso-uporto'),
        ),
    );
    foreach ($acesso_surface_fields as $acesso_sf_id => $acesso_sf_cfg) {
        $wp_customize->add_setting($acesso_sf_id, array(
            'default'           => acesso_default($acesso_sf_id),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $acesso_sf_id, array(
            'label'       => $acesso_sf_cfg[0],
            'description' => $acesso_sf_cfg[1],
            'section'     => 'acesso_surface_colors',
        )));
    }

    // --- Gradient Section ---
    $wp_customize->add_section('acesso_gradient_colors', array(
        'title'    => __('Gradiente Principal', 'acesso-uporto'),
        'panel'    => 'acesso_colors_panel',
        'priority' => 30,
    ));

    // Gradient Start Color
    $wp_customize->add_setting('acesso_gradient_start', array(
        'default'           => acesso_default('acesso_gradient_start'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_gradient_start', array(
        'label'   => __('Cor Inicial do Gradiente', 'acesso-uporto'),
        'section' => 'acesso_gradient_colors',
    )));

    // Gradient End Color
    $wp_customize->add_setting('acesso_gradient_end', array(
        'default'           => acesso_default('acesso_gradient_end'),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'acesso_gradient_end', array(
        'label'   => __('Cor Final do Gradiente', 'acesso-uporto'),
        'section' => 'acesso_gradient_colors',
    )));

    // Gradient Direction
    $wp_customize->add_setting('acesso_gradient_direction', array(
        'default'           => acesso_default('acesso_gradient_direction'),
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
        'default'           => acesso_default('acesso_font_body'),
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
        'default'           => acesso_default('acesso_font_body_weight'),
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
        'default'           => acesso_default('acesso_font_heading'),
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
        'default'           => acesso_default('acesso_font_heading_weight'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_font_heading_weight', array(
        'label'   => __('Peso da Fonte', 'acesso-uporto'),
        'description' => __('A Jersey 10 só existe em Regular (400); os outros pesos não têm efeito com essa fonte.', 'acesso-uporto'),
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
        'default'           => acesso_default('acesso_font_size_base'),
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acesso_font_size_base', array(
        'label'   => __('Tamanho do Texto do Corpo (px)', 'acesso-uporto'),
        'description' => __('Tamanho base (baseline). Todo o texto em rem escala a partir daqui; textos com tamanho próprio fixo mantêm-se.', 'acesso-uporto'),
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
        'default'           => acesso_default('acesso_font_heading_scale'),
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
        'Jersey 10'           => 'Jersey 10',
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
 * Sanitiza uma caixa de verificação do Personalizador.
 */
function acesso_sanitize_checkbox($value) {
    return (bool) $value;
}

/**
 * Repõe as predefinições do design system depois de guardar o Personalizador.
 *
 * A caixa "Repor as predefinições do tema" não guarda estado: quando marcada,
 * apagam-se os theme_mods de cor/tipografia para que voltem a valer os valores
 * de acesso_theme_defaults().
 *
 * @param WP_Customize_Manager $wp_customize
 */
function acesso_reset_design($wp_customize) {
    $setting = $wp_customize->get_setting('acesso_reset_design');
    if (!$setting || !$setting->post_value()) {
        return;
    }
    foreach (array_keys(acesso_theme_defaults()) as $key) {
        remove_theme_mod($key);
    }
    remove_theme_mod('acesso_reset_design');
}
add_action('customize_save_after', 'acesso_reset_design');

/**
 * Sanitiza a opção de estilo de cantos.
 */
function acesso_sanitize_corner_style($value) {
    return in_array($value, array('rounded', 'square'), true)
        ? $value
        : acesso_default('acesso_corner_style', 'square');
}

/**
 * Sanitiza o preset de design system.
 */
function acesso_sanitize_style_preset($value) {
    return isset(acesso_style_presets()[$value]) ? $value : ACESSO_DEFAULT_PRESET;
}

/**
 * Sanitiza o estilo de sombra.
 */
function acesso_sanitize_shadow_style($value) {
    return in_array($value, array('hard', 'soft', 'none'), true)
        ? $value
        : acesso_default('acesso_shadow_style', 'hard');
}

/**
 * Sanitiza a textura de fundo.
 */
function acesso_sanitize_texture($value) {
    return in_array($value, array('pixel', 'none'), true)
        ? $value
        : acesso_default('acesso_texture', 'pixel');
}

/**
 * Sanitiza o estilo da régua dos títulos de secção.
 */
function acesso_sanitize_section_rule($value) {
    return in_array($value, array('dashed', 'solid', 'none'), true)
        ? $value
        : acesso_default('acesso_section_rule', 'dashed');
}

/**
 * Sanitiza a sombra dos títulos de display.
 */
function acesso_sanitize_display_shadow($value) {
    return in_array($value, array('hard', 'none'), true)
        ? $value
        : acesso_default('acesso_display_shadow', 'hard');
}

/**
 * Output custom CSS from Customizer settings
 */
function acesso_customizer_css() {
    // Get settings
    $primary      = acesso_mod('acesso_color_primary');
    $secondary    = acesso_mod('acesso_color_secondary');
    $dark         = acesso_mod('acesso_color_dark');
    $cyan         = acesso_mod('acesso_color_cyan');
    $lavender     = acesso_mod('acesso_color_lavender');
    $coral        = acesso_mod('acesso_color_coral');
    $lime         = acesso_mod('acesso_color_lime');
    $green        = acesso_mod('acesso_color_green');

    // Superfícies.
    $accent = acesso_mod('acesso_color_accent');
    $panel  = acesso_mod('acesso_color_panel');
    $paper  = acesso_mod('acesso_color_paper');

    $gradient_start = acesso_mod('acesso_gradient_start');
    $gradient_end   = acesso_mod('acesso_gradient_end');
    $gradient_dir   = acesso_mod('acesso_gradient_direction');

    // Cores de texto e elementos.
    $color_text        = acesso_mod('acesso_color_text');
    $color_heading     = acesso_mod('acesso_color_heading');
    $color_link        = acesso_mod('acesso_color_link');
    $color_link_hover  = acesso_mod('acesso_color_link_hover');
    $color_button_bg   = acesso_mod('acesso_color_button_bg');
    $color_button_text = acesso_mod('acesso_color_button_text');

    $font_body         = acesso_mod('acesso_font_body_custom') ?: acesso_mod('acesso_font_body');
    $font_body_weight  = acesso_mod('acesso_font_body_weight');
    $font_heading      = acesso_mod('acesso_font_heading_custom') ?: acesso_mod('acesso_font_heading');
    $font_heading_weight = acesso_mod('acesso_font_heading_weight');
    $font_size_base    = acesso_mod('acesso_font_size_base');

    // Fontes específicas (opcionais) do menu e do rodapé.
    $font_menu   = acesso_mod('acesso_font_menu_custom') ?: acesso_mod('acesso_font_menu');
    $font_footer = acesso_mod('acesso_font_footer_custom') ?: acesso_mod('acesso_font_footer');

    // Escala dos títulos (multiplicador). 100 = sem alteração.
    $heading_scale_pct = absint(acesso_mod('acesso_font_heading_scale'));
    $heading_scale_pct = max(50, min(200, $heading_scale_pct ?: 100));
    $heading_scale     = round($heading_scale_pct / 100, 3);

    // ---- Forma: contorno, sombra, canto em pixel, textura ----
    $corner_style   = acesso_sanitize_corner_style(acesso_mod('acesso_corner_style'));
    $border_width   = max(0, min(8, absint(acesso_mod('acesso_border_width'))));
    $shadow_style   = acesso_sanitize_shadow_style(acesso_mod('acesso_shadow_style'));
    $shadow_offset  = max(0, min(16, absint(acesso_mod('acesso_shadow_offset'))));
    $pixel_notch    = max(0, min(12, absint(acesso_mod('acesso_pixel_notch'))));
    $texture        = acesso_sanitize_texture(acesso_mod('acesso_texture'));
    $section_rule   = acesso_sanitize_section_rule(acesso_mod('acesso_section_rule'));
    $display_shadow = acesso_sanitize_display_shadow(acesso_mod('acesso_display_shadow'));
    $ui_uppercase   = (bool) acesso_mod('acesso_ui_uppercase');

    // As três sombras do sistema, na linguagem escolhida.
    if ($shadow_style === 'hard') {
        $sh_sm = sprintf('%1$dpx %1$dpx 0 %2$s', max(1, $shadow_offset - 2), $dark);
        $sh    = sprintf('%1$dpx %1$dpx 0 %2$s', $shadow_offset, $dark);
        $sh_lg = sprintf('%1$dpx %1$dpx 0 %2$s', $shadow_offset + 2, $dark);
    } elseif ($shadow_style === 'soft') {
        $sh_sm = '0 2px 6px rgba(0, 0, 0, 0.10)';
        $sh    = '0 4px 16px rgba(0, 0, 0, 0.14)';
        $sh_lg = '0 10px 30px rgba(0, 0, 0, 0.18)';
    } else {
        $sh_sm = $sh = $sh_lg = 'none';
    }

    // Textura: ruído de pixels gerado por SVG, ou nenhuma.
    $noise = function ($r, $g, $b, $a) {
        return "url(\"data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120'>"
             . "<filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.5' numOctaves='2' stitchTiles='stitch'/>"
             . "<feColorMatrix values='0 0 0 0 {$r}  0 0 0 0 {$g}  0 0 0 0 {$b}  0 0 0 {$a} 0'/></filter>"
             . "<rect width='120' height='120' filter='url(%23n)'/></svg>\")";
    };
    $noise_paper = $texture === 'pixel' ? $noise('0.55', '0.54', '0.48', '0.12') : 'none';
    $noise_navy  = $texture === 'pixel' ? $noise('0.15', '0.13', '0.38', '0.5') : 'none';

    // Régua sob os títulos de secção.
    if ($section_rule === 'dashed') {
        $rule_bg   = "repeating-linear-gradient(90deg, {$dark} 0 14px, transparent 14px 22px)";
        $rule_bg_d = "repeating-linear-gradient(90deg, {$accent} 0 14px, transparent 14px 22px)";
    } elseif ($section_rule === 'solid') {
        $rule_bg   = $dark;
        $rule_bg_d = $accent;
    } else {
        $rule_bg = $rule_bg_d = 'none';
    }

    ?>
    <style type="text/css" id="acesso-customizer-css">
        :root {
            /* Paleta — os nomes de token que o CSS do tema usa */
            --color-navy: <?php echo esc_attr($primary); ?>;
            --color-magenta: <?php echo esc_attr($secondary); ?>;
            --color-ink: <?php echo esc_attr($dark); ?>;
            --color-cyan: <?php echo esc_attr($cyan); ?>;
            --color-blue: <?php echo esc_attr($lavender); ?>;
            --color-red: <?php echo esc_attr($coral); ?>;
            --color-lime: <?php echo esc_attr($lime); ?>;
            --color-green: <?php echo esc_attr($green); ?>;
            --color-yellow: <?php echo esc_attr($accent); ?>;
            --color-panel: <?php echo esc_attr($panel); ?>;
            --color-paper: <?php echo esc_attr($paper); ?>;

            /* Papéis semânticos */
            --color-primary: <?php echo esc_attr($primary); ?>;
            --color-secondary: <?php echo esc_attr($secondary); ?>;
            --color-dark: <?php echo esc_attr($dark); ?>;
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
            --font-ui: '<?php echo esc_attr($font_body); ?>', sans-serif;
            /* Sobrepor os presets do theme.json (usados por headings e blocos via .wp-block-*) */
            --wp--preset--font-family--jersey-10: '<?php echo esc_attr($font_heading); ?>', sans-serif;
            --wp--preset--font-family--blinker: '<?php echo esc_attr($font_body); ?>', sans-serif;
            --wp--preset--font-family--barlow: '<?php echo esc_attr($font_body); ?>', sans-serif;
            --wp--preset--font-family--barlow-condensed: '<?php echo esc_attr($font_heading); ?>', sans-serif;
            --font-body-weight: <?php echo esc_attr($font_body_weight); ?>;
            --font-heading-weight: <?php echo esc_attr($font_heading_weight); ?>;
            --font-size-base: <?php echo esc_attr($font_size_base); ?>px;
            --ui-text-transform: <?php echo $ui_uppercase ? 'uppercase' : 'none'; ?>;

            /* Forma */
            --border-width: <?php echo esc_attr($border_width); ?>px;
            --border-hard: <?php echo $border_width ? 'var(--border-width) solid var(--color-ink)' : 'none'; ?>;
            --border-band: <?php echo $border_width ? sprintf('%dpx solid var(--color-ink)', $border_width + 1) : 'none'; ?>;
            --border-band-accent: <?php echo $border_width ? sprintf('%dpx solid var(--color-yellow)', $border_width + 1) : 'none'; ?>;
            --shadow-offset: <?php echo esc_attr($shadow_offset); ?>px;
            --shadow-hard-sm: <?php echo esc_attr($sh_sm); ?>;
            --shadow-hard: <?php echo esc_attr($sh); ?>;
            --shadow-hard-lg: <?php echo esc_attr($sh_lg); ?>;
            --shadow-sm: <?php echo esc_attr($sh_sm); ?>;
            --shadow-md: <?php echo esc_attr($sh); ?>;
            --shadow-lg: <?php echo esc_attr($sh_lg); ?>;

            /* Textura de fundo */
            --noise-paper: <?php echo $noise_paper; ?>;
            --noise-navy: <?php echo $noise_navy; ?>;
            --texture-rendering: <?php echo $texture === 'pixel' ? 'pixelated' : 'auto'; ?>;

            /* Régua dos títulos de secção */
            --section-rule: <?php echo $rule_bg; ?>;
            --section-rule-on-dark: <?php echo $rule_bg_d; ?>;
            --section-rule-display: <?php echo $section_rule === 'none' ? 'none' : 'block'; ?>;

            /* Sombra dos títulos de display */
<?php if ($display_shadow === 'hard') : ?>
            /* Em em, não em px: uma sombra de 7px que fica bem num título de
               138px lê-se como texto duplicado num de 32px no telemóvel. */
            --text-shadow-hero: 0.05em 0.05em 0 var(--color-ink);
            --text-shadow-display: 0.06em 0.06em 0 var(--color-ink);
            --text-shadow-section: 0.06em 0.06em 0 rgba(17, 17, 17, 0.18);
            --text-shadow-section-on-dark: 0.06em 0.06em 0 rgba(17, 17, 17, 0.35);
<?php else : ?>
            --text-shadow-hero: none;
            --text-shadow-display: none;
            --text-shadow-section: none;
            --text-shadow-section-on-dark: none;
<?php endif; ?>

            /* Cantos */
<?php if ($corner_style === 'rounded') : ?>
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 16px;
            --radius-full: 50px;
<?php else : ?>
            --radius-sm: 0;
            --radius-md: 0;
            --radius-lg: 0;
            --radius-full: 0;
<?php endif; ?>

            /* Canto "mordido" a pixel dos botões. O clip-path recorta tudo o
               que é pintado a seguir, incluindo a sombra, por isso o polígono
               de --pixel-clip-shadow inclui a goteira onde ela assenta. */
<?php if ($pixel_notch > 0) : ?>
            --pixel-notch: <?php echo esc_attr($pixel_notch); ?>px;
            --pixel-clip: polygon(
                0 var(--pixel-notch), var(--pixel-notch) var(--pixel-notch), var(--pixel-notch) 0,
                calc(100% - var(--pixel-notch)) 0, calc(100% - var(--pixel-notch)) var(--pixel-notch),
                100% var(--pixel-notch), 100% calc(100% - var(--pixel-notch)),
                calc(100% - var(--pixel-notch)) calc(100% - var(--pixel-notch)),
                calc(100% - var(--pixel-notch)) 100%, var(--pixel-notch) 100%,
                var(--pixel-notch) calc(100% - var(--pixel-notch)), 0 calc(100% - var(--pixel-notch))
            );
<?php if ($shadow_style === 'hard' && $shadow_offset > 0) : ?>
            --pixel-clip-shadow: polygon(
                0 var(--pixel-notch), var(--pixel-notch) var(--pixel-notch), var(--pixel-notch) 0,
                calc(100% - var(--pixel-notch)) 0, calc(100% - var(--pixel-notch)) var(--pixel-notch),
                100% var(--pixel-notch), 100% var(--shadow-offset),
                calc(100% + var(--shadow-offset)) var(--shadow-offset),
                calc(100% + var(--shadow-offset)) calc(100% + var(--shadow-offset)),
                var(--shadow-offset) calc(100% + var(--shadow-offset)),
                var(--shadow-offset) 100%, var(--pixel-notch) 100%,
                var(--pixel-notch) calc(100% - var(--pixel-notch)), 0 calc(100% - var(--pixel-notch))
            );
<?php else : ?>
            --pixel-clip-shadow: var(--pixel-clip);
<?php endif; ?>
<?php else : ?>
            --pixel-notch: 0px;
            --pixel-clip: none;
            --pixel-clip-shadow: none;
<?php endif; ?>
        }

        /* Apply font family */
<?php if ((int) $font_size_base !== 16) : ?>
        /* Baseline: a raiz define o tamanho base para que todo o texto em rem
           escale (exceto o que tenha tamanho próprio fixo). */
        html { font-size: <?php echo esc_attr($font_size_base); ?>px; }
<?php endif; ?>
        body {
            font-family: var(--font-primary);
            font-weight: var(--font-body-weight);
            font-size: var(--font-size-base);
            color: var(--color-text);
        }

        /* Display (H1/H2, títulos de secção e hero) usa a fonte dos títulos.
           H3–H6 ficam na fonte de UI a 900, que se lê bem em corpo pequeno. */
        h1, h2,
        .section-title,
        .hero-title,
        .stat-number,
        .statistics-section .stat-number,
        .cta-title,
        .timeline-title,
        .course-detail-title {
            font-family: var(--font-display);
            font-weight: var(--font-heading-weight);
        }

        h3, h4, h5, h6 {
            font-family: var(--font-ui);
            font-weight: 900;
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
<?php if ($font_menu === $font_heading) : ?>
        /* O menu está na fonte de display (por predefinição, Jersey 10). Uma
           fonte de pixels precisa de mais corpo e de peso normal para se ler
           em caixa alta; estes valores só se aplicam neste caso.
           O tamanho é fluido porque o menu horizontal só dá lugar ao
           hamburger aos 992px, e entre os 993px e os 1400px não há espaço
           para o corpo máximo. */
        #site-navigation .nav-menu a,
        .main-navigation .nav-menu a {
            font-size: clamp(0.9375rem, 1.5vw, 1.375rem);
            font-weight: 400;
            letter-spacing: 0.03em;
        }

        @media (max-width: 1200px) {
            #site-navigation .nav-menu,
            .main-navigation .nav-menu {
                gap: var(--spacing-sm);
            }
        }

        @media (max-width: 992px) {
            #site-navigation .nav-menu a,
            .main-navigation .nav-menu a {
                font-size: 2rem;
            }

            #site-navigation .nav-menu,
            .main-navigation .nav-menu {
                gap: var(--spacing-md);
            }
        }
<?php endif; ?>
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
            border: var(--border-hard);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-hard);
            clip-path: var(--pixel-clip-shadow);
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
    $font_body    = acesso_mod('acesso_font_body_custom') ?: acesso_mod('acesso_font_body');
    $font_heading = acesso_mod('acesso_font_heading_custom') ?: acesso_mod('acesso_font_heading');

    $font_menu   = acesso_mod('acesso_font_menu_custom') ?: acesso_mod('acesso_font_menu');
    $font_footer = acesso_mod('acesso_font_footer_custom') ?: acesso_mod('acesso_font_footer');

    // Fontes já auto-alojadas no tema (assets/fonts/fonts.css) — não pedir à Google.
    $bundled = array(
        'Jersey 10', 'Blinker', 'Barlow', 'Barlow Semi Condensed',
        'Inter', 'Poppins', 'Montserrat', 'Roboto', 'Playfair Display',
        'Lora', 'Merriweather', 'Oswald', 'Bebas Neue', 'Pixelify Sans',
    );

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

