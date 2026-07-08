<?php
/**
 * Modal / Popup Block - Server-side Render
 *
 * Substitui o shortcode [ld_modal_window] do ave-core.
 * Abre-se pelo botão-gatilho ou por qualquer link <a href="#anchorId">.
 *
 * @package AcessoUPorto
 */

$anchor_id     = $attributes['anchorId'] ?? '';
$trigger_label = $attributes['triggerLabel'] ?? 'Ver mais';
$show_trigger  = $attributes['showTrigger'] ?? true;

if (empty($anchor_id)) {
    $anchor_id = 'modal-' . uniqid();
}

$body = trim($content ?? '');
if ($body === '') {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes(array(
    'class' => 'acesso-modal-block',
));
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($show_trigger && $trigger_label) : ?>
        <button type="button" class="acesso-modal-trigger btn-primary" data-modal-target="<?php echo esc_attr($anchor_id); ?>">
            <?php echo esc_html($trigger_label); ?>
        </button>
    <?php endif; ?>

    <div class="acesso-modal-overlay" id="<?php echo esc_attr($anchor_id); ?>" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="acesso-modal-box" role="document">
            <button type="button" class="acesso-modal-close" aria-label="Fechar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="acesso-modal-content">
                <?php echo $body; // phpcs:ignore -- inner blocks já sanitizados ?>
            </div>
        </div>
    </div>
</div>
