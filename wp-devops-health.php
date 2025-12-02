<?php
/*
Plugin Name: WP DevOps Health Check
Description: Exposes server stats via REST API for DevOps monitoring.
Version: 1.0.0
Author: DevOps Intern
*/

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Register the API Endpoint
add_action('rest_api_init', function () {
    register_rest_route('devops/v1', '/status', array(
        'methods' => 'GET',
        'callback' => 'get_server_status',
        'permission_callback' => '__return_true', // Public access
    ));
});

// The Function that gathers data
function get_server_status() {
    return array(
        'status' => 'healthy',
        'system' => php_uname(),
        'php_version' => phpversion(),
        'disk_free_mb' => round(disk_free_space("/") / 1024 / 1024, 2),
        'memory_usage_mb' => round(memory_get_usage() / 1024 / 1024, 2),
        'timestamp' => time()
    );
}
