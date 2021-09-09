<?php
    /*
    Plugin Name: Custom plugin
    Plugin URI: http://test.com
    Description: Show custom message on user dashboard. 
    Author: Hadrien Mongouachon
    */

class Custom_Plugin {
    private $options;
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action('woocommerce_account_dashboard', array( $this, 'display_custom_message' ));
    }
    // display custom message
    public function display_custom_message()
    {
        
        $field = get_option( 'my_option_name' );
        if($field['extra_field_display'] == 'yes'){
             echo '<div class="custom-field" style="background-color:#eeeeee; border : 1px solid #999999; padding:20px; font-size: 16px; line-height:1.4;">';
             echo $field['extra_field_msg'];
             echo '</div>';
        }
    }
    // add plugin page
    public function add_plugin_page()
    {
        add_options_page(
            'Settings Admin', 
            'Custom plugin', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }
    // option page template
    public function create_admin_page()
    {
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Settings</h1>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }
    // register / add settings
    public function page_init()
    {   
        // register
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        // add
        add_settings_section(
            'setting_section_id', 
            'Settings', 
            array( $this, 'print_page_description' ), 
            'my-setting-admin' 
        );  
        // field 1
        add_settings_field(
            'extra_field_msg', // ID
            'Message', // Title 
            array( $this, 'extra_field_msg_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );    
        // field 2  
        add_settings_field(
            'extra_field_display', 
            'Show message', 
            array( $this, 'extra_field_display_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }
    // utils : sanitize input
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['extra_field_msg'] ) )
            $new_input['extra_field_msg'] = sanitize_text_field( $input['extra_field_msg'] );

        if( isset( $input['extra_field_display'] ) )
            $new_input['extra_field_display'] = sanitize_text_field( $input['extra_field_display'] );

        return $new_input;
    }
    // page description
    public function print_page_description()
    {
        print 'This message will appear on user dashboard panel:';
    }
    // custom message template
    public function extra_field_msg_callback()
    {
        $value = isset( $this->options['extra_field_msg'] ) ? esc_attr( trim($this->options['extra_field_msg'])) : '';
        ?>
            <textarea id="extra_field_msg" name="my_option_name[extra_field_msg]" rows="4" cols="40"><?php echo $value;?></textarea>
        <?php
    }
   // custom radio buttons template
    public function extra_field_display_callback()
    {
        $value = isset( $this->options['extra_field_display'] ) ? esc_attr( $this->options['extra_field_display']) : '';
        ?>
            <select id="extra_field_display" name="my_option_name[extra_field_display]">
                <option value="yes" <?php if ($value == 'yes') echo 'selected="selected"';?>>Yes</option>
                <option value="no"  <?php if ($value == 'no') echo ' selected="selected"';?>>No</option>
            </select>
        <?php
    }
}
// init plugin
$custom_plugin =new Custom_Plugin();