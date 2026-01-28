<?php
/**
 * Front Page Template
 *
 * @package AcessoUPorto
 */

get_header();
?>

<main id="main" class="site-main front-page">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
