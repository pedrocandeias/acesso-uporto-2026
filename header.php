<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php esc_html_e('Skip to content', 'acesso-uporto'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                        <span class="site-title"><?php bloginfo('name'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle menu', 'acesso-uporto'); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'walker'         => new Acesso_Nav_Walker(),
                    'fallback_cb'    => false,
                ));
                ?>

                <div class="social-icons">
                    <?php
                    $social_links = acesso_get_social_links();
                    foreach ($social_links as $platform => $url) :
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                            <?php echo acesso_get_icon($platform); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </nav>
        </div>
    </header>
