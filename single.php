<?php
/**
 * The template for displaying single posts
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <header class="post-header">
                <div class="container container-narrow">
                    <?php the_title('<h1 class="post-title">', '</h1>'); ?>

                    <div class="post-meta">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                        <?php if (get_the_category_list()) : ?>
                            <span class="post-categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="post-content container container-narrow">
                <?php the_content(); ?>
            </div>

            <footer class="post-footer container container-narrow">
                <?php
                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) :
                ?>
                    <div class="post-tags">
                        <span class="tags-label"><?php esc_html_e('Tags:', 'acesso-uporto'); ?></span>
                        <?php echo $tags_list; ?>
                    </div>
                <?php endif; ?>

                <nav class="post-navigation">
                    <?php
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous', 'acesso-uporto') . '</span><span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next', 'acesso-uporto') . '</span><span class="nav-title">%title</span>',
                    ));
                    ?>
                </nav>
            </footer>
        </article>

        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>
</main>

<?php
get_footer();
