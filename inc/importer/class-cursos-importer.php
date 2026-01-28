<?php
/**
 * Cursos CSV Importer - Integrated into Theme
 * Based on uporto-cursos-importer plugin
 *
 * @package AcessoUPorto
 */

if (!defined('ABSPATH')) {
    exit;
}

class Acesso_Cursos_Importer {

    private $backup_dir;

    public function __construct() {
        $this->backup_dir = get_template_directory() . '/inc/importer/backups/';

        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'handle_import']);
        add_action('admin_init', [$this, 'handle_backup']);
        add_action('admin_init', [$this, 'handle_restore']);
        add_action('admin_init', [$this, 'handle_delete_backup']);
        add_action('admin_init', [$this, 'handle_download_backup']);
        add_action('admin_init', [$this, 'handle_upload_backup']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);

        // Ensure backup directory exists
        if (!file_exists($this->backup_dir)) {
            wp_mkdir_p($this->backup_dir);
            file_put_contents($this->backup_dir . '.htaccess', 'Deny from all');
        }
    }

    public function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type=cursos',
            __('Importar Cursos CSV', 'acesso-uporto'),
            __('Importar CSV', 'acesso-uporto'),
            'manage_options',
            'cursos-csv-importer',
            [$this, 'render_admin_page']
        );
    }

    public function enqueue_admin_styles($hook) {
        if (strpos($hook, 'cursos-csv-importer') === false) {
            return;
        }

        wp_add_inline_style('wp-admin', '
            .cursos-importer-wrap { max-width: 900px; }
            .cursos-importer-wrap .card { background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin: 20px 0; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
            .cursos-importer-wrap .card h2 { margin-top: 0; padding-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; }
            .cursos-importer-wrap .card h3 { margin-top: 20px; }
            .cursos-importer-wrap table.form-table th { width: 200px; }
            .cursos-importer-wrap .success { color: #46b450; }
            .cursos-importer-wrap .error { color: #dc3232; }
            .cursos-importer-wrap .warning { color: #ffb900; }
            .import-log { max-height: 400px; overflow-y: auto; background: #1d2327; color: #fff; padding: 15px; font-family: monospace; font-size: 12px; border-radius: 4px; }
            .import-log .log-success { color: #7ad03a; }
            .import-log .log-error { color: #ff6b6b; }
            .import-log .log-warning { color: #ffcc00; }
            .backup-actions { display: flex; gap: 5px; flex-wrap: wrap; }
            .backup-actions form { display: inline; }
        ');
    }

    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $csv_dir = get_template_directory() . '/inc/importer/';

        ?>
        <div class="wrap cursos-importer-wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="card">
                <h2><?php _e('Importar Cursos de CSV', 'acesso-uporto'); ?></h2>
                <p><?php _e('Esta ferramenta importa cursos de um ficheiro CSV para o tipo de post Cursos, preenchendo os campos ACF correspondentes.', 'acesso-uporto'); ?></p>

                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('cursos_csv_import', 'cursos_import_nonce'); ?>

                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="csv_file"><?php _e('Ficheiro CSV', 'acesso-uporto'); ?></label>
                            </th>
                            <td>
                                <input type="file" name="csv_file" id="csv_file" accept=".csv" style="margin-top: 10px;">
                                <p class="description"><?php _e('Selecione um ficheiro CSV para importar.', 'acesso-uporto'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="existing_action"><?php _e('Cursos existentes', 'acesso-uporto'); ?></label>
                            </th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="radio" name="existing_action" value="skip" checked>
                                        <?php _e('Ignorar cursos existentes (criar apenas novos)', 'acesso-uporto'); ?>
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="existing_action" value="update">
                                        <?php _e('Atualizar cursos existentes (baseado no título)', 'acesso-uporto'); ?>
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="existing_action" value="draft_all">
                                        <strong><?php _e('Arquivar todos os cursos existentes e criar novos', 'acesso-uporto'); ?></strong>
                                    </label>
                                    <p class="description" style="margin-left: 25px; color: #d63638;">
                                        <?php _e('Esta opção coloca TODOS os cursos existentes em rascunho antes de importar.', 'acesso-uporto'); ?>
                                    </p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="dry_run"><?php _e('Modo de teste', 'acesso-uporto'); ?></label>
                            </th>
                            <td>
                                <label>
                                    <input type="checkbox" name="dry_run" id="dry_run" value="1">
                                    <?php _e('Executar em modo de teste (não cria posts, apenas mostra o que seria importado)', 'acesso-uporto'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>

                    <p class="submit">
                        <input type="submit" name="import_csv" class="button button-primary" value="<?php esc_attr_e('Importar Cursos', 'acesso-uporto'); ?>">
                    </p>
                </form>
            </div>

            <div class="card">
                <h2><?php _e('Backup e Restauro', 'acesso-uporto'); ?></h2>
                <p><?php _e('Crie um backup de todos os cursos antes de importar. Pode restaurar a qualquer momento.', 'acesso-uporto'); ?></p>

                <form method="post" style="margin-bottom: 20px;">
                    <?php wp_nonce_field('cursos_backup', 'cursos_backup_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="backup_name"><?php _e('Nome do backup', 'acesso-uporto'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="backup_name" id="backup_name" class="regular-text"
                                       placeholder="<?php esc_attr_e('Ex: antes-importacao-2026', 'acesso-uporto'); ?>">
                                <p class="description"><?php _e('Opcional. Se vazio, será usado a data/hora atual.', 'acesso-uporto'); ?></p>
                            </td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="create_backup" class="button button-secondary" value="<?php esc_attr_e('Criar Backup', 'acesso-uporto'); ?>">
                    </p>
                </form>

                <hr>

                <h3><?php _e('Carregar Backup', 'acesso-uporto'); ?></h3>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('cursos_upload_backup', 'cursos_upload_backup_nonce'); ?>
                    <p>
                        <input type="file" name="backup_upload_file" accept=".json">
                        <input type="submit" name="upload_backup" class="button button-secondary" value="<?php esc_attr_e('Carregar', 'acesso-uporto'); ?>">
                    </p>
                </form>

                <h3><?php _e('Backups Disponíveis', 'acesso-uporto'); ?></h3>
                <?php
                $backups = $this->get_available_backups();
                if (empty($backups)): ?>
                    <p><em><?php _e('Nenhum backup disponível.', 'acesso-uporto'); ?></em></p>
                <?php else: ?>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php _e('Nome', 'acesso-uporto'); ?></th>
                                <th><?php _e('Data', 'acesso-uporto'); ?></th>
                                <th><?php _e('Cursos', 'acesso-uporto'); ?></th>
                                <th><?php _e('Tamanho', 'acesso-uporto'); ?></th>
                                <th><?php _e('Ações', 'acesso-uporto'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backups as $backup): ?>
                                <tr>
                                    <td><strong><?php echo esc_html($backup['name']); ?></strong></td>
                                    <td><?php echo esc_html($backup['date']); ?></td>
                                    <td><?php echo esc_html($backup['count']); ?></td>
                                    <td><?php echo esc_html($backup['size']); ?></td>
                                    <td class="backup-actions">
                                        <form method="post">
                                            <?php wp_nonce_field('cursos_download_backup', 'cursos_download_backup_nonce'); ?>
                                            <input type="hidden" name="backup_file" value="<?php echo esc_attr($backup['filename']); ?>">
                                            <button type="submit" name="download_backup" class="button button-small">
                                                <?php _e('Descarregar', 'acesso-uporto'); ?>
                                            </button>
                                        </form>
                                        <form method="post">
                                            <?php wp_nonce_field('cursos_restore', 'cursos_restore_nonce'); ?>
                                            <input type="hidden" name="backup_file" value="<?php echo esc_attr($backup['filename']); ?>">
                                            <button type="submit" name="restore_backup" class="button button-small"
                                                    onclick="return confirm('<?php esc_attr_e('Tem a certeza? Os cursos atuais serão substituídos.', 'acesso-uporto'); ?>');">
                                                <?php _e('Restaurar', 'acesso-uporto'); ?>
                                            </button>
                                        </form>
                                        <form method="post">
                                            <?php wp_nonce_field('cursos_delete_backup', 'cursos_delete_backup_nonce'); ?>
                                            <input type="hidden" name="backup_file" value="<?php echo esc_attr($backup['filename']); ?>">
                                            <button type="submit" name="delete_backup" class="button button-small button-link-delete"
                                                    onclick="return confirm('<?php esc_attr_e('Eliminar este backup?', 'acesso-uporto'); ?>');">
                                                <?php _e('Eliminar', 'acesso-uporto'); ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="card">
                <h2><?php _e('Mapeamento de Campos', 'acesso-uporto'); ?></h2>
                <p><?php _e('Colunas do ficheiro CSV e campos correspondentes:', 'acesso-uporto'); ?></p>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e('Coluna CSV', 'acesso-uporto'); ?></th>
                            <th><?php _e('Campo WordPress/ACF', 'acesso-uporto'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Curso</td><td>Post Title</td></tr>
                        <tr><td>Faculdade</td><td>Taxonomy: faculdades</td></tr>
                        <tr><td>Grau</td><td>ACF: grau</td></tr>
                        <tr><td>Duração / ETCS</td><td>ACF: duracaoects</td></tr>
                        <tr><td>vagas_*</td><td>ACF: vagas (group)</td></tr>
                        <tr><td>nota_do_ultimo_colocado_*</td><td>ACF: nota_do_ultimo_colocado (group)</td></tr>
                        <tr><td>provas_de_ingresso_*</td><td>ACF: provas_de_ingresso (group)</td></tr>
                        <tr><td>Descrição</td><td>ACF: cursos_descricao</td></tr>
                        <tr><td>Saídas profissionais</td><td>ACF: cursos_saidas_profissionais</td></tr>
                        <tr><td>Destaque</td><td>ACF: destaque (1/0)</td></tr>
                        <tr><td>Novo</td><td>ACF: novo (1/0)</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    public function handle_import() {
        if (!isset($_POST['import_csv']) || !isset($_POST['cursos_import_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['cursos_import_nonce'], 'cursos_csv_import')) {
            wp_die(__('Verificação de segurança falhou.', 'acesso-uporto'));
        }

        if (!current_user_can('manage_options')) {
            wp_die(__('Não tem permissões para executar esta ação.', 'acesso-uporto'));
        }

        $csv_path = '';
        $csv_source = isset($_POST['csv_source']) ? sanitize_text_field($_POST['csv_source']) : 'upload';
        $csv_dir = get_template_directory() . '/inc/importer/';

        if ($csv_source === 'default') {
            $csv_path = $csv_dir . 'Licenciaturas_Mestrados_Cursos_2026.csv';
        } elseif ($csv_source === 'legacy') {
            $csv_path = $csv_dir . 'up_dges_courses.csv';
        } elseif (!empty($_FILES['csv_file']['tmp_name'])) {
            $csv_path = $_FILES['csv_file']['tmp_name'];
        }

        if (empty($csv_path) || !file_exists($csv_path)) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . __('Por favor selecione um ficheiro CSV válido.', 'acesso-uporto') . '</p></div>';
            });
            return;
        }

        $existing_action = isset($_POST['existing_action']) ? sanitize_text_field($_POST['existing_action']) : 'skip';
        $dry_run = isset($_POST['dry_run']) && $_POST['dry_run'] == '1';

        $results = $this->process_csv($csv_path, $existing_action, $dry_run);

        set_transient('cursos_import_results', $results, 60);
        add_action('admin_notices', [$this, 'display_import_results']);
    }

    public function display_import_results() {
        $results = get_transient('cursos_import_results');
        if (!$results) {
            return;
        }
        delete_transient('cursos_import_results');

        $class = $results['errors'] > 0 ? 'notice-warning' : 'notice-success';
        ?>
        <div class="notice <?php echo $class; ?>">
            <h3><?php echo $results['dry_run'] ? __('Resultados do Teste', 'acesso-uporto') : __('Resultados da Importação', 'acesso-uporto'); ?></h3>
            <p>
                <?php if (!empty($results['drafted']) && $results['drafted'] > 0): ?>
                    <strong style="color: #996800;"><?php _e('Arquivados:', 'acesso-uporto'); ?></strong> <?php echo $results['drafted']; ?><br>
                <?php endif; ?>
                <strong><?php _e('Total linhas CSV:', 'acesso-uporto'); ?></strong> <?php echo $results['total']; ?><br>
                <strong class="success"><?php _e('Criados:', 'acesso-uporto'); ?></strong> <?php echo $results['created']; ?><br>
                <strong class="warning"><?php _e('Atualizados:', 'acesso-uporto'); ?></strong> <?php echo $results['updated']; ?><br>
                <strong><?php _e('Ignorados:', 'acesso-uporto'); ?></strong> <?php echo $results['skipped']; ?><br>
                <strong class="error"><?php _e('Erros:', 'acesso-uporto'); ?></strong> <?php echo $results['errors']; ?>
            </p>
            <?php if (!empty($results['log'])): ?>
                <details>
                    <summary style="cursor: pointer; font-weight: bold;"><?php _e('Ver log detalhado', 'acesso-uporto'); ?></summary>
                    <div class="import-log" style="margin-top: 10px;">
                        <?php foreach ($results['log'] as $entry): ?>
                            <div class="log-<?php echo esc_attr($entry['type']); ?>">
                                <?php echo esc_html($entry['message']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            <?php endif; ?>
        </div>
        <?php
    }

    private function process_csv($csv_path, $existing_action, $dry_run) {
        $results = [
            'total' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'drafted' => 0,
            'errors' => 0,
            'dry_run' => $dry_run,
            'log' => []
        ];

        // Handle draft_all action
        if ($existing_action === 'draft_all') {
            $draft_result = $this->draft_all_courses($dry_run);
            $results['drafted'] = $draft_result['count'];
            $results['log'] = array_merge($results['log'], $draft_result['log']);
        }

        $handle = fopen($csv_path, 'r');
        if (!$handle) {
            $results['errors']++;
            $results['log'][] = ['type' => 'error', 'message' => 'Não foi possível abrir o ficheiro CSV.'];
            return $results;
        }

        // Read header row
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            $results['errors']++;
            $results['log'][] = ['type' => 'error', 'message' => 'Ficheiro CSV vazio ou formato inválido.'];
            return $results;
        }

        // Clean header (remove BOM and trim)
        $header = array_map(function($col) {
            return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $col));
        }, $header);

        $results['log'][] = ['type' => 'success', 'message' => 'Colunas: ' . implode(', ', array_slice($header, 0, 10)) . '...'];

        // Process each row
        $row_number = 1;
        while (($row = fgetcsv($handle)) !== false) {
            $row_number++;
            $results['total']++;

            if (empty(array_filter($row))) {
                $results['skipped']++;
                continue;
            }

            $data = [];
            foreach ($header as $index => $column) {
                $data[$column] = isset($row[$index]) ? trim($row[$index]) : '';
            }

            $course_title = $data['Curso'] ?? $data['curso'] ?? '';
            if (empty($course_title)) {
                $results['errors']++;
                $results['log'][] = ['type' => 'error', 'message' => "Linha $row_number: Campo 'Curso' vazio."];
                continue;
            }

            $existing_post_id = null;
            if ($existing_action !== 'draft_all') {
                $existing_post_id = $this->find_existing_course($course_title);
            }

            if ($existing_post_id && $existing_action === 'skip') {
                $results['skipped']++;
                continue;
            }

            if ($dry_run) {
                if ($existing_post_id && $existing_action === 'update') {
                    $results['updated']++;
                    $results['log'][] = ['type' => 'warning', 'message' => "Linha $row_number: '$course_title' seria atualizado."];
                } else {
                    $results['created']++;
                    $results['log'][] = ['type' => 'success', 'message' => "Linha $row_number: '$course_title' seria criado."];
                }
                continue;
            }

            $post_id = $this->create_or_update_course($data, $existing_post_id);

            if (is_wp_error($post_id)) {
                $results['errors']++;
                $results['log'][] = ['type' => 'error', 'message' => "Linha $row_number: Erro - " . $post_id->get_error_message()];
                continue;
            }

            if ($existing_post_id) {
                $results['updated']++;
                $results['log'][] = ['type' => 'warning', 'message' => "Linha $row_number: '$course_title' atualizado (ID: $post_id)."];
            } else {
                $results['created']++;
                $results['log'][] = ['type' => 'success', 'message' => "Linha $row_number: '$course_title' criado (ID: $post_id)."];
            }
        }

        fclose($handle);
        return $results;
    }

    private function find_existing_course($title) {
        $query = new WP_Query([
            'post_type' => 'cursos',
            'posts_per_page' => 1,
            'post_status' => 'any',
            'title' => $title
        ]);

        return $query->have_posts() ? $query->posts[0]->ID : null;
    }

    private function draft_all_courses($dry_run = false) {
        $result = ['count' => 0, 'log' => []];

        $query = new WP_Query([
            'post_type' => 'cursos',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids'
        ]);

        if (!$query->have_posts()) {
            $result['log'][] = ['type' => 'warning', 'message' => 'Nenhum curso publicado para arquivar.'];
            return $result;
        }

        $total = count($query->posts);

        if ($dry_run) {
            $result['count'] = $total;
            $result['log'][] = ['type' => 'warning', 'message' => "TESTE: $total cursos seriam arquivados."];
            return $result;
        }

        foreach ($query->posts as $post_id) {
            wp_update_post(['ID' => $post_id, 'post_status' => 'draft']);
            $result['count']++;
        }

        $result['log'][] = ['type' => 'success', 'message' => "{$result['count']} cursos arquivados."];
        return $result;
    }

    private function create_or_update_course($data, $existing_post_id = null) {
        $is_new_format = isset($data['Curso']);
        $post_title = $is_new_format ? ($data['Curso'] ?? '') : ($data['curso'] ?? '');

        $post_data = [
            'post_title' => sanitize_text_field($post_title),
            'post_type' => 'cursos',
            'post_status' => 'publish',
        ];

        if ($existing_post_id) {
            $post_data['ID'] = $existing_post_id;
            $post_id = wp_update_post($post_data, true);
        } else {
            $post_id = wp_insert_post($post_data, true);
        }

        if (is_wp_error($post_id)) {
            return $post_id;
        }

        // Set taxonomy
        $faculty = $is_new_format ? ($data['Faculdade'] ?? '') : ($data['unidade_organica'] ?? '');
        if (!empty($faculty)) {
            $term = $this->get_or_create_term($faculty, 'faculdades');
            if ($term) {
                wp_set_object_terms($post_id, [$term->term_id], 'faculdades');
            }
        }

        // Update ACF fields
        $this->update_acf_fields($post_id, $data, $is_new_format);

        return $post_id;
    }

    private function get_or_create_term($term_name, $taxonomy) {
        $term = get_term_by('name', $term_name, $taxonomy);

        if (!$term) {
            $result = wp_insert_term($term_name, $taxonomy);
            if (!is_wp_error($result)) {
                $term = get_term($result['term_id'], $taxonomy);
            }
        }

        return $term;
    }

    private function update_acf_fields($post_id, $data, $is_new_format) {
        if (!function_exists('update_field')) {
            // Fallback to post meta
            foreach ($data as $key => $value) {
                if (!empty($value)) {
                    update_post_meta($post_id, sanitize_key($key), sanitize_text_field($value));
                }
            }
            return;
        }

        if ($is_new_format) {
            // Grau
            if (!empty($data['Grau'])) {
                update_field('grau', sanitize_text_field($data['Grau']), $post_id);
            }

            // Info extra
            if (!empty($data['Informações adicionais do curso (ex. em parceria com)'])) {
                update_field('info_extra_curso', sanitize_text_field($data['Informações adicionais do curso (ex. em parceria com)']), $post_id);
            }

            // Duração/ECTS
            if (!empty($data['Duração / ETCS'])) {
                update_field('duracaoects', sanitize_text_field($data['Duração / ETCS']), $post_id);
            }

            // Vagas (group)
            $vagas = [
                'ano_das_vagas' => $data['vagas_ano_das_vagas'] ?? '',
                'fase_1' => $data['vagas_fase_1'] ?? '',
                'fase_2' => $data['vagas_fase_2'] ?? '',
                'fase_3' => $data['vagas_fase_3'] ?? '',
            ];
            update_field('vagas', $vagas, $post_id);

            // Nota do último colocado (group)
            $nota_ultimo = [
                'ano_ultimo_classificado' => $data['nota_do_ultimo_colocado_ano_ultimo_classificado'] ?? '',
                'notas' => [
                    'fase_1' => $data['nota_do_ultimo_colocado_notas_fase_1'] ?? '',
                    'fase_2' => $data['nota_do_ultimo_colocado_notas_fase_2'] ?? '',
                    'fase_3' => $data['nota_do_ultimo_colocado_notas_fase_3'] ?? '',
                ],
            ];
            update_field('nota_do_ultimo_colocado', $nota_ultimo, $post_id);

            // Provas de ingresso (group)
            $provas = [
                'ano_das_provas' => !empty($data['provas_de_ingresso_ano_das_provas']) ? '(' . $data['provas_de_ingresso_ano_das_provas'] . ')' : '',
                'expressao' => $data['provas_de_ingresso_expressao'] ?? '',
                'provas' => $data['provas_de_ingresso_provas'] ?? '',
            ];
            update_field('provas_de_ingresso', $provas, $post_id);

            // Classificação mínima (group)
            $classificacao = [
                'ano_da_classificacao' => $data['classificacao_minima_ano_da_classificacao'] ?? '',
                'nota_de_candidatura' => $data['classificacao_minima_nota_de_candidatura'] ?? '',
                'nota_prova_de_ingresso' => $data['classificacao_minima_nota_prova_de_ingresso'] ?? '',
            ];
            update_field('classificacao_minima', $classificacao, $post_id);

            // Fórmula de cálculo (group)
            $formula = [
                'ano_da_formula' => $data['formula_de_calculo_ano_da_formula'] ?? '',
                'percentagem_secundario' => $data['formula_de_calculo_percentagem_secundario'] ?? '',
                'nota_prova_de_ingresso' => $data['formula_de_calculo_nota_prova_de_ingresso'] ?? '',
            ];
            update_field('formula_de_calculo', $formula, $post_id);

            // Pré-requisitos
            if (!empty($data['Pré-requisitos'])) {
                update_field('prerequisitos', sanitize_text_field($data['Pré-requisitos']), $post_id);
            }

            // Descrição
            if (!empty($data['Descrição'])) {
                update_field('cursos_descricao', sanitize_textarea_field($data['Descrição']), $post_id);
            }

            // Saídas profissionais
            if (!empty($data['Saídas profissionais'])) {
                update_field('cursos_saidas_profissionais', sanitize_textarea_field($data['Saídas profissionais']), $post_id);
            }

            // Destaque
            $destaque = isset($data['Destaque']) && ($data['Destaque'] === '1' || $data['Destaque'] === 1);
            update_field('destaque', $destaque, $post_id);

            // Novo
            $novo = isset($data['Novo']) && ($data['Novo'] === '1' || $data['Novo'] === 1);
            update_field('novo', $novo, $post_id);

            // Instituição
            if (!empty($data['Instituição'])) {
                update_post_meta($post_id, 'instituicao', sanitize_text_field($data['Instituição']));
            }
        }
    }

    // Backup Methods
    public function handle_backup() {
        if (!isset($_POST['create_backup']) || !isset($_POST['cursos_backup_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['cursos_backup_nonce'], 'cursos_backup') || !current_user_can('manage_options')) {
            wp_die(__('Verificação falhou.', 'acesso-uporto'));
        }

        $backup_name = isset($_POST['backup_name']) ? sanitize_file_name($_POST['backup_name']) : '';
        $result = $this->create_backup($backup_name);

        set_transient('cursos_backup_result', $result, 60);
        add_action('admin_notices', [$this, 'display_backup_result']);
    }

    public function display_backup_result() {
        $result = get_transient('cursos_backup_result');
        if (!$result) return;
        delete_transient('cursos_backup_result');

        $class = $result['success'] ? 'notice-success' : 'notice-error';
        echo '<div class="notice ' . $class . ' is-dismissible"><p><strong>' . esc_html($result['message']) . '</strong></p></div>';
    }

    private function create_backup($name = '') {
        $result = ['success' => false, 'message' => '', 'filename' => '', 'count' => 0];

        $timestamp = current_time('Y-m-d_H-i-s');
        $name = empty($name) ? 'backup_' . $timestamp : $name . '_' . $timestamp;
        $filename = $name . '.json';
        $filepath = $this->backup_dir . $filename;

        $query = new WP_Query([
            'post_type' => 'cursos',
            'posts_per_page' => -1,
            'post_status' => ['publish', 'draft', 'pending', 'private']
        ]);

        if (!$query->have_posts()) {
            $result['message'] = __('Nenhum curso encontrado.', 'acesso-uporto');
            return $result;
        }

        $backup_data = [
            'version' => '1.0',
            'created' => current_time('mysql'),
            'site_url' => get_site_url(),
            'courses' => []
        ];

        foreach ($query->posts as $post) {
            $course_data = [
                'post' => [
                    'post_title' => $post->post_title,
                    'post_content' => $post->post_content,
                    'post_status' => $post->post_status,
                    'post_name' => $post->post_name,
                ],
                'taxonomies' => [],
                'meta' => [],
                'acf' => []
            ];

            $terms = wp_get_object_terms($post->ID, 'faculdades');
            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $course_data['taxonomies']['faculdades'][] = $term->name;
                }
            }

            $meta = get_post_meta($post->ID);
            foreach ($meta as $key => $values) {
                if (strpos($key, '_') === 0 && strpos($key, '_acf') !== 0) continue;
                $course_data['meta'][$key] = count($values) === 1 ? maybe_unserialize($values[0]) : array_map('maybe_unserialize', $values);
            }

            if (function_exists('get_fields')) {
                $acf_fields = get_fields($post->ID);
                if ($acf_fields) {
                    $course_data['acf'] = $acf_fields;
                }
            }

            $backup_data['courses'][] = $course_data;
        }

        $backup_data['total_courses'] = count($backup_data['courses']);

        if (file_put_contents($filepath, json_encode($backup_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
            $result['message'] = __('Erro ao escrever ficheiro.', 'acesso-uporto');
            return $result;
        }

        $result['success'] = true;
        $result['message'] = sprintf(__('Backup criado: %s (%d cursos)', 'acesso-uporto'), $filename, count($backup_data['courses']));
        $result['filename'] = $filename;
        $result['count'] = count($backup_data['courses']);

        return $result;
    }

    public function handle_restore() {
        if (!isset($_POST['restore_backup']) || !isset($_POST['cursos_restore_nonce'])) return;
        if (!wp_verify_nonce($_POST['cursos_restore_nonce'], 'cursos_restore') || !current_user_can('manage_options')) {
            wp_die(__('Verificação falhou.', 'acesso-uporto'));
        }

        $backup_file = sanitize_file_name($_POST['backup_file'] ?? '');
        $result = $this->restore_backup($backup_file);

        $class = $result['success'] ? 'notice-success' : 'notice-error';
        add_action('admin_notices', function() use ($result, $class) {
            echo '<div class="notice ' . $class . ' is-dismissible"><p><strong>' . esc_html($result['message']) . '</strong></p></div>';
        });
    }

    private function restore_backup($filename) {
        $result = ['success' => false, 'message' => '', 'deleted' => 0, 'restored' => 0];

        $filepath = $this->backup_dir . $filename;
        if (!file_exists($filepath)) {
            $result['message'] = __('Ficheiro não encontrado.', 'acesso-uporto');
            return $result;
        }

        $backup_data = json_decode(file_get_contents($filepath), true);
        if (!$backup_data || !isset($backup_data['courses'])) {
            $result['message'] = __('Ficheiro inválido.', 'acesso-uporto');
            return $result;
        }

        // Delete existing
        $existing = new WP_Query(['post_type' => 'cursos', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
        foreach ($existing->posts as $post_id) {
            if (wp_delete_post($post_id, true)) $result['deleted']++;
        }

        // Restore
        foreach ($backup_data['courses'] as $course_data) {
            $post_data = $course_data['post'];
            $post_data['post_type'] = 'cursos';

            $post_id = wp_insert_post($post_data, true);
            if (is_wp_error($post_id)) continue;

            if (!empty($course_data['taxonomies']['faculdades'])) {
                $term_ids = [];
                foreach ($course_data['taxonomies']['faculdades'] as $term_name) {
                    $term = $this->get_or_create_term($term_name, 'faculdades');
                    if ($term) $term_ids[] = $term->term_id;
                }
                if (!empty($term_ids)) wp_set_object_terms($post_id, $term_ids, 'faculdades');
            }

            if (!empty($course_data['meta'])) {
                foreach ($course_data['meta'] as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }
            }

            if (function_exists('update_field') && !empty($course_data['acf'])) {
                foreach ($course_data['acf'] as $field_name => $field_value) {
                    update_field($field_name, $field_value, $post_id);
                }
            }

            $result['restored']++;
        }

        $result['success'] = true;
        $result['message'] = sprintf(__('Restauro completo: %d eliminados, %d restaurados', 'acesso-uporto'), $result['deleted'], $result['restored']);

        return $result;
    }

    public function handle_delete_backup() {
        if (!isset($_POST['delete_backup']) || !isset($_POST['cursos_delete_backup_nonce'])) return;
        if (!wp_verify_nonce($_POST['cursos_delete_backup_nonce'], 'cursos_delete_backup') || !current_user_can('manage_options')) {
            wp_die(__('Verificação falhou.', 'acesso-uporto'));
        }

        $backup_file = sanitize_file_name($_POST['backup_file'] ?? '');
        $filepath = $this->backup_dir . $backup_file;

        if (file_exists($filepath) && strpos($backup_file, '.json') !== false) {
            unlink($filepath);
            add_action('admin_notices', function() {
                echo '<div class="notice notice-success is-dismissible"><p>' . __('Backup eliminado.', 'acesso-uporto') . '</p></div>';
            });
        }
    }

    public function handle_download_backup() {
        if (!isset($_POST['download_backup']) || !isset($_POST['cursos_download_backup_nonce'])) return;
        if (!wp_verify_nonce($_POST['cursos_download_backup_nonce'], 'cursos_download_backup') || !current_user_can('manage_options')) {
            wp_die(__('Verificação falhou.', 'acesso-uporto'));
        }

        $backup_file = sanitize_file_name($_POST['backup_file'] ?? '');
        $filepath = $this->backup_dir . $backup_file;

        if (!file_exists($filepath) || strpos($backup_file, '.json') === false) {
            wp_die(__('Ficheiro não encontrado.', 'acesso-uporto'));
        }

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $backup_file . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    }

    public function handle_upload_backup() {
        if (!isset($_POST['upload_backup']) || !isset($_POST['cursos_upload_backup_nonce'])) return;
        if (!wp_verify_nonce($_POST['cursos_upload_backup_nonce'], 'cursos_upload_backup') || !current_user_can('manage_options')) {
            wp_die(__('Verificação falhou.', 'acesso-uporto'));
        }

        if (empty($_FILES['backup_upload_file']['tmp_name'])) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . __('Selecione um ficheiro.', 'acesso-uporto') . '</p></div>';
            });
            return;
        }

        $tmp_file = $_FILES['backup_upload_file']['tmp_name'];
        $original_name = sanitize_file_name($_FILES['backup_upload_file']['name']);

        if (pathinfo($original_name, PATHINFO_EXTENSION) !== 'json') {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . __('Ficheiro deve ser .json', 'acesso-uporto') . '</p></div>';
            });
            return;
        }

        $backup_data = json_decode(file_get_contents($tmp_file), true);
        if (!$backup_data || !isset($backup_data['courses'])) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . __('Ficheiro inválido.', 'acesso-uporto') . '</p></div>';
            });
            return;
        }

        $new_filename = pathinfo($original_name, PATHINFO_FILENAME) . '_uploaded_' . current_time('Y-m-d_H-i-s') . '.json';
        $destination = $this->backup_dir . $new_filename;

        if (move_uploaded_file($tmp_file, $destination)) {
            add_action('admin_notices', function() use ($new_filename) {
                echo '<div class="notice notice-success"><p>' . sprintf(__('Backup carregado: %s', 'acesso-uporto'), esc_html($new_filename)) . '</p></div>';
            });
        }
    }

    private function get_available_backups() {
        $backups = [];
        if (!file_exists($this->backup_dir)) return $backups;

        $files = glob($this->backup_dir . '*.json');
        foreach ($files as $file) {
            $filename = basename($file);
            $data = json_decode(file_get_contents($file), true);

            $backups[] = [
                'filename' => $filename,
                'name' => str_replace('.json', '', $filename),
                'date' => $data['created'] ?? date('Y-m-d H:i:s', filemtime($file)),
                'count' => $data['total_courses'] ?? (isset($data['courses']) ? count($data['courses']) : '?'),
                'size' => size_format(filesize($file), 2)
            ];
        }

        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $backups;
    }
}
