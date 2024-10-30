<?php
/*
Plugin Name: Call Now
Plugin URI: http://echobyte.net/
Description: Mobile Calling .
Version: 0.1.0
Author: Nabeel Yasin
Author URI: http://echobyte.net
License: GPL2
*/
 

// Add Admin Stuff

add_action( 'admin_menu', 'call_now_add_admin_menu' );
add_action( 'admin_init', 'call_now_settings_init' );
add_action( 'admin_enqueue_scripts', 'call_now_add_color_picker' );

//Add Call Now to Footer

add_action( 'wp_footer', 'call_now_code' );

// Load Color Picker

function call_now_add_color_picker( $hook ) {

    if( is_admin() ) {

        // Add Color Picker CSS
        wp_enqueue_style( 'wp-color-picker' );

        // Include Color Picker JS
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'call_now.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}

// Add to Menu > Tools

function call_now_add_admin_menu(  ) {

    add_submenu_page( 'options-general.php', 'Call Now', 'Call Now', 'manage_options', 'call_now', 'call_now_options_page' );

}

// Adding Settings

function call_now_settings_init(  ) {

    register_setting( 'call_now_plugin_page', 'call_now_settings' );

    add_settings_section(
        'call_now_plugin_page_section',
        __( 'A Calling plugin that add call now functionality to your WordPress site on mobile devices.', 'call_now' ),
        'call_now_settings_section_callback',
        'call_now_plugin_page'
    );

    add_settings_field(
        'call_now_enable',
        __( 'Enable Call Now', 'call_now' ),
        'call_now_enable_render',
        'call_now_plugin_page',
        'call_now_plugin_page_section'
    );

    add_settings_field(
        'call_now_text',
        __( 'Your  Call Now  Text', 'call_now' ),
        'call_now_text_render',
        'call_now_plugin_page',
        'call_now_plugin_page_section'
    );

    add_settings_field(
        'call_now_number',
        __( 'Your Click to Call Number', 'call_now' ),
        'call_now_number_render',
        'call_now_plugin_page',
        'call_now_plugin_page_section'
    );

    add_settings_field(
        'call_now_color',
        __( 'Call Now Text Color', 'call_now' ),
        'call_now_color_render',
        'call_now_plugin_page',
        'call_now_plugin_page_section'
    );

    add_settings_field(
        'call_now_bg',
        __( 'Call Now Background Color', 'call_now' ),
        'call_now_bg_render',
        'call_now_plugin_page',
        'call_now_plugin_page_section'
    );
}

// Render Admin Input

function call_now_enable_render(  ) {

    $options = get_option( 'call_now_settings' );
    ?>
    <input name="call_now_settings[call_now_enable]" type="hidden" value="0" />
    <input name="call_now_settings[call_now_enable]" type="checkbox" value="1" <?php checked( '1', $options['call_now_enable'] ); ?> />

    <?php

}


function call_now_text_render(  ) {

    $options = get_option( 'call_now_settings' );
    ?>
    <input type='text' placeholder="ex. Call Now!" name='call_now_settings[call_now_text]' value='<?php echo $options['call_now_text']; ?>'>
    <?php

}


function call_now_number_render(  ) {

    $options = get_option( 'call_now_settings' );
    ?>
    <input type='text' placeholder="ex. 1234567890" name='call_now_settings[call_now_number]' value='<?php echo $options['call_now_number']; ?>'>
    <?php

}


function call_now_color_render(  ) {

    $options = get_option( 'call_now_settings' );
    ?>
    <input type='text' class="color-field"  name='call_now_settings[call_now_color]' value='<?php echo $options['call_now_color']; ?>'>
    <?php

}


function call_now_bg_render(  ) {

    $options = get_option( 'call_now_settings' );
    ?>
    <input type='text' class="color-field" name='call_now_settings[call_now_bg]' value='<?php echo $options['call_now_bg']; ?>'>
    <?php

}

function call_now_settings_section_callback(  ) {
    echo __( 'Enter your information in the fields below.This plugin will show only on devices with screen width under 736px. ', 'click_to_call' );

}

// Output Code If Enabled

function call_now_code() {
    $options = get_option( 'call_now_settings' );
    if ($options['call_now_enable'] == '1') {
     echo '<a href="tel:' . $options['call_now_number'] . '" onclick="ga(\'send\',\'event\',\'Phone\',\'Click To Call\', \'Phone\')"; style="color:' . $options['call_now_color'] . ' !important; background-color:' . $options['call_now_bg'] . ';" class="call_now_bar" id="call_now_bar""> ' . $options['call_now_text'] . '</a>';
        wp_enqueue_style('ctc-styles', plugin_dir_url( __FILE__ ) . 'call_now_style.css' );
    } 
}

// Display Admin Form

function call_now_options_page(  ) {

    ?>
    <form action='options.php' method='post'>

        <h1>Call Now Button</h1>

        <?php
        settings_fields( 'call_now_plugin_page' );
        do_settings_sections( 'call_now_plugin_page' );
        submit_button();
        ?>

    </form>
    <?php

}

?>
