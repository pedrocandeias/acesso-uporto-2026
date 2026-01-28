<?php
/**
 * The main template file
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <?php if (have_posts()) : ?>

        <div class="container section">
            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-card-content">
                            <header class="post-card-header">
                                <?php the_title('<h2 class="post-card-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                                <div class="post-card-meta">
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </div>
                            </header>

                            <div class="post-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="post-card-footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                                    <?php esc_html_e('Read More', 'acesso-uporto'); ?>
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '&laquo; ' . __('Previous', 'acesso-uporto'),
                'next_text' => __('Next', 'acesso-uporto') . ' &raquo;',
            )); ?>
        </div>

    <?php else : ?>

        <div class="container section">
            <div class="no-results">
                <h1><?php esc_html_e('Nothing Found', 'acesso-uporto'); ?></h1>
                <p><?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'acesso-uporto'); ?></p>
            </div>
        </div>

    <?php endif; ?>
</main>

<?php
get_footer();
