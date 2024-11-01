<?php
/**
* Plugin Name: WP Hummingbird Purger
* Author:  Joe Uttaro
* Author URI: http://joeuttaro.com/
* Version: 1.0.0
* Description: Allows for users to flush the WP Hummingbird page cache.
*/

// Register options page
add_action('admin_menu', 'wp_hummingbird_purge_register_menu_page');
function wp_hummingbird_purge_register_menu_page() {
    add_menu_page('Purge Hummingbird Cache', 'Purge Cache', 'purge_cache', 'wp-hummingbird-purge', 'wp_hummingbird_purge_menu_page', 'dashicons-image-rotate', 9999);
}

// Draw options page
function wp_hummingbird_purge_menu_page() { ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Purge Hummingbird Page Cache</h2>
        <?php if (class_exists('WP_Hummingbird_Module_Page_Cache')){ ?>

            <?php if($_GET['purge'] == '1'){ ?>
                <?php WP_Hummingbird_Module_Page_Cache::clear_cache(); ?>

                <div class="notice notice-success is-dismissible">
                    <p>Cache purged.</p>
                </div>

            <?php } ?>
            <div class="notice notice-info">
                <p>
                    Clicking "Purge Cache" will purge the the Hummingbird page cache for all sites. 
                    This will affect site performance as caches will need to be rebuilt. &nbsp; &nbsp;
                    <a class='button button-primary' href='?page=wp-hummingbird-purge&purge=1' style="vertical-align: initial!important;">Purge Cache</a>
                </p>
            </div>

            <hr>

        <?php }else{ ?>
            <p>Hummingbird is not installed. Please install this plugin before continuing.</p>
        <?php } ?>
    </div>
<?php }

// Add capability on activate
register_activation_hook(__FILE__, 'wp_hummingbird_purge_activate_plugin');
function wp_hummingbird_purge_activate_plugin(){
    $role = get_role('administrator');
    $role->add_cap('purge_cache'); 
}
