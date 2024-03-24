<?php
/**
 * Plugin Name:       Daily Workout
 * Plugin URI:        https://wod-generator.com/wordpress-plugin/
 * Description:       Adds a Daily Workout widget and shortcode to your WordPress site, helping your users stay fit!
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.1
 * Author:            7imDev
 * Author URI:        https://wod-generator.com/wordpress-plugin/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       daily-workout
 * Domain Path:       /languages
 */

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'inc/class-daily-workout-widget.php';
require_once plugin_dir_path(__FILE__) . 'inc/shortcode-daily-workout.php';

// Check if WP_Filesystem is already loaded
if ( ! function_exists( 'WP_Filesystem' ) ) {
    require_once ABSPATH . '/wp-admin/includes/file.php';
}

// Initialize the WP_Filesystem
if ( ! WP_Filesystem() ) {
    // Failed to initialize, handle the error
    return;
}

/**
 * Activation Hook
 */
function daily_workout_activate(): void
{
    if (!wp_next_scheduled('daily_workout_fetch_task')) {
        wp_schedule_event(time(), 'hourly', 'daily_workout_fetch_task');
    }

    daily_workout_fetch_and_save_workout();
    update_option('daily_workout_option_show_link', 1);
}

register_activation_hook(__FILE__, 'daily_workout_activate');

/**
 * Deactivation Hook
 */
function daily_workout_deactivate(): void
{
    $timestamp = wp_next_scheduled('daily_workout_fetch_task');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'daily_workout_fetch_task');
    }
}

register_deactivation_hook(__FILE__, 'daily_workout_deactivate');


function daily_workout_fetch_and_save_workout()
{
    $url = 'https://wod-generator.com/workout.json';
    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return;
    }

    $workout = wp_remote_retrieve_body($response);
    $workout_json = json_decode($workout, true);

    // Validate the required fields
    if (!is_array($workout_json) ||
        empty($workout_json['title']) ||
        empty($workout_json['content']) ||
        empty($workout_json['link']) ||
        empty($workout_json['published_at'])) {
        return; // One of the required fields is missing or empty, do not save
    }

    // Define storage path
    $storage_path = plugin_dir_path(__FILE__) . 'storage/workout.json';

    // Check if file exists and compare content
    if (file_exists($storage_path)) {
        $current_workout_json = json_decode(file_get_contents($storage_path), true);

        // Compare the fetched workout with the stored one
        if ($workout_json === $current_workout_json) {
            return; // Exit if they are the same
        }
    }

    // Ensure the storage directory exists using wp_mkdir_p()
    $directory_path = dirname($storage_path);

    if (!is_dir($directory_path)) {
        if (!wp_mkdir_p($directory_path)) {
            error_log('Failed to create directory for saving workout: ' . $directory_path);
            return;
        }
    }

    // Use WP_Filesystem's method to write to the file
    global $wp_filesystem;

    if (!$wp_filesystem->put_contents($storage_path, $workout, FS_CHMOD_FILE)) {
        error_log('Failed to write workout data to file: ' . $storage_path);
    }
}

add_action('daily_workout_fetch_task', 'daily_workout_fetch_and_save_workout');