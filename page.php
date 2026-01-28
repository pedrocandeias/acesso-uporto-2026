<?php
/**
 * The template for displaying all pages
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (!is_front_page()) : ?>
                <header class="page-header container">
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                </header>
            <?php endif; ?>

            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();
