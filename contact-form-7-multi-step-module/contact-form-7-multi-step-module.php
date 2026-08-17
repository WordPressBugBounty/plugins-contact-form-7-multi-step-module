<?php

/*
Plugin Name: Webheadcoder Multi-Step Forms for Contact Form 7
Plugin URI: https://webheadcoder.com/contact-form-7-multi-step-forms/
Description: Adds multi-page, multi-step forms to Contact Form 7.
Requires Plugins:  contact-form-7
Author: Webhead LLC.
Author URI: https://webheadcoder.com/
Version: 4.7
Text Domain: contact-form-7-multi-step-module
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
/*  Copyright 2026 Webhead LLC (email: info at webheadcoder.com)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( function_exists( 'cf7msm_fs' ) ) {
    cf7msm_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'cf7msm_fs' ) ) {
        // Create a helper function for easy SDK access.
        function cf7msm_fs() {
            global $cf7msm_fs;
            if ( !isset( $cf7msm_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_1614_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_1614_MULTISITE', true );
                }
                // Include Freemius SDK via Composer when available.
                if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
                    require_once __DIR__ . '/vendor/autoload.php';
                } elseif ( file_exists( __DIR__ . '/freemius/start.php' ) ) {
                    // Legacy path for non-Composer builds.
                    require_once __DIR__ . '/freemius/start.php';
                }
                $cf7msm_fs = fs_dynamic_init( array(
                    'id'               => '1614',
                    'slug'             => 'contact-form-7-multi-step-module',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_b445061ad8b540f6a89c2c4f4df19',
                    'is_premium'       => false,
                    'premium_suffix'   => '(PRO)',
                    'has_addons'       => false,
                    'has_paid_plans'   => true,
                    'is_org_compliant' => true,
                    'menu'             => array(
                        'first-path' => 'plugins.php',
                        'support'    => false,
                    ),
                    'is_live'          => true,
                ) );
            }
            return $cf7msm_fs;
        }

        // Init Freemius.
        cf7msm_fs();
        // Signal that SDK was initiated.
        do_action( 'cf7msm_fs_loaded' );
        define( 'CF7MSM_VERSION', '4.7' );
        define( 'CF7MSM_PLUGIN', __FILE__ );
        define( 'CF7MSM_FREE_TEXT_PREFIX_RADIO', '_wpcf7_free_text_' );
        define( 'CF7MSM_FREE_TEXT_PREFIX_CHECKBOX', '_wpcf7_free_text_' );
        define( 'CF7MSM_MIN_CF7_VERSION', '5.2' );
        define( 'CF7MSM_LEARN_MORE_URL', 'https://webheadcoder.com/contact-form-7-multi-step-forms/#pro' );
        define( 'CF7MSM_COOKIE_SIZE_THRESHOLD', 3684 );
        //4093 * 90%
        /**
         * Change update message
         */
        function cf7msm_fs_custom_connect_message_on_update(
            $message,
            $user_first_name,
            $plugin_title,
            $user_login,
            $site_link,
            $freemius_link
        ) {
            $limited_time = '';
            /* translators: %1$s: plugin name; %2$s: Freemius link. */
            return cf7msm_kses( sprintf( __( 'Please help improve the %1$s plugin!  I have chosen to use %2$s to get an idea of how users use my plugin.<br><br>  If you opt-in, the administrator email and some data about your usage of %1$s will be sent to %2$s. If you skip this, that\'s okay! The plugin will still work just fine.', 'contact-form-7-multi-step-module' ), '<strong>' . $plugin_title . '</strong>', $freemius_link ) ) . $limited_time;
        }

        cf7msm_fs()->add_filter(
            'connect_message_on_update',
            'cf7msm_fs_custom_connect_message_on_update',
            10,
            6
        );
        /**
         * Send upgrade links off-site while Freemius is in activation mode.
         *
         * Freemius only registers the in-dashboard pricing page once the user has opted in
         * or skipped.  Before that, get_upgrade_url() still returns a link to that page, and
         * WordPress rejects it with "Sorry, you are not allowed to access this page."  Point
         * those links at the public pricing page instead until the opt-in has been resolved.
         *
         * @param string|null $url Pricing page URL, or null when Freemius is asking whether
         *                         the pricing menu item should link somewhere custom.
         * @return string|null
         */
        function cf7msm_fs_pricing_url(  $url  ) {
            return ( cf7msm_fs()->is_activation_mode() ? CF7MSM_LEARN_MORE_URL : $url );
        }

        cf7msm_fs()->add_filter( 'pricing_url', 'cf7msm_fs_pricing_url' );
        /**
         * Add account link if paying.
         */
        function cf7msm_plugin_action_links(  $links  ) {
            if ( !is_array( $links ) ) {
                $links = array();
            }
            if ( cf7msm_fs()->is_not_paying() ) {
                $links[] = '<a href="' . esc_url( CF7MSM_LEARN_MORE_URL ) . '" target="_blank">' . esc_html__( 'Learn about PRO', 'contact-form-7-multi-step-module' ) . '</a>';
            }
            return $links;
        }

        add_filter( "plugin_action_links_" . plugin_basename( CF7MSM_PLUGIN ), 'cf7msm_plugin_action_links' );
        /**
         * Run on activation
         */
        function cf7msm_activation() {
            $stats = get_option( '_cf7msm_stats', array() );
            $install_date = ( !empty( $stats['install_date'] ) ? $stats['install_date'] : 0 );
            if ( empty( $install_date ) ) {
                $stats['install_date'] = time();
                update_option( '_cf7msm_stats', $stats );
            }
            update_option( '_cf7msm_version', CF7MSM_VERSION );
        }

        register_activation_hook( CF7MSM_PLUGIN, 'cf7msm_activation' );
        /**
         * Check if everything is up to date.
         */
        function cf7msm_plugin_check() {
            $version = get_option( '_cf7msm_version', '' );
            if ( $version !== CF7MSM_VERSION ) {
                cf7msm_activation();
            }
        }

        add_action( 'plugins_loaded', 'cf7msm_plugin_check' );
        /**
         * Run on deactivation
         */
        function cf7msm_deactivation() {
            delete_option( '_cf7msm_stats' );
            delete_option( '_cf7msm_version' );
        }

        register_deactivation_hook( CF7MSM_PLUGIN, 'cf7msm_deactivation' );
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'cf7msm.php';
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'cf7msm-admin.php';
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'form-tags/common.php';
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'form-tags/module-multistep.php';
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'form-tags/module-session.php';
        require_once plugin_dir_path( CF7MSM_PLUGIN ) . 'form-tags/module-back.php';
    }
}