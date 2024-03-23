<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Include WordPress Widget class
if (!class_exists('WP_Widget')) {
    require_once ABSPATH . 'wp-includes/class-wp-widget.php';
}

class Daily_Workout_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'daily_workout_widget', // Base ID
            __('Daily Workout', 'daily-workout'), // Name
            array('description' => __('Displays the daily workout using a shortcode.', 'daily-workout')) // Args
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Check if title is set in the widget settings
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo do_shortcode('[daily_workout]');

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('New title', 'daily-workout');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'daily-workout'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

// Register the widget
function register_daily_workout_widget() {
    register_widget('Daily_Workout_Widget');
}
add_action('widgets_init', 'register_daily_workout_widget');
