<?php
/**
 * FAQ Accordion Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? 'Perguntas Frequentes';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$items = $attributes['items'] ?? [];
$allow_multiple = $attributes['allowMultiple'] ?? false;
$variant = $attributes['variant'] ?? 'default';
// Backward compat: this visual variant was a string attribute named "style" before the
// rename to "variant". WordPress now treats the reserved "style" as an object (spacing/
// typography supports) and strips the legacy string from $attributes, so recover it from
// the raw parsed block attributes. A string value unambiguously means legacy saved content.
$legacy_variant = isset($block->parsed_block['attrs']['style']) ? $block->parsed_block['attrs']['style'] : null;
if (is_string($legacy_variant) && $legacy_variant !== '') {
    $variant = $legacy_variant;
}
$show_numbers = $attributes['showNumbers'] ?? false;

$block_id = 'faq-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'faq-section style-' . esc_attr($variant),
));

if (empty($items)) {
    return;
}
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if ($section_title || $section_subtitle) : ?>
            <div class="section-header text-center">
                <?php if ($section_title) : ?>
                    <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>
                <?php if ($section_subtitle) : ?>
                    <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="faq-accordion" data-allow-multiple="<?php echo $allow_multiple ? 'true' : 'false'; ?>">
            <?php foreach ($items as $index => $item) :
                $question = $item['question'] ?? '';
                $answer = $item['answer'] ?? '';

                if (empty($question) || empty($answer)) continue;
            ?>
                <div class="faq-item">
                    <button class="faq-header" aria-expanded="false" aria-controls="faq-content-<?php echo $block_id . '-' . $index; ?>">
                        <?php if ($show_numbers) : ?>
                            <span class="faq-number"><?php echo $index + 1; ?></span>
                        <?php endif; ?>

                        <span class="faq-question"><?php echo esc_html($question); ?></span>

                        <span class="faq-toggle">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </span>
                    </button>

                    <div class="faq-content" id="faq-content-<?php echo $block_id . '-' . $index; ?>">
                        <div class="faq-answer">
                            <?php echo wpautop(wp_kses_post($answer)); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
(function() {
    var section = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!section) return;

    var accordion = section.querySelector('.faq-accordion');
    var items = accordion.querySelectorAll('.faq-item');
    var allowMultiple = accordion.dataset.allowMultiple === 'true';

    items.forEach(function(item) {
        var header = item.querySelector('.faq-header');
        var content = item.querySelector('.faq-content');

        if (!header || !content) return;

        header.addEventListener('click', function() {
            var isOpen = item.classList.contains('active');

            if (!allowMultiple) {
                // Close all other items
                items.forEach(function(otherItem) {
                    // Sem "&&" (fica codificado por wptexturize dentro de markup aninhado).
                    if (otherItem !== item) {
                        if (otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                            otherItem.querySelector('.faq-header').setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }

            // Toggle current item
            item.classList.toggle('active');
            header.setAttribute('aria-expanded', !isOpen);
        });
    });
})();
</script>
