<?php
/**
 * Icon Box Block - Server-side Render
 *
 * Substitui o shortcode [ld_icon_box] do ave-core (Visual Composer).
 *
 * @package AcessoUPorto
 */

$icon       = $attributes['icon'] ?? 'star';
$title      = $attributes['title'] ?? '';
$alignment  = $attributes['alignment'] ?? 'center';
$position   = $attributes['position'] ?? 'top';
$icon_style = $attributes['iconStyle'] ?? 'gradient';
$link       = $attributes['link'] ?? '';

// Inner blocks (corpo) chegam em $content.
$body = trim($content ?? '');

$classes = array(
    'icon-box',
    'align-' . esc_attr($alignment),
    'position-' . esc_attr($position),
    'icon-style-' . esc_attr($icon_style),
);

$wrapper_attributes = get_block_wrapper_attributes(array(
    'class' => implode(' ', $classes),
));

$icons = require __DIR__ . '/icons.php';
$icon_svg = $icons[$icon] ?? $icons['star'];

$has_link = !empty($link);
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($has_link) : ?>
        <a class="icon-box-overlay-link" href="<?php echo esc_url($link); ?>" aria-label="<?php echo esc_attr($title); ?>"></a>
    <?php endif; ?>

    <div class="icon-box-icon">
        <?php echo $icon_svg; // phpcs:ignore -- SVG estático, sem input do utilizador ?>
    </div>

    <div class="icon-box-body">
        <?php if ($title) : ?>
            <h3 class="icon-box-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <?php if ($body) : ?>
            <div class="icon-box-content"><?php echo $body; // phpcs:ignore -- inner blocks já sanitizados ?></div>
        <?php endif; ?>
    </div>
</div>
