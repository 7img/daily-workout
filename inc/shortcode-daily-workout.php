<?php

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Register the shortcode
function daily_workout_register_shortcode() {
    add_shortcode('daily_workout', 'daily_workout_shortcode');
}
add_action('init', 'daily_workout_register_shortcode');

function daily_workout_shortcode() {
    $output = ''; // Initialize the output variable

    // Path to the JSON file
    $json_file = plugin_dir_path(__DIR__) . 'storage/workout.json';

    // Check if the workout JSON file exists
    if (file_exists($json_file)) {
        // Get the JSON content
        $json_content = file_get_contents($json_file);
        $workout = json_decode($json_content, true);

        if ($workout) {
            // Convert published date to a more readable format and to an attribute
            $date = new DateTime($workout['published_at']);
            $isoDate = $date->format(DateTime::ATOM); // For the datetime attribute
            $content = str_replace("\n", "<br>", $workout['content']);

            // Start generating the output as an article
            $output .= '<article class="daily-workout" published="' . esc_attr($isoDate) . '">';
            $output .= '<header><h2>' . esc_html($workout['title']) . '</h2></header>';
            $output .= '<div>' . wp_kses_post($content) . '</div>';

            $option = get_option('daily_workout_option_show_link', false);

            if (!empty($option)) {
                $output .= '<footer style="margin-top: 10px;"><a style="font-size:.85rem;" href="' . esc_url($workout['link']) . '" target="_blank">' . esc_html__('Explore efficient warmup, cooldown, & equipment-free options', 'daily-workout') . '</a></footer>';
            }
           $output .= '</article>';
        } else {
            $output = '<p>' . esc_html__('Error loading workout. Please try again later.', 'daily-workout') . '</p>';
        }
    } else {
        $output = '<p>' . esc_html__('Workout information is currently unavailable. Please check back later.', 'daily-workout') . '</p>';
    }

    return $output;
}