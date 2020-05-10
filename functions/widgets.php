<?php
/**
 * Widget declarations and extensions.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * A class for hooking into all widgets and providing extra controls.
 * 
 * Extra options:
 * - Background color.
 * - Text color.
 * - Card style (extra internal padding).
 */
class Widgets_Uk_Scouts_Theme {

    protected static $defaults = array(
        'uk_scouts_background_color' => 'transparent',
        'uk_scouts_text_color' => 'default',
        'uk_scouts_card' => "false",
    );

    public static function getDefault($key) {
        return self::$defaults[ $key ];
    }

    protected $colors = array(
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
        'black',
        'white',
        'blue',
        'purple',
        'pink',
        'red',
        'yellow',
        'green',
        'teal',
        'navy',
    );

    protected $allowed_values;

    function __construct() {
        // Hook in all the right places.
        add_action( 'in_widget_form', array( $this, 'add_settings' ), 10, 3 );
        add_filter( 'widget_update_callback', array( $this, 'save_settings' ), 10, 4 );
        
        // Define this in the constructor since only statically initialized values can be declared outside
        $this->allowed_values = array(
            'uk_scouts_background_color' => array( self::getDefault('uk_scouts_background_color') ) + $this->colors ,
            'uk_scouts_text_color' => array( self::getDefault('uk_scouts_text_color') ) + $this->colors ,
            'uk_scouts_card' => array(
                'true',
                'false',
            ),
        );
    }

    /**
     * Adds the custom settings to all widgets' forms.
     *
     * @param WP_Widget $widget   An instance of a WP_Widget derived subclass.
     * @param mixed     $return   Return null if new fields are added.
     * @param array     $instance An array of the widget's settings.
     */
    public function add_settings( $widget, $return, $instance ) {
        if ( ! $this->is_supported( $widget ) ) {
            return null;
        }

        // Make sure $instance contains at least our default values.
        $instance = wp_parse_args( $instance, self::$defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_background_color' ) ); ?>">
                <?php echo esc_html( 'Background Color' ) . ":"; ?>
            </label>
            <select id="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_background_color' ) ); ?>"
                name="<?php echo esc_attr( $widget->get_field_name( 'uk_scouts_background_color' ) ); ?>"
            >
            <?php foreach ( $this->allowed_values['uk_scouts_background_color'] as $value ): ?>
                <option value="<?php echo $value; ?>"<? if ( $instance['uk_scouts_background_color'] === $value ): ?> selected="selected"<?php endif ?>><?php echo ucfirst($value); ?></option>
            <?php endforeach ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_text_color' ) ); ?>">
                <?php echo esc_html( 'Text Color' ) . ":"; ?>
            </label>
            <select id="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_text_color' ) ); ?>"
                name="<?php echo esc_attr( $widget->get_field_name( 'uk_scouts_text_color' ) ); ?>"
            >
            <?php foreach ( $this->allowed_values['uk_scouts_text_color'] as $value ): ?>
                <option value="<?php echo $value; ?>"<? if ( $instance['uk_scouts_text_color'] === $value ): ?> selected="selected"<?php endif ?>><?php echo ucfirst($value); ?></option>
            <?php endforeach ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_card' ) ); ?>">
                <?php echo esc_html( 'Display as a card', 'uk-scouts-understrap' ) . ":"; ?>
            </label>
            <select id="<?php echo esc_attr( $widget->get_field_id( 'uk_scouts_card' ) ); ?>"
                name="<?php echo esc_attr( $widget->get_field_name( 'uk_scouts_card' ) ); ?>"
            >
            <?php foreach ( $this->allowed_values['uk_scouts_card'] as $value ): ?>
                <option value="<?php echo $value; ?>"<? if ( $instance['uk_scouts_card'] === $value ): ?> selected="selected"<?php endif ?>><?php echo ucfirst($value); ?></option>
            <?php endforeach ?>
            </select>
        </p>
        <?php
    }

    /**
     * Saves the custom settings.
     *
     * @param array     $instance     The current widget instance's settings.
     * @param array     $new_instance Array of new widget settings.
     * @param array     $old_instance Array of old widget settings.
     * @param WP_Widget $widget       The current widget instance.
     *
     * @return array The widget instance's settings to get saved.
     */
    public function save_settings( $instance, $new_instance, $old_instance, $widget ) {
        if ( ! $this->is_supported( $widget ) ) {
            return $instance;
        }

        // Make sure $instance contains at least our default values.
        $instance = wp_parse_args( $instance, self::$defaults );

        // Now check that a value is actually present, and assign it sanitized.
        if ( isset( $new_instance['uk_scouts_background_color'] ) && in_array( $new_instance['uk_scouts_background_color'], $this->allowed_values['uk_scouts_background_color'], true ) ) {
            $instance['uk_scouts_background_color'] = $new_instance['uk_scouts_background_color'];
        }

        // Now check that a value is actually present, and assign it sanitized.
        if ( isset( $new_instance['uk_scouts_text_color'] ) && in_array( $new_instance['uk_scouts_text_color'], $this->allowed_values['uk_scouts_text_color'], true ) ) {
            $instance['uk_scouts_text_color'] = $new_instance['uk_scouts_text_color'];
        }
        
        // Now check that a value is actually present, and assign it sanitized.
        if ( isset( $new_instance['uk_scouts_card'] ) && in_array( $new_instance['uk_scouts_card'], $this->allowed_values['uk_scouts_card'], true ) ) {
            $instance['uk_scouts_card'] = $new_instance['uk_scouts_card'];
        }

        return $instance;
    }

    protected function is_supported( WP_Widget $widget ) { return true;	}
}

new Widgets_Uk_Scouts_Theme();

/**
 * Apply the settings from the Widgets_Uk_Scouts_Theme class to all widgets.
 * 
 * @link https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
 * 
 * @global array $wp_registered_widgets
 * 
 * @param array $params {
 *     @type array $args  {
 *         An array of widget display arguments.
 *
 *         @type string $name          Name of the sidebar the widget is assigned to.
 *         @type string $id            ID of the sidebar the widget is assigned to.
 *         @type string $description   The sidebar description.
 *         @type string $class         CSS class applied to the sidebar container.
 *         @type string $before_widget HTML markup to prepend to each widget in the sidebar.
 *         @type string $after_widget  HTML markup to append to each widget in the sidebar.
 *         @type string $before_title  HTML markup to prepend to the widget title when displayed.
 *         @type string $after_title   HTML markup to append to the widget title when displayed.
 *         @type string $widget_id     ID of the widget.
 *         @type string $widget_name   Name of the widget.
 *     }
 *     @type array $widget_args {
 *         An array of multi-widget arguments.
 *
 *         @type int $number Number increment used for multiples of the same widget.
 *     }
 * }
 * @return array $params
 */
function uk_scouts_widget_classes( $params ) {

    if ( is_admin() || ! isset( $params[0] )  ) {
        return $params;
    }

    global $wp_registered_widgets;

    $widget_id = $params[0]['widget_id'];
    $widget = $wp_registered_widgets[ $widget_id ]['callback'][0];
    // Stupidly complicated way to get the widget instance settings
    $settings = $widget->get_settings()[ $params[1]['number'] ];

    if ( isset( $settings['uk_scouts_background_color'] ) && Widgets_Uk_Scouts_Theme::getDefault('uk_scouts_background_color') !== $settings['uk_scouts_background_color'] ) {
        $classes[] = 'bg-' . $settings['uk_scouts_background_color'];
    }

    if ( isset( $settings['uk_scouts_text_color'] ) && Widgets_Uk_Scouts_Theme::getDefault('uk_scouts_text_color') !== $settings['uk_scouts_text_color'] ) {
        $classes[] = 'text-' . $settings['uk_scouts_text_color'];
    }

    if ( isset( $settings['uk_scouts_card'] ) && $settings['uk_scouts_card'] === 'true' ) {
        $classes[] = 'card-body';
    }

    if ( ! isset( $classes ) ) {
        return $params;
    }

    $params[0]['before_widget'] = $params[0]['before_widget'] . '<div class="' . join(' ', $classes) . '">';
    $params[0]['after_widget'] = '</div>' . $params[0]['after_widget'];

    return $params;
}

/**
 * Add filter to the parameters passed to a widget's display callback.
 * The filter is evaluated on both the front and the back end!
 *
 * @link https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
 */
add_filter( 'dynamic_sidebar_params', 'uk_scouts_widget_classes', 100 );
