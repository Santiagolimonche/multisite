<?php
/**
 * sl-multisite.php
 *
 * Copyright (c) 2021 Santiago Limonche
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * Plugin Name: Plugin multisitio
 * Description: Ejemplo de plugin multisitio
 * Version: 1.0.0
 * Author: Santiago Limonche
 * Author URI: https://www.santilimonche.com
 * Text Domain: sl-multisite
 * Domain Path: /languages
 * License: GPLv3
 */

if (! defined ( 'SL_MULTISITE_CORE_DIR' )) {
	define ( 'SL_MULTISITE_CORE_DIR', WP_PLUGIN_DIR . '/sl-multisite' );
}
define ( 'SL_MULTISITE_FILE', __FILE__ );

define ( 'SL_MULTISITE_PLUGIN_URL', plugin_dir_url ( SL_MULTISITE_FILE ) );

class SL_Multisite_Plugin {

    public static function init() {

        add_action ( 'init', array (
                __CLASS__,
                'wp_init'
        ) );

        wp_enqueue_style( 'sl-multisite-style', SL_MULTISITE_PLUGIN_URL . 'css/sl-multisite.css');
    }

    public static function wp_init() {

        self::sl_multisite_wp_footer();

        // Maybe error (no load) in function is_plugin_active_for_network
        if ( !function_exists('is_plugin_active_for_network') ) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        if (is_multisite()) {
            // check if the plugin has been activated on the network or on a single site
            if (is_plugin_active_for_network('sl-multisite/sl-multisite.php')) {
                // set current blog in multisite
                $blog_id = get_current_blog_id();
                switch_to_blog($blog_id);
                self::sl_multisite_wp_footer();
                restore_current_blog();
            }
            else {
                // activated on a single site, in a multi-site
               self::sl_multisite_wp_footer();
            }
        }
        else {
            // activated on a single site
            self::sl_multisite_wp_footer();
        }

    }

    public static function sl_multisite_wp_footer() {

        $content = '<div class="sl-multisite-info">';

        $content .= '<p> URL del sitio: <span class="info">' .  get_bloginfo( 'url' ) . '</span></p>';
        $content .= '<p> Nombre del sito: <span class="info">' .  get_bloginfo( 'name' ) . '</span></p>';
        $content .= '<p> Email del administrador: <span class="info">' . get_bloginfo('admin_email') . '</span></p>';
        if ( is_single() || is_page() ) {
            $content .= '<p> La ID de la página o post es: <span class="info">' . get_the_ID() . '</span></p>';
            $content .= '<p> El título de la página o post es: <span class="info">' . get_the_title() . '</span></p>';
        }

        $content .= '</div>';

        return $content;

    }



}
SL_Multisite_Plugin::init();