<?php
/**
 * Hero Section Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$background_image = $attributes['backgroundImage'] ?? '';
$rotating_words = $attributes['rotatingWords'] ?? ['Conhecimento', 'Investigação', 'Inovação', 'Futuro'];
$static_text_before = $attributes['staticTextBefore'] ?? 'ISTO É';
$main_title = $attributes['mainTitle'] ?? 'U.PORTO';
$tagline = $attributes['tagline'] ?? '...e tu também podes ser!';
$primary_btn_text = $attributes['primaryButtonText'] ?? 'Explorar Cursos';
$primary_btn_url = $attributes['primaryButtonUrl'] ?? '#cursos';
$secondary_btn_text = $attributes['secondaryButtonText'] ?? '';
$secondary_btn_url = $attributes['secondaryButtonUrl'] ?? '';
$use_gradient = $attributes['useGradient'] ?? true;
$gradient_start = $attributes['gradientStart'] ?? '#572ddf';
$gradient_end = $attributes['gradientEnd'] ?? '#da2489';
$overlay_opacity = ($attributes['overlayOpacity'] ?? 70) / 100;

// Cor de fundo: gradiente ou cor sólida (gradientStart) conforme o toggle.
$fill_bg = $use_gradient
    ? 'linear-gradient(135deg, ' . $gradient_start . ', ' . $gradient_end . ')'
    : $gradient_start;
$min_height = $attributes['minHeight'] ?? '100vh';

$bg_size       = $attributes['backgroundSize'] ?? 'cover';
$bg_position   = $attributes['backgroundPosition'] ?? 'center center';
$bg_repeat     = $attributes['backgroundRepeat'] ?? 'no-repeat';
$bg_attachment = $attributes['backgroundAttachment'] ?? 'scroll';

// Cores e tamanhos por elemento (aplicados só quando definidos).
$acesso_el_style = function ($color, $size) {
    $s = '';
    if ($color) { $s .= 'color:' . $color . ';'; }
    if ($size)  { $s .= 'font-size:' . $size . ';'; }
    return $s ? ' style="' . esc_attr($s) . '"' : '';
};
$rotating_style = $acesso_el_style($attributes['rotatingColor'] ?? '', $attributes['rotatingSize'] ?? '');
$title_style    = $acesso_el_style($attributes['titleColor'] ?? '', $attributes['titleSize'] ?? '');
$tagline_style  = $acesso_el_style($attributes['taglineColor'] ?? '', $attributes['taglineSize'] ?? '');

$btn_size            = $attributes['buttonSize'] ?? '';
$primary_btn_bg      = $attributes['primaryBtnBg'] ?? '';
$primary_btn_color   = $attributes['primaryBtnColor'] ?? '';
$secondary_btn_color = $attributes['secondaryBtnColor'] ?? '';

$primary_btn_css = '';
if ($primary_btn_bg)    { $primary_btn_css .= 'background:' . $primary_btn_bg . ';'; }
if ($primary_btn_color) { $primary_btn_css .= 'color:' . $primary_btn_color . ';'; }
if ($btn_size)          { $primary_btn_css .= 'font-size:' . $btn_size . ';'; }
$primary_btn_style = $primary_btn_css ? ' style="' . esc_attr($primary_btn_css) . '"' : '';

$secondary_btn_css = '';
if ($secondary_btn_color) { $secondary_btn_css .= 'color:' . $secondary_btn_color . ';border-color:' . $secondary_btn_color . ';'; }
if ($btn_size)            { $secondary_btn_css .= 'font-size:' . $btn_size . ';'; }
$secondary_btn_style = $secondary_btn_css ? ' style="' . esc_attr($secondary_btn_css) . '"' : '';

// Fundo de pixels (sobrepõe a imagem carregada quando escolhido).
$pixel_bg = $attributes['pixelBackground'] ?? '';
$pixel_colors = array('gold', 'navy', 'coral', 'purple', 'pink', 'cyan', 'red', 'yellow');
if ($pixel_bg && in_array($pixel_bg, $pixel_colors, true)) {
    $pixel_path = ACESSO_THEME_DIR . '/assets/images/pixel-bg/pixel-' . $pixel_bg . '.svg';
    $pixel_ver  = file_exists($pixel_path) ? filemtime($pixel_path) : ACESSO_THEME_VERSION;
    $background_image = ACESSO_THEME_URI . '/assets/images/pixel-bg/pixel-' . $pixel_bg . '.svg?ver=' . $pixel_ver;
}

$block_id = 'hero-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'hero-section',
));

$background_style = $background_image
    ? sprintf(
        "background-image: url('%s'); background-size: %s; background-position: %s; background-repeat: %s; background-attachment: %s;",
        esc_url($background_image),
        esc_attr($bg_size),
        esc_attr($bg_position),
        esc_attr($bg_repeat),
        esc_attr($bg_attachment)
    )
    : 'background: ' . esc_attr($fill_bg) . ';';
?>

<section <?php echo $wrapper_attributes; ?> style="min-height: <?php echo esc_attr($min_height); ?>; <?php echo $background_style; ?>">
    <div class="hero-overlay" style="background: <?php echo esc_attr($fill_bg); ?>; opacity: <?php echo esc_attr($overlay_opacity); ?>;"></div>

    <div class="hero-content">
        <div class="hero-text-rotating"<?php echo $rotating_style; ?>>
            <span class="hero-static-text"><?php echo esc_html($static_text_before); ?></span>
            <span class="hero-rotating-words" data-words="<?php echo esc_attr(wp_json_encode($rotating_words)); ?>">
                <?php echo esc_html($rotating_words[0] ?? ''); ?>
            </span>
        </div>

        <h1 class="hero-title"<?php echo $title_style; ?>><?php echo esc_html($main_title); ?></h1>

        <?php if ($tagline) : ?>
            <p class="hero-tagline"<?php echo $tagline_style; ?>><?php echo esc_html($tagline); ?></p>
        <?php endif; ?>

        <div class="hero-buttons">
            <?php if ($primary_btn_text && $primary_btn_url) : ?>
                <a href="<?php echo esc_url($primary_btn_url); ?>" class="btn btn-primary btn-hero-primary"<?php echo $primary_btn_style; ?>>
                    <?php echo esc_html($primary_btn_text); ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ($secondary_btn_text && $secondary_btn_url) : ?>
                <a href="<?php echo esc_url($secondary_btn_url); ?>" class="btn btn-secondary btn-hero-secondary"<?php echo $secondary_btn_style; ?>>
                    <?php if (strpos($secondary_btn_url, 'youtube') !== false || strpos($secondary_btn_url, 'vimeo') !== false) : ?>
                        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <polygon points="5 3 19 12 5 21 5 3"/>
                        </svg>
                    <?php endif; ?>
                    <?php echo esc_html($secondary_btn_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero-scroll-indicator">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="30" height="30">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
    </div>
</section>

<script>
(function() {
    var hero = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!hero) return;

    var rotatingEl = hero.querySelector('.hero-rotating-words');
    if (!rotatingEl) return;

    var words = JSON.parse(rotatingEl.dataset.words || '[]');
    if (words.length <= 1) return;

    var currentIndex = 0;

    function rotateWord() {
        currentIndex = (currentIndex + 1) % words.length;
        rotatingEl.style.opacity = '0';
        rotatingEl.style.transform = 'translateY(-10px)';

        setTimeout(function() {
            rotatingEl.textContent = words[currentIndex];
            rotatingEl.style.opacity = '1';
            rotatingEl.style.transform = 'translateY(0)';
        }, 300);
    }

    setInterval(rotateWord, 3000);
})();
</script>
