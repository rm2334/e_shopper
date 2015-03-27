<?php
    /**
     * ReduxFramework Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_config' ) ) {

        class Redux_Framework_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'e_shopper' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'e_shopper' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */

                // Array of social options
                $social_options = array(
                    'Twitter'       => 'Twitter',
                    'Facebook'      => 'Facebook',
                    'Google Plus'   => 'Google Plus',
                    'Pinterest'     => 'Pinterest',
                    'RSS'           => 'RSS',
                );

                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'e_shopper' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'e_shopper' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'e_shopper' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'e_shopper' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'e_shopper' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'e_shopper' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'e_shopper' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'e_shopper' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                // Define Logo & Favicon Path
                define('THEMELOGO', get_template_directory_uri().'/images/home/logo.png');
                define('THEMEFAVICON', get_template_directory_uri().'/favicon.png');

                // ACTUAL DECLARATION OF SECTIONS
                //General Settings
                $this->sections[] = array(
                    'title'         => __('General Settings', 'e_shopper'),
                    'heading'       => __('General Settings', 'e_shopper'),
                    'desc'          => __('Here you can uploading site logo and favicon, enable/disable header modules.', 'e_shopper'),
                    'icon'          => 'el el-wrench',
                    'submenu'       => true,
                    'fields'        => array(
                        array(
                            'title'     => __('Logo', 'e_shopper'),
                            'subtitle'  => __('Use this field to upload your custom logo for use in the theme header. Max width: 242px', 'e_shopper'),
                            'id'        => 'custom_logo',
                            'default'  => array(
                                            'url'=> THEMELOGO
                                        ),
                            'type'      => 'media',
                            'url'       => true,
                       ),

                       array( 
                            'title'     => __( 'Favicon', 'e_shopper' ),
                            'subtitle'  => __( 'Use this field to upload your custom favicon.', 'e_shopper' ),
                            'id'        => 'custom_favicon',
                            'default'  => array(
                                            'url'=> THEMEFAVICON
                                        ),
                            'type'      => 'media',
                            'url'       => true,
                        ),

                        array(
                            'title'     => __('Top Mini Header Module', 'e_shopper'),
                            'subtitle'  => __('Select to enable/disable display Top Mini Header Module.', 'e_shopper'),
                            'id'        => 'disable_header_mini',
                            'default'   => true,
                            'on'        => __('Enable', 'e_shopper'),
                            'off'       => __('Disable', 'e_shopper'),
                            'type'      => 'switch',
                       ),

                        array( 
                            'title'     => __('Contact Email', 'e_shopper'),
                            'subtitle'  => __('Set your email address. This is showing on Top Mini Header.', 'e_shopper' ),
                            'id'        => 'contact_email',
                            'default'   => 'yourname@yourdomain.com',
                            'validate'  => 'email',
                            'msg'       => 'Not a valid email address.',
                            'type'      => 'text',
                        ),

                        array(
                            'title'     => __('Contact Phone', 'e_shopper'),
                            'subtitle'  => __('Set your phone number. You can add multiple phone numbers.', 'e_shopper'),
                            'id'        => 'contact_phone',
                            'type'      => 'multi_text',
                            'default'   => array ('+2 95 01 88 821'),
                            ),
                   ),
               );

                //Homepage Settings
                $this->sections[] = array(
                    'title'         => __('Homepage Settings', 'e_shopper'),
                    'heading'       => __('Homepage Settings', 'e_shopper'),
                    'desc'          => __('Here you can set homepage modules.', 'e_shopper'),
                    'icon'          => 'el-icon-home',
                    'fields'    => array(
                        array(
                            'title'       => __('Account Menu Page', 'e_shopper'),
                            'subtitle'    => __('Select page from list.', 'e_shopper'),
                            'desc'     => __( 'Select page for Account Menu. Leave it blank to disable', 'e_shopper' ),
                            'id'          => 'account_page',
                            'type'        => 'select',
                            'multi'       => false,
                            'data'        => 'page',
                            'placeholder' => __('Select page for Account Menu.', 'e_shopper'),
                       ),

                        array(
                            'title'       => __('Wishlist Menu Page', 'e_shopper'),
                            'subtitle'    => __('Select page from list.', 'e_shopper'),
                            'desc'     => __( 'Select page for Wishlist Menu. Leave it blank to disable', 'e_shopper' ),
                            'id'          => 'wishlist_page',
                            'type'        => 'select',
                            'multi'       => false,
                            'data'        => 'page',
                            'placeholder' => __('Select page for Wishlist Menu.', 'e_shopper'),
                       ),

                        array(
                            'title'       => __('Checkout Menu Page', 'e_shopper'),
                            'subtitle'    => __('Select page from list.', 'e_shopper'),
                            'desc'     => __( 'Select page for Checkout Menu. Leave it blank to disable', 'e_shopper' ),
                            'id'          => 'checkout_page',
                            'type'        => 'select',
                            'multi'       => false,
                            'data'        => 'page',
                            'placeholder' => __('Select page for Checkout Menu.', 'e_shopper'),
                       ),

                        array(
                            'title'       => __('Cart Menu Page', 'e_shopper'),
                            'subtitle'    => __('Select page from list.', 'e_shopper'),
                            'desc'     => __( 'Select page for Cart Menu. Leave it blank to disable', 'e_shopper' ),
                            'id'          => 'cart_page',
                            'type'        => 'select',
                            'multi'       => false,
                            'data'        => 'page',
                            'placeholder' => __('Select page for Cart Menu.', 'e_shopper'),
                       ),

                        array(
                            'title'       => __('Login Menu Page', 'e_shopper'),
                            'subtitle'    => __('Select page from list.', 'e_shopper'),
                            'desc'     => __( 'Select page for Login Menu. Leave it blank to disable', 'e_shopper' ),
                            'id'          => 'login_page',
                            'type'        => 'select',
                            'multi'       => false,
                            'data'        => 'page',
                            'placeholder' => __('Select page for Login Menu.', 'e_shopper'),
                       ),
                   )
               );

                //Blog Settings
                $this->sections[] = array(
                    'title'         => __('Blog Settings', 'e_shopper'),
                    'heading'       => __('Blog Settings', 'e_shopper'),
                    'desc'          => __('Here you can set blog listing style and customize post style.', 'e_shopper'),
                    'icon'          => 'el-icon-th-list',
                    'fields'    => array(
                         array(
                            'title'     => __('Blog Listing Style', 'e_shopper'),
                            'subtitle'  => __('Select blog listing style for archive pages.', 'e_shopper'),
                            'id'        => 'disable_listing_style',
                            'default'   => true,
                            'on'        => __('Modern Style', 'e_shopper'),
                            'off'       => __('Blog Style', 'e_shopper'),
                            'type'      => 'switch',
                       ),

                        array( 
                            'title'     => __('Read More Button Text', 'e_shopper'),
                            'subtitle'  => __('This is the text that will replace Load More.', 'e_shopper'),
                            'id'        => 'read_more_text',
                            'default'   => 'Read More',
                            'type'      => 'text',
                       ),

                        array( 
                            'title'     => __('Load More Button Text', 'e_shopper'),
                            'subtitle'  => __('This is the text for Jetpack\'s Infinite Scroll.', 'e_shopper'),
                            'id'        => 'load_more_text',
                            'default'   => '+ Load More',
                            'type'      => 'text',
                       ),

                       array( 
                            'title'     => __('Related Posts Module Title', 'e_shopper'),
                            'subtitle'  => __('This is the title for Related Posts Module.', 'e_shopper'),
                            'id'        => 'related_title',
                            'default'   => 'Related Posts',
                            'type'      => 'text',
                       ),

                        array(
                            'title'     => __('Post Featured Image', 'e_shopper'),
                            'subtitle'  => __('Select to enable/disable display Post Featured Image on header.', 'e_shopper'),
                            'id'        => 'disable_featured_img',
                            'default'   => true,
                            'on'        => __('Enable', 'e_shopper'),
                            'off'       => __('Disable', 'e_shopper'),
                            'type'      => 'switch',
                       ),

                        array(
                            'title'     => __('Post Navigation Module', 'e_shopper'),
                            'subtitle'  => __('Select to enable/disable display Post Navigation Module for next and previous posts.', 'e_shopper'),
                            'id'        => 'disable_post_nav',
                            'default'   => true,
                            'on'        => __('Enable', 'e_shopper'),
                            'off'       => __('Disable', 'e_shopper'),
                            'type'      => 'switch',
                       ),
                   )
               );

                //Social Settings
                $this->sections[] = array(
                    'title'         => __('Social Settings', 'e_shopper'),
                    'heading'       => __('Social Settings', 'e_shopper'),
                    'desc'          => __('Here you can set your social profiles.', 'e_shopper'),
                    'icon'          => 'el-icon-group',
                    'fields'        => array(
                         array(
                            'id'       => 'social_facebook',
                            'type'     => 'text',
                            'title'    => __( 'Facebook Profile Link', 'e_shopper' ),
                            'subtitle' => __( 'This must be a URL.', 'e_shopper' ),
                            'desc'     => __( 'Here you put Facebook Profile Link. Leave it blank to disable', 'e_shopper' ),
                            'validate' => 'url',
                            'default'  => 'http://facebook.com/smtir',
                            'text_hint' => array(
                                                'title'     => '',
                                                'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            )
                        ),

                        array(
                            'id'       => 'social_twitter',
                            'type'     => 'text',
                            'title'    => __( 'Twitter Profile Link', 'e_shopper' ),
                            'subtitle' => __( 'This must be a URL.', 'e_shopper' ),
                            'desc'     => __( 'Here you put Twitter Profile Link. Leave it blank to disable', 'e_shopper' ),
                            'validate' => 'url',
                            'default'  => 'http://twitter.com/rm2334',
                            'text_hint' => array(
                                                'title'     => '',
                                                'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            )
                        ),
                        
                        array(
                            'id'       => 'social_linkedin',
                            'type'     => 'text',
                            'title'    => __( 'Linkedin Profile Link', 'e_shopper' ),
                            'subtitle' => __( 'This must be a URL.', 'e_shopper' ),
                            'desc'     => __( 'Here you put Linkedin Profile Link. Leave it blank to disable', 'e_shopper' ),
                            'validate' => 'url',
                            'default'  => '',
                            'text_hint' => array(
                                                'title'     => '',
                                                'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            )
                        ),

                        array(
                            'id'       => 'social_dribbble',
                            'type'     => 'text',
                            'title'    => __( 'Dribbble Profile Link', 'e_shopper' ),
                            'subtitle' => __( 'This must be a URL.', 'e_shopper' ),
                            'desc'     => __( 'Here you put Dribbble Profile Link. Leave it blank to disable', 'e_shopper' ),
                            'validate' => 'url',
                            'default'  => '',
                            'text_hint' => array(
                                                'title'     => '',
                                                'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            )
                        ),

                        array(
                            'id'       => 'social_gplus',
                            'type'     => 'text',
                            'title'    => __( 'Google Plus Profile Link', 'e_shopper' ),
                            'subtitle' => __( 'This must be a URL.', 'e_shopper' ),
                            'desc'     => __( 'Here you put Google Plus Profile Link. Leave it blank to disable', 'e_shopper' ),
                            'validate' => 'url',
                            'default'  => 'http://gplus.com',
                            'text_hint' => array(
                                                'title'     => '',
                                                'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            )
                        ), 
                   )
               );

                //Footer Settings
                $this->sections[] = array(
                    'title'     => __('Footer Settings', 'e_shopper'),
                    'heading'   => __('Footer Settings', 'e_shopper'),
                    'desc'      => __('Here you can set site copyright information.', 'e_shopper'),
                    'icon'      => 'el-icon-chevron-down',
                    'fields'    => array(
                        array(
                            'title'     => __('Custom Copyright', 'e_shopper'),
                            'subtitle'  => __('Add your own custom text/html for copyright region.', 'e_shopper'),
                            'id'        => 'custom_copyright',
                            'default'   => '',
                            'type'      => 'editor',
                       ),
                   )
               );

                //Footer Slide Settings
                $this->sections[] = array(
                    'title'     => __('Footer Slide Image', 'e_shopper'),
                    'heading'   => __('Footer Slide Section', 'e_shopper'),
                    'desc'      => __('Here you can set Footer Slide Image, Heading Text, Map.', 'e_shopper'),
                    'icon'      => 'el el-caret-right',
                    'fields' => array(
                        array(
                            'title'     => __('Footer Slide Heading Text', 'e_shopper'),
                            'subtitle'  => __('Add your own custom text/html for Footer Slide Heading Text.', 'e_shopper'),
                            'desc'      => __('Leave it blank to disable.', 'e_shopper'),
                            'id'        => 'footer_heading',
                            'default'   => '<h2><span>e</span>-shopper</h2> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>',
                            'type'      => 'editor',
                       ),

                        array(
                    'id'          => 'footer_slide',
                    'type'        => 'slides',
                    'title'       => __('Footer Slide Image', 'e_shopper'),
                    'subtitle'    => __('Here you can footer image slide.', 'e_shopper'),
                    'desc'      => __('Please dont add more than Four Slide', 'e_shopper')
                        ),

                        array(
                            'title'     => __('Footer Slide Map Text', 'e_shopper'),
                            'subtitle'  => __('Add your own Footer Slide Map Text.', 'e_shopper'),
                            'desc'      => __('Leave it blank to disable.', 'e_shopper'),
                            'id'        => 'footer_map',
                            'default'   => '',
                            'type'      => 'text',
                       ),
                    )
               );

               //Contact Page Settings
                $this->sections[] = array(
                    'title'     => __('Contact Page Settings', 'e_shopper'),
                    'heading'   => __('Contact Page Settings', 'e_shopper'),
                    'desc'      => __('Here you can set information for contact page.', 'e_shopper'),
                    'icon'      => 'el-icon-envelope',
                    'fields'    => array(
                        array(
                            'title'     => __('Google Map Module', 'e_shopper'),
                            'subtitle'  => __('Select to enable/disable display Google Map.', 'e_shopper'),
                            'id'        => 'disable_map',
                            'default'   => true,
                            'on'        => __('Enable', 'e_shopper'),
                            'off'       => __('Disable', 'e_shopper'),
                            'type'      => 'switch',
                       ),

                       array(
                            'title'     => __('Google Map Embed Code', 'e_shopper'),
                            'subtitle'  => __('Please refer to <a href="http://themeart.co/document/e_shopper-theme-documentation/#google-map-settings" target="_blank">theme documentation</a> for how to Embed a Google Map with iFrame.', 'e_shopper'),
                            'id'        => 'map_code',
                            'default'   => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1584.2679903399307!2d-122.09496935581758!3d37.42444119584552!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba1a7f2db7e7%3A0x59c3e570fe8e0c73!2sGoogle+West+Campus+6%2C+2350+Bayshore+Pkwy%2C+Mountain+View%2C+CA+94043%2C+USA!5e0!3m2!1sen!2s!4v1422891258666" width="600" height="450" frameborder="0" style="border:0"></iframe>',
                            'type'      => 'ace_editor',
                            'mode'      => 'html',
                            'theme'     => 'monokai',
                       ),

                       array( 
                            'title'     => __('Contact Email', 'e_shopper'),
                            'subtitle'  => __('Set your email address. This is where the contact form will send a message to.', 'e_shopper' ),
                            'id'        => 'contact_email_i',
                            'default'   => 'yourname@yourdomain.com',
                            'validate'  => 'email',
                            'msg'       => 'Not a valid email address.',
                            'type'      => 'text',
                        ),

                        array(
                            'title'     => __('Contact Mail Subject', 'e_shopper'),
                            'subtitle'  => __('Add some topics for your mail subject.', 'e_shopper'),
                            'id'        => 'contact_subject',
                            'type'      => 'multi_text',
                            'default'   => array ('Aloha'),
                            ),
                   )
               );

                //404 Page Settings
                $this->sections[] = array(
                    'title'     => __('404 Page Settings', 'e_shopper'),
                    'heading'   => __('404 Page Settings', 'e_shopper'),
                    'desc'      => __('Here you can set information for 404 page.', 'e_shopper'),
                    'icon'      => 'el-icon-error',
                    'fields'    => array(
                        array(
                            'title'     => __('404 Image', 'e_shopper'),
                            'subtitle'  => __('Use this field to upload your custom 404 image.', 'e_shopper'),
                            'id'        => '404_image',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                       ),

                        array(
                            'title'     => __('Notice Information', 'e_shopper'),
                            'subtitle'  => __('Add notice information for 404 page.', 'e_shopper'),
                            'id'        => '404_info',
                            'default'   => "We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try one of these options:",
                            'type'      => 'editor',
                       ),
                   )
               );

               //Custom CSS
                $this->sections[] = array(
                    'icon'      => 'el-icon-css',
                    'title'     => __('Custom CSS', 'e_shopper'),
                    'fields'    => array(
                         array(
                            'title'     => __('Custom CSS', 'e_shopper'),
                            'subtitle'  => __('Insert any custom CSS.', 'e_shopper'),
                            'id'        => 'custom_css',
                            'type'      => 'ace_editor',
                            'mode'      => 'css',
                            'theme'     => 'monokai',
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __('Import / Export', 'e_shopper'),
                    'desc'   => __('Import and Export your theme settings from file, text or URL.', 'e_shopper'),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your theme options',
                            'full_width' => false,
                       ),
                   ),
               );

                $this->sections[] = array(
                    'type' => 'divide',
               );


            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'e_shopper' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'e_shopper' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'e_shopper' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'e_shopper' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'e_shopper' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'themes_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Themes Options', 'e_shopper' ),
                    'page_title'           => __( 'Theme Options', 'e_shopper' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-wordpress-alt',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'http://github.com/rm2334',
                    'title' => __( 'Support', 'e_shopper' ),
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>You can start customizing your theme with the powerful option panel.</p>', 'e_shopper' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'e_shopper' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>Thnaks For Using E-shopper Themes Options </p>', 'e_shopper' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_config();
    } else {
        echo "The class named Redux_Framework_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
