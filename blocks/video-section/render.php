<?php
/**
 * Video Section Block - Server-side Render
 *
 * @package AcessoUPorto
 */

$section_title = $attributes['sectionTitle'] ?? '';
$section_subtitle = $attributes['sectionSubtitle'] ?? '';
$video_url = $attributes['videoUrl'] ?? '';
$poster_image = $attributes['posterImage'] ?? '';
$aspect_ratio = $attributes['aspectRatio'] ?? '16-9';
$style = $attributes['style'] ?? 'default';
$autoplay = $attributes['autoplay'] ?? false;

$block_id = 'video-section-' . uniqid();

$wrapper_attributes = get_block_wrapper_attributes(array(
    'id' => $block_id,
    'class' => 'video-section style-' . esc_attr($style) . ' aspect-' . esc_attr($aspect_ratio),
));

if (empty($video_url)) {
    return;
}

// Parse video URL
$video_id = '';
$video_type = '';

// YouTube
if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches)) {
    $video_id = $matches[1];
    $video_type = 'youtube';
    $embed_url = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=1&rel=0';
    if (!$poster_image) {
        $poster_image = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
    }
}
// Vimeo
elseif (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $video_url, $matches)) {
    $video_id = $matches[1];
    $video_type = 'vimeo';
    $embed_url = 'https://player.vimeo.com/video/' . $video_id . '?autoplay=1';
}

if (empty($video_id)) {
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

        <div class="video-wrapper" data-embed-url="<?php echo esc_attr($embed_url); ?>">
            <div class="video-poster" style="<?php echo $poster_image ? 'background-image: url(' . esc_url($poster_image) . ');' : ''; ?>">
                <button class="video-play-btn" aria-label="<?php esc_attr_e('Reproduzir vídeo', 'acesso-uporto'); ?>">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </button>
            </div>
            <div class="video-embed"></div>
        </div>
    </div>
</section>

<script>
(function() {
    var section = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!section) return;

    var wrapper = section.querySelector('.video-wrapper');
    var poster = section.querySelector('.video-poster');
    var playBtn = section.querySelector('.video-play-btn');
    var embedContainer = section.querySelector('.video-embed');
    var embedUrl = wrapper.dataset.embedUrl;

    if (!playBtn || !embedUrl) return;

    playBtn.addEventListener('click', function() {
        var iframe = document.createElement('iframe');
        iframe.src = embedUrl;
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allowfullscreen', 'true');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');

        embedContainer.appendChild(iframe);
        poster.style.display = 'none';
        embedContainer.style.display = 'block';
    });
})();
</script>
