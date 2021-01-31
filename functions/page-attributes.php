<?php
/**
 * Default UnderStrap child class code.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * A class for hooking into page attributes to add custom controls.
 * 
 * Extra options:
 * - Header background color.
 * - Header text color.
 */
class Page_Attributes_Uk_Scouts_Theme {

    protected static $defaults = array(
        'uk_scouts_header_background_color' => 'navy',
        'uk_scouts_header_text_color' => 'light',
    );

    protected static $friendly_names = array(
        'uk_scouts_header_background_color' => 'Header Background Color',
        'uk_scouts_header_text_color' => 'Header Text Color',
    );

    public static function getDefault($key) {
        return self::$defaults[ $key ];
    }

    public static function getFriendlyName($key) {
        return self::$friendly_names[ $key ];
    }

    public static function getAttribute($post, $attribute) {
        return metadata_exists('post', $post->ID, $attribute) ? $post->$attribute : self::getDefault($attribute);
    }

    public static function getHeaderBackgroundColor($post) {
        return self::getAttribute($post, 'uk_scouts_header_background_color');
    }

    public static function getHeaderTextColor($post) {
        return self::getAttribute($post, 'uk_scouts_header_text_color');
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
        // Define this in the constructor since only statically initialized values can be declared outside
        $this->allowed_values = array(
            'uk_scouts_header_background_color' => array( self::getDefault('uk_scouts_header_background_color') ) + $this->colors ,
            'uk_scouts_header_text_color' => array( self::getDefault('uk_scouts_header_text_color') ) + $this->colors ,
        );

        // Hook in all the right places.
        add_action( 'page_attributes_misc_attributes', array( $this, 'add_settings' ), 10, 1 );
        add_action( 'save_post_page', array( $this, 'save_settings' ), 10, 3 );
    }

    /**
     * Adds custom Page Attributes
     * 
     * @param object $post The post object
     */
    public function add_settings( $post ) {
        if ( ! $this->is_supported( $post ) ) {
            return null;
        }
        ?>
        <? foreach ( $this->allowed_values as $attribute => $allowed ): ?>
            <p class="post-attributes-label-wrapper">
                <label for="<?php echo esc_attr( $attribute ); ?>">
                    <?php echo esc_html( self::getFriendlyName( $attribute ) ) . ':'; ?>
                </label>
            </p>
            <select id="<?php echo esc_attr( $attribute ); ?>"
                name="<?php echo esc_attr( $attribute ); ?>"
            >
            <?php foreach ( $allowed as $value ): ?>
                <option value="<?php echo $value; ?>"<? if ( self::getAttribute( $post, $attribute ) === $value ): ?> selected="selected"<?php endif ?>><?php echo ucfirst($value); ?></option>
            <?php endforeach ?>
            </select>
        <?php endforeach ?>
        <?php
    }

    /**
     * Saves the custom Page Attributes.
     *
     * @param object $post The post object
     */
    public function save_settings( $post_id, $post, $update ) {
        if ( ! $this->is_supported( $post ) ) {
            return null;
        }

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }
    
        if ( defined('DOING_AJAX') && DOING_AJAX ) {
            return;          
        }
    
        foreach ( $this->allowed_values as $attribute => $allowed ) {
            // Now check that a value is actually present, and assign it sanitized.
            if ( isset( $_REQUEST[$attribute] ) && in_array( $_REQUEST[$attribute], $allowed, true ) ) {
                update_post_meta( $post_id, $attribute, $_REQUEST[$attribute] );
            }
        }
    }

    /**
     * Check that this is a supported post type.
     * Currently only support "page" as we only put page headers on pages.
     */
    protected function is_supported( $post ) {
        return $post->post_type === 'page';
    }
}

new Page_Attributes_Uk_Scouts_Theme();
