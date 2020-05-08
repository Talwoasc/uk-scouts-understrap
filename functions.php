<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Set the default value for the Theme Credits
 */
if ( ! function_exists( 'uk_scouts_theme_credits_default' ) ) {
    function uk_scouts_theme_credits_default() {
        $the_theme = wp_get_theme();

        return sprintf(
            '<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s',
            esc_url( __( 'http://wordpress.org/', 'understrap' ) ),
            sprintf(
                /* translators:*/
                esc_html__( 'Proudly powered by %s', 'understrap' ),
                'WordPress'
            ),
            sprintf( // WPCS: XSS ok.
                /* translators:*/
                esc_html__( '%1$s theme based on %2$s.', 'understrap' ),
                '<strong><a href="' . esc_url( $the_theme->get( 'ThemeURI' ) ) . '">' . $the_theme->get( 'Name' ) . '</a></strong>',
                '<a href="' . esc_url( __( 'http://understrap.com', 'understrap' ) ) . '">understrap.com</a>'
            )
        );
    }
}


/**
 * Add support for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'uk_scouts_theme_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function uk_scouts_theme_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        

        // Site Info settings.
		$wp_customize->add_section(
			'uk_scouts_siteinfo_options',
			array(
				'title'       => __('Site Info Settings', 'uk-scouts-understrap'),
				'capability'  => 'edit_theme_options',
				'priority'    => 30,
			)
        );

        $wp_customize->add_setting(
			'uk_scouts_copyright_entity',
			array(
				'default'           => get_bloginfo( 'name' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_copyright_entity',
            array(
                'label' => __( 'Copyright Entity Name', 'uk-scouts-understrap' ),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_charity_number',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_charity_number',
            array(
                'label' => __( 'Charity Number', 'uk-scouts-understrap' ),
                'description' => __( 'Can include any text in case you need to specify multiple numbers', 'uk-scouts-understrap'),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_theme_credits',
			array(
				'default'           => uk_scouts_theme_credits_default(),
				'sanitize_callback' => 'wp_filter_post_kses',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_theme_credits',
            array(
                'label' => __( 'Theme Credits', 'uk-scouts-understrap' ),
                'description' => __( 'Let other Scout Groups find this theme so we can all have great looking websites!', 'uk-scouts-understrap'),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );
	}
}
add_action( 'customize_register', 'uk_scouts_theme_customize_register' );


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

function uk_scouts_widget_classes( $params ) {

    global $wp_registered_widgets;

    if ( ! isset( $params[0] ) ) {
        return $params;
    }

    $widget_id              = $params[0]['widget_id'];
    $widget                 = $wp_registered_widgets[ $widget_id ];
    // Stupidly complicated way to get the widget instance settings
    $settings = $widget['callback'][0]->get_settings()[ $params[1]['number'] ];
    
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
add_filter( 'dynamic_sidebar_params', 'uk_scouts_widget_classes', 100 );

/*
 * Default UnderStrap child class code below this point
 */
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );
