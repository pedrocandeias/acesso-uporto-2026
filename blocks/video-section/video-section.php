<?php
/**
 * Video Section Block Template
 *
 * @package AcessoUPorto
 */

$title = get_field('title');
$video_url = get_field('video_url');
$poster = get_field('poster');
$block_id = 'video-' . $block['id'];

// Parse YouTube/Vimeo URL
$video_id = '';
$video_type = '';

if ($video_url) {
    // YouTube
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $match)) {
        $video_id = $match[1];
        $video_type = 'youtube';
    }
    // Vimeo
    elseif (preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/', $video_url, $match)) {
        $video_id = $match[1];
        $video_type = 'vimeo';
    }
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="video-section section alignfull">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="section-title text-center mb-4"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($video_id) : ?>
            <div class="video-wrapper">
                <div class="video-container" data-video-id="<?php echo esc_attr($video_id); ?>" data-video-type="<?php echo esc_attr($video_type); ?>">
                    <?php if ($poster) : ?>
                        <img src="<?php echo esc_url($poster); ?>" alt="" class="video-poster" loading="lazy">
                    <?php elseif ($video_type === 'youtube') : ?>
                        <img src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/maxresdefault.jpg"
                             alt=""
                             class="video-poster"
                             loading="lazy">
                    <?php endif; ?>

                    <button class="video-play-btn" aria-label="<?php esc_attr_e('Play video', 'acesso-uporto'); ?>">
                        <?php echo acesso_get_icon('play'); ?>
                    </button>
                </div>
            </div>
        <?php else : ?>
            <p class="text-center"><?php esc_html_e('Please add a video URL.', 'acesso-uporto'); ?></p>
        <?php endif; ?>
    </div>
</section>

<style>
#<?php echo esc_attr($block_id); ?> {
    background: #f5f5f5;
}

#<?php echo esc_attr($block_id); ?> .video-wrapper {
    max-width: 1000px;
    margin: 0 auto;
}

#<?php echo esc_attr($block_id); ?> .video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    background: var(--color-dark);
}

#<?php echo esc_attr($block_id); ?> .video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

#<?php echo esc_attr($block_id); ?> .video-poster {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: opacity var(--transition-normal);
}

#<?php echo esc_attr($block_id); ?> .video-container.playing .video-poster,
#<?php echo esc_attr($block_id); ?> .video-container.playing .video-play-btn {
    opacity: 0;
    pointer-events: none;
}

#<?php echo esc_attr($block_id); ?> .video-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    color: var(--color-white);
    transition: all var(--transition-normal);
    z-index: 2;
}

#<?php echo esc_attr($block_id); ?> .video-play-btn:hover {
    transform: translate(-50%, -50%) scale(1.1);
    box-shadow: var(--shadow-lg);
}

#<?php echo esc_attr($block_id); ?> .video-play-btn svg {
    width: 30px;
    height: 30px;
    margin-left: 4px; /* Visual centering for play icon */
}

@media (max-width: 768px) {
    #<?php echo esc_attr($block_id); ?> .video-play-btn {
        width: 60px;
        height: 60px;
    }

    #<?php echo esc_attr($block_id); ?> .video-play-btn svg {
        width: 24px;
        height: 24px;
    }
}
</style>
