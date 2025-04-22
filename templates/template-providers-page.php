<?php
/**
 * Template Name: Providers Page
 * Template Post Type: page
 * Description: Template: Providers Page with searchable dropdown (Choices.js)
 */

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

get_header();
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

<?php get_footer(); ?>