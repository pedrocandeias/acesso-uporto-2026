<?php
/**
 * Verificação de versão via GitHub Releases
 *
 * Compara a versão instalada do tema (cabeçalho Version do style.css) com a
 * última *release* publicada no repositório GitHub e mostra um aviso no painel
 * quando existe uma versão mais recente. NÃO atualiza automaticamente — a
 * atualização é feita por upload manual do tema.
 *
 * O repositório é público, por isso não é preciso qualquer configuração nem
 * token. (Opcional: se um dia o repo passar a privado, basta definir a
 * constante ACESSO_GITHUB_TOKEN — com um PAT de leitura — que o código a usa.)
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

// Repositório de origem (pode ser sobreposto antes de carregar este ficheiro).
if (!defined('ACESSO_GITHUB_REPO')) {
    define('ACESSO_GITHUB_REPO', 'pedrocandeias/acesso-uporto-2026');
}

const ACESSO_UPDATE_TRANSIENT = 'acesso_github_latest_release';
const ACESSO_UPDATE_CACHE_HOURS = 12;

/**
 * Devolve a versão instalada do tema (a partir do cabeçalho do style.css).
 */
function acesso_installed_version() {
    return wp_get_theme(get_template())->get('Version');
}

/**
 * Consulta (com cache) a última release no GitHub.
 *
 * @param bool $force Ignora a cache e vai buscar de novo.
 * @return array{version:string,url:string,name:string}|WP_Error|null
 *         Dados da release, WP_Error em falha, ou null se não houver token para repo privado.
 */
function acesso_get_latest_release($force = false) {
    if (!$force) {
        $cached = get_transient(ACESSO_UPDATE_TRANSIENT);
        if ($cached !== false) {
            return $cached; // Pode ser array de dados ou WP_Error serializado como array.
        }
    }

    $url = 'https://api.github.com/repos/' . ACESSO_GITHUB_REPO . '/releases/latest';

    $args = array(
        'timeout' => 10,
        'headers' => array(
            'Accept'     => 'application/vnd.github+json',
            'User-Agent' => 'acesso-uporto-theme',
        ),
    );
    if (defined('ACESSO_GITHUB_TOKEN') && ACESSO_GITHUB_TOKEN) {
        $args['headers']['Authorization'] = 'Bearer ' . ACESSO_GITHUB_TOKEN;
    }

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        $result = array('error' => $response->get_error_message());
        set_transient(ACESSO_UPDATE_TRANSIENT, $result, HOUR_IN_SECONDS);
        return new WP_Error('acesso_http', $result['error']);
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        // 404 num repo privado = falta token / sem releases; 401/403 = token inválido/rate limit.
        $result = array('error' => 'HTTP ' . $code, 'code' => $code);
        set_transient(ACESSO_UPDATE_TRANSIENT, $result, HOUR_IN_SECONDS);
        return new WP_Error('acesso_http', 'HTTP ' . $code);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body['tag_name'])) {
        $result = array('error' => 'resposta sem tag_name');
        set_transient(ACESSO_UPDATE_TRANSIENT, $result, HOUR_IN_SECONDS);
        return new WP_Error('acesso_parse', $result['error']);
    }

    $data = array(
        'version' => ltrim($body['tag_name'], 'vV'),
        'url'     => !empty($body['html_url']) ? $body['html_url'] : 'https://github.com/' . ACESSO_GITHUB_REPO . '/releases',
        'name'    => !empty($body['name']) ? $body['name'] : $body['tag_name'],
    );
    set_transient(ACESSO_UPDATE_TRANSIENT, $data, ACESSO_UPDATE_CACHE_HOURS * HOUR_IN_SECONDS);
    return $data;
}

/**
 * Existe uma release mais recente que a versão instalada?
 *
 * @return array|false Dados da release se houver atualização, senão false.
 */
function acesso_update_available() {
    $latest = acesso_get_latest_release();
    if (!is_array($latest) || empty($latest['version'])) {
        return false;
    }
    if (version_compare($latest['version'], acesso_installed_version(), '>')) {
        return $latest;
    }
    return false;
}

/**
 * Força uma nova verificação através de ?acesso_check_theme_update=1.
 */
function acesso_maybe_force_update_check() {
    if (isset($_GET['acesso_check_theme_update']) && current_user_can('update_themes')) {
        delete_transient(ACESSO_UPDATE_TRANSIENT);
        acesso_get_latest_release(true);
    }
}
add_action('admin_init', 'acesso_maybe_force_update_check');

/**
 * Aviso no painel quando há uma versão mais recente no GitHub.
 */
function acesso_github_update_notice() {
    if (!current_user_can('update_themes')) {
        return;
    }

    $update = acesso_update_available();
    if ($update) {
        printf(
            '<div class="notice notice-warning"><p>%s</p></div>',
            sprintf(
                /* translators: 1: versão nova, 2: versão instalada, 3: link para a release */
                wp_kses_post(__('<strong>Tema Acesso U.Porto:</strong> está disponível a versão <strong>%1$s</strong> no GitHub (tens a %2$s instalada). <a href="%3$s" target="_blank" rel="noopener">Ver a release e descarregar o tema</a>, depois atualiza por <em>Aparência → Temas → Adicionar novo → Carregar tema</em>.', 'acesso-uporto')),
                esc_html($update['version']),
                esc_html(acesso_installed_version()),
                esc_url($update['url'])
            )
        );
        return;
    }

    // Diagnóstico da configuração — só nos ecrãs de Temas/Atualizações, para não incomodar.
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ($screen && in_array($screen->id, array('themes', 'update-core'), true)) {
        $latest = acesso_get_latest_release();
        if (is_wp_error($latest) || $latest === null) {
            $hint = sprintf(
                /* translators: %s: link para forçar nova verificação */
                wp_kses_post(__('Não foi possível verificar a última release no GitHub (ainda sem releases publicadas ou limite de pedidos atingido). <a href="%s">Tentar de novo</a>.', 'acesso-uporto')),
                esc_url(add_query_arg('acesso_check_theme_update', '1'))
            );
            printf('<div class="notice notice-info"><p><strong>Tema Acesso U.Porto:</strong> %s</p></div>', $hint);
        }
    }
}
add_action('admin_notices', 'acesso_github_update_notice');

/**
 * Limpa a cache quando o tema é atualizado (para reavaliar logo).
 */
function acesso_clear_update_cache() {
    delete_transient(ACESSO_UPDATE_TRANSIENT);
}
add_action('after_switch_theme', 'acesso_clear_update_cache');
add_action('upgrader_process_complete', 'acesso_clear_update_cache');
