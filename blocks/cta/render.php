<?php
/**
 * Call to Action Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$title = $attributes['title'] ?? '';
$text = $attributes['text'] ?? '';
$primary_btn_text = $attributes['primaryButtonText'] ?? '';
$primary_btn_url = $attributes['primaryButtonUrl'] ?? '';
$secondary_btn_text = $attributes['secondaryButtonText'] ?? '';
$secondary_btn_url = $attributes['secondaryButtonUrl'] ?? '';
$style = $attributes['style'] ?? 'gradient';
$background_image = $attributes['backgroundImage'] ?? '';
$overlay_opacity = ($attributes['overlayOpacity'] ?? 85) / 100;

// Fundo de pixels: implica estilo "imagem" e sobrepõe a imagem carregada.
$pixel_bg = $attributes['pixelBackground'] ?? '';
$pixel_colors = array('gold', 'navy', 'coral', 'purple', 'pink', 'cyan', 'red', 'yellow');
if ($pixel_bg && in_array($pixel_bg, $pixel_colors, true)) {
    $background_image = ACESSO_THEME_URI . '/assets/images/pixel-bg/pixel-' . $pixel_bg . '.svg';
    $style = 'image';
}

$block_id = 'cta-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'cta-section style-' . esc_attr($style),
));

$bg_size       = $attributes['backgroundSize'] ?? 'cover';
$bg_position   = $attributes['backgroundPosition'] ?? 'center center';
$bg_repeat     = $attributes['backgroundRepeat'] ?? 'no-repeat';
$bg_attachment = $attributes['backgroundAttachment'] ?? 'scroll';

$background_style = '';
if ($style === 'image' && $background_image) {
    $background_style = sprintf(
        "background-image: url('%s'); background-size: %s; background-position: %s; background-repeat: %s; background-attachment: %s;",
        esc_url($background_image),
        esc_attr($bg_size),
        esc_attr($bg_position),
        esc_attr($bg_repeat),
        esc_attr($bg_attachment)
    );
}
?>

<section <?php echo $wrapper_attributes; ?> <?php echo $background_style ? 'style="' . $background_style . '"' : ''; ?>>
    <?php if ($style === 'image' && $background_image) : ?>
        <div class="cta-overlay" style="opacity: <?php echo esc_attr($overlay_opacity); ?>;"></div>
    <?php endif; ?>

    <div class="container">
        <div class="cta-content">
            <?php if ($title) : ?>
                <h2 class="cta-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="cta-text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($primary_btn_text || $secondary_btn_text) : ?>
                <div class="cta-buttons">
                    <?php if ($primary_btn_text && $primary_btn_url) : ?>
                        <a href="<?php echo esc_url($primary_btn_url); ?>" class="btn btn-cta-primary">
                            <?php echo esc_html($primary_btn_text); ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_btn_text && $secondary_btn_url) : ?>
                        <a href="<?php echo esc_url($secondary_btn_url); ?>" class="btn btn-cta-secondary">
                            <?php echo esc_html($secondary_btn_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
