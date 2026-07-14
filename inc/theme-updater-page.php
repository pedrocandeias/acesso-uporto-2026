<?php
/**
 * Página "Ferramentas → Atualizar Tema"
 *
 * Permite atualizar o tema (que não está no repositório oficial do WordPress):
 *   1) a partir da última release no GitHub (puxa o zip anexado), ou
 *   2) carregando manualmente um ficheiro .zip do tema.
 *
 * Usa o Theme_Upgrader do WordPress com clear_destination para sobrepor a
 * instalação existente. Depende de inc/github-update-check.php.
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Regista a página no menu Ferramentas.
 */
function acesso_register_update_page() {
    add_management_page(
        __('Atualizar Tema', 'acesso-uporto'),
        __('Atualizar Tema', 'acesso-uporto'),
        'update_themes',
        'acesso-theme-update',
        'acesso_render_update_page'
    );
}
add_action('admin_menu', 'acesso_register_update_page');

/**
 * Instala um pacote (URL ou caminho local) por cima do tema atual.
 *
 * @param string $package URL do zip ou caminho de ficheiro local.
 * @return array{success:bool,messages:array}
 */
function acesso_run_theme_update($package) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/misc.php';
    require_once ABSPATH . 'wp-admin/includes/theme.php';

    // Sobrepor a instalação existente (o zip da release contém a pasta do tema).
    $overwrite = function ($options) {
        $options['clear_destination'] = true;
        $options['abort_if_destination_exists'] = false;
        return $options;
    };
    add_filter('upgrader_package_options', $overwrite);

    $skin     = new Automatic_Upgrader_Skin();
    $upgrader = new Theme_Upgrader($skin);
    $result   = $upgrader->install($package);

    remove_filter('upgrader_package_options', $overwrite);

    delete_transient(ACESSO_UPDATE_TRANSIENT);

    $messages = $skin->get_upgrade_messages();
    $success  = ($result === true);

    if (is_wp_error($result)) {
        $messages[] = $result->get_error_message();
    } elseif ($result === false) {
        $messages[] = __('A instalação falhou (sem sistema de ficheiros disponível ou pacote inválido).', 'acesso-uporto');
    }

    return array('success' => $success, 'messages' => $messages);
}

/**
 * Processa os formulários de atualização.
 *
 * @return array{success:bool,messages:array}|null
 */
function acesso_handle_update_submit() {
    if (empty($_POST['acesso_update_action']) || !current_user_can('update_themes')) {
        return null;
    }
    check_admin_referer('acesso_theme_update');

    $action = sanitize_text_field(wp_unslash($_POST['acesso_update_action']));

    // 1) Atualizar a partir do GitHub.
    if ($action === 'github') {
        $latest = function_exists('acesso_get_latest_release') ? acesso_get_latest_release(true) : null;
        $zip = is_array($latest) ? ($latest['zip'] ?? '') : '';
        if (empty($zip)) {
            return array('success' => false, 'messages' => array(
                __('Não foi encontrado um zip na última release do GitHub. Confirma que a release tem o ficheiro do tema anexado.', 'acesso-uporto'),
            ));
        }
        return acesso_run_theme_update($zip);
    }

    // 2) Carregar um zip manualmente.
    if ($action === 'upload' && !empty($_FILES['acesso_theme_zip']['tmp_name'])) {
        $file = $_FILES['acesso_theme_zip'];
        if (!empty($file['error'])) {
            return array('success' => false, 'messages' => array(__('Erro no carregamento do ficheiro.', 'acesso-uporto')));
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext !== 'zip') {
            return array('success' => false, 'messages' => array(__('O ficheiro tem de ser um .zip.', 'acesso-uporto')));
        }
        // Mover para um local temporário controlado.
        $tmp = wp_tempnam($file['name']);
        if (!$tmp || !@move_uploaded_file($file['tmp_name'], $tmp)) {
            return array('success' => false, 'messages' => array(__('Não foi possível processar o ficheiro carregado.', 'acesso-uporto')));
        }
        $res = acesso_run_theme_update($tmp);
        @unlink($tmp);
        return $res;
    }

    return array('success' => false, 'messages' => array(__('Ação inválida.', 'acesso-uporto')));
}

/**
 * Render da página.
 */
function acesso_render_update_page() {
    if (!current_user_can('update_themes')) {
        wp_die(esc_html__('Sem permissões para atualizar temas.', 'acesso-uporto'));
    }

    $result = acesso_handle_update_submit();

    $installed = function_exists('acesso_installed_version') ? acesso_installed_version() : wp_get_theme(get_template())->get('Version');
    $latest    = function_exists('acesso_get_latest_release') ? acesso_get_latest_release() : null;
    $latest_ver = is_array($latest) ? ($latest['version'] ?? '') : '';
    $has_zip    = is_array($latest) && !empty($latest['zip']);
    $update_available = $latest_ver && version_compare($latest_ver, $installed, '>');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Atualizar Tema — Acesso U.Porto', 'acesso-uporto'); ?></h1>

        <?php if ($result) : ?>
            <div class="notice notice-<?php echo $result['success'] ? 'success' : 'error'; ?>">
                <p><strong><?php echo $result['success']
                    ? esc_html__('Tema atualizado com sucesso.', 'acesso-uporto')
                    : esc_html__('A atualização não foi concluída.', 'acesso-uporto'); ?></strong></p>
                <?php if (!empty($result['messages'])) : ?>
                    <ul style="list-style: disc; margin-left: 20px;">
                        <?php foreach ($result['messages'] as $msg) : ?>
                            <li><?php echo esc_html(wp_strip_all_tags($msg)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <table class="widefat" style="max-width: 640px; margin-top: 1em;">
            <tbody>
                <tr>
                    <th style="width: 220px;"><?php esc_html_e('Versão instalada', 'acesso-uporto'); ?></th>
                    <td><strong><?php echo esc_html($installed); ?></strong></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Última release no GitHub', 'acesso-uporto'); ?></th>
                    <td>
                        <?php if ($latest_ver) : ?>
                            <strong><?php echo esc_html($latest_ver); ?></strong>
                            <?php if ($update_available) : ?>
                                <span style="color:#b32d2e;"> — <?php esc_html_e('atualização disponível', 'acesso-uporto'); ?></span>
                            <?php else : ?>
                                <span style="color:#227122;"> — <?php esc_html_e('estás atualizado', 'acesso-uporto'); ?></span>
                            <?php endif; ?>
                        <?php else : ?>
                            <em><?php esc_html_e('não foi possível verificar', 'acesso-uporto'); ?></em>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr style="margin: 2em 0;">

        <h2><?php esc_html_e('Atualizar a partir do GitHub', 'acesso-uporto'); ?></h2>
        <p><?php esc_html_e('Descarrega e instala automaticamente o zip da última release publicada no GitHub, por cima da instalação atual.', 'acesso-uporto'); ?></p>
        <form method="post">
            <?php wp_nonce_field('acesso_theme_update'); ?>
            <input type="hidden" name="acesso_update_action" value="github">
            <?php if ($has_zip) : ?>
                <?php submit_button(
                    $update_available
                        ? sprintf(__('Atualizar para %s', 'acesso-uporto'), $latest_ver)
                        : __('Reinstalar a última release', 'acesso-uporto'),
                    'primary',
                    'submit',
                    false
                ); ?>
            <?php else : ?>
                <p><em><?php esc_html_e('A última release ainda não tem um zip anexado. Publica uma release (o workflow anexa o zip automaticamente) ou usa o carregamento manual abaixo.', 'acesso-uporto'); ?></em></p>
            <?php endif; ?>
        </form>

        <hr style="margin: 2em 0;">

        <h2><?php esc_html_e('Ou carregar um ficheiro .zip', 'acesso-uporto'); ?></h2>
        <p><?php esc_html_e('Carrega o zip do tema (o mesmo que descarregas da página de releases). Substitui a instalação atual.', 'acesso-uporto'); ?></p>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('acesso_theme_update'); ?>
            <input type="hidden" name="acesso_update_action" value="upload">
            <input type="file" name="acesso_theme_zip" accept=".zip" required>
            <?php submit_button(__('Carregar e instalar', 'acesso-uporto'), 'secondary', 'submit', false); ?>
        </form>

        <p style="margin-top: 2em; color:#666;">
            <?php
            printf(
                /* translators: %s: link para as releases */
                wp_kses_post(__('Podes ver todas as versões na <a href="%s" target="_blank" rel="noopener">página de releases do GitHub</a>.', 'acesso-uporto')),
                esc_url('https://github.com/' . (defined('ACESSO_GITHUB_REPO') ? ACESSO_GITHUB_REPO : 'pedrocandeias/acesso-uporto-2026') . '/releases')
            );
            ?>
        </p>
    </div>
    <?php
}
