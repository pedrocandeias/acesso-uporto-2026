<?php
/**
 * Tab (Separador) Block - Server-side Render
 *
 * Painel individual dentro do bloco acesso/tabs.
 *
 * @package AcessoUPorto
 */

$wrapper_attributes = get_block_wrapper_attributes(array(
    'class' => 'acesso-tab-panel',
    'role'  => 'tabpanel',
));
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php echo $content; // phpcs:ignore -- inner blocks já sanitizados ?>
</div>
