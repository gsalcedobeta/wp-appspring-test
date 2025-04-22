<?php

class Appspring_Admin {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_page']);

        add_action('admin_enqueue_scripts', function ($hook) {
            if ($hook === 'toplevel_page_appspring-data') {
                wp_enqueue_style('appspring-choices', plugins_url('assets/vendor/choices/choices.min.css', plugin_dir_path(__FILE__)));
                wp_enqueue_style('appspring-admin-css', plugins_url('assets/css/admin.css', plugin_dir_path(__FILE__)));
                wp_enqueue_script('appspring-choices', plugins_url('assets/vendor/choices/choices.min.js', plugin_dir_path(__FILE__)), [], null, true);
                wp_enqueue_script('appspring-admin-js', plugins_url('assets/js/admin.js', plugin_dir_path(__FILE__)), ['appspring-choices'], null, true);
            }
        });
    }

    public static function add_admin_page() {
        add_menu_page(
            'Appspring Data Viewer',
            'Appspring Data',
            'manage_options',
            'appspring-data',
            [__CLASS__, 'render_admin_page'],
            'dashicons-visibility',
            80
        );
    }

    public static function render_admin_page() {
        $response = Appspring_API::get_providers();
        $providers = $response['data'] ?? [];

        $tags_response = Appspring_API::get_tags();
        $tags = $tags_response['data'] ?? [];

        $all_states = [];
        foreach ($providers as $provider) {
            if (!empty($provider['states'])) {
                $all_states = array_merge($all_states, $provider['states']);
            }
        }
        $states = array_unique($all_states);
        sort($states);
        ?>
        <div class="wrap">
            <h1>Appspring Data Viewer</h1>

            <p style="font-size: 14px; color: #444; background: #f1f1f1;">
                To display this list of providers on any page of your website, simply insert the shortcode <code>[appspring_providers]</code> into the desired page or post.
            </p>

            <h2>Tags</h2>
            <div style="display: flex; flex-wrap: wrap; margin-bottom: 2rem;">
                <?php foreach ($tags as $tag): ?>
                    <span class="appspring-tag">
                        <?php echo esc_html($tag['name'] ?? 'Unnamed'); ?>
                        <span class="remove">&times;</span>
                    </span>
                <?php endforeach; ?>
            </div>

            <h2>Providers</h2>
            <div class="filter-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <label for="stateFilter"><strong>Filter by state:</strong></label>
                <select id="stateFilter" class="choices-dropdown">
                    <option value="">All</option>
                    <?php foreach ($states as $state): ?>
                        <option value="<?php echo esc_attr($state); ?>"><?php echo esc_html($state); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="providersGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                <?php foreach ($providers as $provider): ?>
                    <?php
                    $data_tags = !empty($provider['states']) ? implode(',', $provider['states']) : '';
                    ?>
                    <div class="provider-card" data-tags="<?php echo esc_attr($data_tags); ?>">
                        <strong><?php echo esc_html($provider['name'] ?? 'No name'); ?></strong><br>
                        <?php if (!empty($provider['avatarUrl'])): ?>
                            <img src="<?php echo esc_url($provider['avatarUrl']); ?>" alt="avatar" />
                        <?php endif; ?>
                        <?php if (!empty($provider['education'])): ?>
                            <p><em><?php echo esc_html($provider['education']); ?></em></p>
                        <?php endif; ?>
                        <?php if (!empty($provider['states']) && is_array($provider['states'])): ?>
                            <p><small><strong>States:</strong> <?php echo implode(', ', array_map('esc_html', $provider['states'])); ?></small></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
