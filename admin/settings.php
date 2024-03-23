<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Add the settings page to the WordPress admin menu
add_action('admin_menu', 'daily_workout_add_admin_menu');
function daily_workout_add_admin_menu() {
    add_options_page(
        __('Daily Workout Settings', 'daily-workout'), // Page title
        'Daily Workout', // Menu title
        'manage_options', // Capability
        'daily-workout-settings', // Menu slug
        'daily_workout_options_page' // Callback function to output the page content
    );
}

// Register settings, sections, and fields
add_action('admin_init', 'daily_workout_register_settings');
function daily_workout_register_settings() {
    // Register a single option
    register_setting('daily_workout_options_group', 'daily_workout_option_show_link', ['default' => '1']);

    // Add a new section within the "Daily Workout" options page
    add_settings_section(
        'daily_workout_settings_section',
        __('Daily Workout Settings', 'daily-workout'),
        'daily_workout_settings_section_cb',
        'daily-workout-settings'
    );

    // Add the field for the option
    add_settings_field(
        'daily_workout_option_show_link',
        __('Show Link to Complete Workout', 'daily-workout'),
        'daily_workout_option_show_link_cb',
        'daily-workout-settings',
        'daily_workout_settings_section',
        [
            'label_for' => 'daily_workout_option_show_link',
            'class' => 'daily_workout_row',
        ]
    );
}

// Section callback function - Optional content displayed above the section title
function daily_workout_settings_section_cb() {
    echo '<p>' . esc_html__('Adjust the settings for the Daily Workout plugin.', 'daily-workout') . '</p>';
}

// Callback function for the 'show link' field
function daily_workout_option_show_link_cb() {
    // Retrieve the value of the 'daily_workout_option_show_link' setting
    $option = get_option('daily_workout_option_show_link', '1');
    ?>
    <input type="checkbox" id="daily_workout_option_show_link"
           name="daily_workout_option_show_link"
           value="1" <?php checked('1', $option); ?>/>
    <label for="daily_workout_option_show_link">
        <?php esc_html_e('Support this plugin by placing a link to the original workout. This also allows users to see warmups, cooldowns, and no-equipment options.', 'daily-workout'); ?>
    </label>
    <?php
}

// Callback for the settings page output
function daily_workout_options_page() {
    ?>
    <div class="wrap">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form action="options.php" method="post">
            <?php
            settings_fields('daily_workout_options_group');
            do_settings_sections('daily-workout-settings');
            submit_button(__('Save Settings', 'daily-workout'));
            ?>
        </form>
    </div>
    <?php
}
