<?php
/**
 * Tabs Block - Server-side Render
 *
 * Substitui o shortcode [ld_tabs] do ave-core. Os títulos vêm dos blocos
 * filhos acesso/tab; os painéis são o conteúdo renderizado ($content).
 *
 * @package AcessoUPorto
 */

$inner = isset($block) && isset($block->parsed_block['innerBlocks'])
    ? $block->parsed_block['innerBlocks']
    : array();

// Recolhe os títulos das secções (blocos filhos acesso/tab).
$titles = array();
foreach ($inner as $child) {
    if (($child['blockName'] ?? '') === 'acesso/tab') {
        $titles[] = $child['attrs']['title'] ?? '';
    }
}

if (empty($titles)) {
    return;
}

$block_id = 'tabs-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'class' => 'acesso-tabs',
    'id'    => $block_id,
));

// Marca o primeiro painel como ativo (evita "flash" antes do JS).
$panels = preg_replace('/class="([^"]*\bacesso-tab-panel\b[^"]*)"/', 'class="$1 is-active"', $content, 1);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="acesso-tabs-nav" role="tablist">
        <?php foreach ($titles as $i => $title) : ?>
            <button type="button"
                    class="acesso-tab-btn<?php echo $i === 0 ? ' is-active' : ''; ?>"
                    role="tab"
                    id="<?php echo esc_attr($block_id . '-tab-' . $i); ?>"
                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo esc_attr($block_id . '-panel-' . $i); ?>">
                <?php echo esc_html($title); ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div class="acesso-tabs-panels">
        <?php echo $panels; // phpcs:ignore -- inner blocks já sanitizados ?>
    </div>
</div>
