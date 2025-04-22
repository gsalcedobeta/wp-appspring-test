<?php

class Appspring_API {
    const PROVIDERS_API_URL = 'https://signin.healthloftco.com/api/providers';
    const TAGS_API_URL = 'https://signin.healthloftco.com/api/tags';
    const CACHE_EXPIRATION = 3600; // 60 minutes

    public static function init() {
        add_action('init', [__CLASS__, 'maybe_refresh_cache']);
    }

    public static function maybe_refresh_cache() {
        $last_updated = get_option('appspring_cache_timestamp');

        if (!$last_updated || (time() - $last_updated) > self::CACHE_EXPIRATION) {
            self::fetch_and_store_data();
        }
    }

    public static function fetch_and_store_data() {
        $providers = self::fetch_data(self::PROVIDERS_API_URL);
        $tags = self::fetch_data(self::TAGS_API_URL);

        if (!empty($providers)) {
            update_option('appspring_providers_data', $providers);
        }

        if (!empty($tags)) {
            update_option('appspring_tags_data', $tags);
        }

        update_option('appspring_cache_timestamp', time());
    }

    private static function fetch_data($url) {
        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        return is_array($data) ? $data : false;
    }

    public static function get_providers() {
        return get_option('appspring_providers_data', []);
    }

    public static function get_tags() {
        return get_option('appspring_tags_data', []);
    }
}
