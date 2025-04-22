<?php

class Appspring_Frontend {

    public static function init() {
        add_action('init', [__CLASS__, 'register_providers_page_template']);
        add_filter('template_include', [__CLASS__, 'load_providers_template']);
        add_shortcode('appspring_providers', [__CLASS__, 'render_providers_shortcode']);
    }

    /**
     * Register a custom rewrite rule for the /providers URL.
     */
    public static function register_providers_page_template() {
        add_rewrite_rule('^providers/?$', 'index.php?appspring_providers_page=1', 'top');
        add_rewrite_tag('%appspring_providers_page%', '1');
    }

    /**
     * Use a custom template for the /providers route.
     */
    public static function load_providers_template($template) {
        if (get_query_var('appspring_providers_page') === '1') {
            return APPSPRING_PLUGIN_PATH . 'templates/template-providers-page.php';
        }
        return $template;
    }

    /**
     * Shortcode renderer for [appspring_providers]
     */
    public static function render_providers_shortcode() {
        ob_start();

        $response = Appspring_API::get_providers();
        $providers = $response['data'] ?? [];

        $all_states = [];
        foreach ($providers as $provider) {
            if (!empty($provider['states'])) {
                $all_states = array_merge($all_states, $provider['states']);
            }
        }
        $states = array_unique($all_states);
        sort($states);

        ?>
        <div class="appspring-container">
            <h1>Our Providers</h1>

            <div class="filter-row">
                <label for="stateFilter"><strong>Filter by state:</strong></label>
                <select id="stateFilter">
                    <option value="">All</option>
                    <?php foreach ($states as $state): ?>
                        <option value="<?php echo esc_attr($state); ?>"><?php echo esc_html($state); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="providersGrid" class="appspring-grid">
                <?php foreach ($providers as $provider): ?>
                    <div class="provider-card" data-tags="<?php echo esc_attr(implode(',', $provider['states'] ?? [])); ?>">
                        <?php if (!empty($provider['avatarUrl'])): ?>
                            <img src="<?php echo esc_url($provider['avatarUrl']); ?>" alt="Avatar" />
                        <?php endif; ?>
                        <h3><?php echo esc_html($provider['name'] ?? 'Unnamed'); ?></h3>
                        <?php if (!empty($provider['education'])): ?>
                            <p><strong><?php echo esc_html($provider['education']); ?></strong></p>
                        <?php endif; ?>
                        <?php if (!empty($provider['states'])): ?>
                            <p><em>States:</em> <?php echo implode(', ', array_map('esc_html', $provider['states'])); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}
