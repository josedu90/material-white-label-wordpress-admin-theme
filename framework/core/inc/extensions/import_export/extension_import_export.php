<?php

    /**
     * Reduk Framework is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 2 of the License, or
     * any later version.
     * Reduk Framework is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     * GNU General Public License for more details.
     * You should have received a copy of the GNU General Public License
     * along with Reduk Framework. If not, see <http://www.gnu.org/licenses/>.
     *
     * @package     RedukFramework
     * @author      Dovy Paukstys (dovy)
     * @version     4.0.0
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

// Don't duplicate me!
    if ( ! class_exists( 'RedukFramework_extension_import_export' ) ) {


        /**
         * Main RedukFramework import_export extension class
         *
         * @since       3.1.6
         */
        class RedukFramework_extension_import_export {

            // Protected vars
            protected $parent;
            public $extension_url;
            public $extension_dir;
            public static $theInstance;
            public static $version = "4.0";
            public $is_field = false;

            /**
             * Class Constructor. Defines the args for the extions class
             *
             * @since       1.0.0
             * @access      public
             *
             * @param       array $sections   Panel sections.
             * @param       array $args       Class constructor arguments.
             * @param       array $extra_tabs Extra panel tabs.
             *
             * @return      void
             */
            public function __construct( $parent ) {

                $this->parent = $parent;
                if ( empty( $this->extension_dir ) ) {
                    //$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                }
                $this->field_name = 'import_export';

                self::$theInstance = $this;

                add_action( "wp_ajax_reduk_link_options-" . $this->parent->args['opt_name'], array(
                    $this,
                    "link_options"
                ) );
                add_action( "wp_ajax_nopriv_reduk_link_options-" . $this->parent->args['opt_name'], array(
                    $this,
                    "link_options"
                ) );

                add_action( "wp_ajax_reduk_download_options-" . $this->parent->args['opt_name'], array(
                    $this,
                    "download_options"
                ) );
                add_action( "wp_ajax_nopriv_reduk_download_options-" . $this->parent->args['opt_name'], array(
                    $this,
                    "download_options"
                ) );

                do_action( "reduk/options/{$this->parent->args['opt_name']}/import", array( $this, 'remove_cookie' ) );

                $this->is_field = Reduk_Helpers::isFieldInUse( $parent, 'import_export' );

                if ( ! $this->is_field && $this->parent->args['show_import_export'] ) {
                    $this->add_section();
                }

                add_filter( 'reduk/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array(
                    &$this,
                    'overload_field_path'
                ) ); // Adds the local field

                add_filter( 'upload_mimes', array(
                    $this,
                    'custom_upload_mimes'
                ) );

            }

            /**
             * Adds the appropriate mime types to WordPress
             *
             * @param array $existing_mimes
             *
             * @return array
             */
            function custom_upload_mimes( $existing_mimes = array() ) {
                $existing_mimes['reduk'] = 'application/reduk';

                return $existing_mimes;
            }

            public function add_section() {
                $this->parent->sections[] = array(
                    'id'         => 'import/export',
                    'title'      => __( 'Import / Export', 'mtrl_framework' ),
                    'heading'    => '',
                    'icon'       => 'el el-refresh',
                    'customizer' => false,
                    'fields'     => array(
                        array(
                            'id'         => 'reduk_import_export',
                            'type'       => 'import_export',
                            //'class'      => 'reduk-field-init reduk_remove_th',
                            //'title'      => '',
                            'full_width' => true,
                        )
                    ),
                );
            }

            function link_options() {
                if ( ! isset( $_GET['secret'] ) || $_GET['secret'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . $this->parent->args['opt_name'] ) ) {
                    wp_die( 'Invalid Secret for options use' );
                    exit;
                }

                $var                 = $this->parent->options;
                $var['reduk-backup'] = '1';
                if ( isset( $var['REDUK_imported'] ) ) {
                    unset( $var['REDUK_imported'] );
                }

                echo json_encode( $var );

                die();
            }

            public function download_options() {
                if ( ! isset( $_GET['secret'] ) || $_GET['secret'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . $this->parent->args['opt_name'] ) ) {
                    wp_die( 'Invalid Secret for options use' );
                    exit;
                }

                $this->parent->get_options();
                $backup_options                 = $this->parent->options;
                $backup_options['reduk-backup'] = '1';
                if ( isset( $backup_options['REDUK_imported'] ) ) {
                    unset( $backup_options['REDUK_imported'] );
                }

                // No need to escape this, as it's been properly escaped previously and through json_encode
                $content = json_encode( $backup_options );

                if ( isset( $_GET['action'] ) && $_GET['action'] == 'reduk_download_options-' . $this->parent->args['opt_name'] ) {
                    header( 'Content-Description: File Transfer' );
                    header( 'Content-type: application/txt' );
                    header( 'Content-Disposition: attachment; filename="reduk_options_' . $this->parent->args['opt_name'] . '_backup_' . date( 'd-m-Y' ) . '.json"' );
                    header( 'Content-Transfer-Encoding: binary' );
                    header( 'Expires: 0' );
                    header( 'Cache-Control: must-revalidate' );
                    header( 'Pragma: public' );

                    echo $content;
                    exit;
                } else {
                    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
                    header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
                    header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
                    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
                    header( 'Cache-Control: post-check=0, pre-check=0', false );
                    header( 'Pragma: no-cache' );

                    // Can't include the type. Thanks old Firefox and IE. BAH.
                    //header("Content-type: application/json");
                    echo $content;
                    exit;
                }
            }

            // Forces the use of the embeded field path vs what the core typically would use
            public function overload_field_path( $field ) {
                return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
            }

            public function remove_cookie() {
                // Remove the import/export tab cookie.
                if ( $_COOKIE['reduk_current_tab'] == 'import_export_default' ) {
                    setcookie( 'reduk_current_tab', '', 1, '/' );
                    $_COOKIE['reduk_current_tab'] = 1;
                }
            }

        }
    }
