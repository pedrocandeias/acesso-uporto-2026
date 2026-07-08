<?php
/**
 * Anchor Menu Block - Server-side Render
 *
 * Substitui o shortcode [ld_custom_menu] do ave-core.
 *
 * @package AcessoUPorto
 */

$items     = $attributes['items'] ?? array();
$alignment = $attributes['alignment'] ?? 'center';
$sticky    = $attributes['sticky'] ?? false;
$anchor_id = $attributes['anchorId'] ?? '';

if (empty($items)) {
    return;
}

$classes = array('acesso-anchor-menu', 'align-' . esc_attr($alignment));
if ($sticky) {
    $classes[] = 'is-sticky';
}

$extra = array('class' => implode(' ', $classes));
if ($anchor_id) {
    $extra['id'] = esc_attr($anchor_id);
}
$wrapper_attributes = get_block_wrapper_attributes($extra);
?>

<nav <?php echo $wrapper_attributes; ?>>
    <ul class="acesso-anchor-menu-list">
        <?php foreach ($items as $item) :
            $label  = $item['label'] ?? '';
            $url    = $item['url'] ?? '#';
            $target = !empty($item['target']) ? $item['target'] : '_self';
            $rel    = $target === '_blank' ? ' rel="noopener noreferrer"' : '';
            $is_anchor = strpos($url, '#') === 0;
            if ($label === '') {
                continue;
            }
        ?>
            <li class="acesso-anchor-menu-item">
                <a href="<?php echo esc_url($url); ?>"
                   target="<?php echo esc_attr($target); ?>"<?php echo $rel; ?>
                   <?php echo $is_anchor ? 'data-localscroll="true"' : ''; ?>>
                    <?php echo esc_html($label); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
