<?php
/**
 * Welcome Screen Class
 * Sets up the welcome screen page, hides the menu item
 * and contains the screen content.
 */
class E_shopper_Welcome {

	/**
	 * Constructor
	 * Sets up the welcome screen
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'e_shopper_welcome_register_menu' ) );
		add_action( 'load-themes.php', array( $this, 'e_shopper_activation_admin_notice' ) );

		add_action( 'e_shopper_welcome', array( $this, 'e_shopper_welcome_intro' ), 				10 );
		add_action( 'e_shopper_welcome', array( $this, 'e_shopper_welcome_getting_started' ), 	20 );

	} // end constructor

	/**
	 * Adds an admin notice upon successful activation.
	 * @since 1.0.3
	 */
	public function e_shopper_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) { // input var okay
			add_action( 'admin_notices', array( $this, 'e_shopper_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @since 1.0.3
	 */
	public function e_shopper_welcome_admin_notice() {
		?>
			<div class="updated fade">
				<p><?php echo sprintf( esc_html__( 'Thanks for choosing E-shopper! You can read hints and tips on how get the most out of your new theme on the %swelcome screen%s.', 'e_shopper' ), '<a href="' . esc_url( admin_url( 'themes.php?page=e_shopper_welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=e_shopper_welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with E-shopper', 'e_shopper' ); ?></a></p>
			</div>
		<?php
	}

	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.0.0
	 */
	public function e_shopper_welcome_register_menu() {
		add_theme_page( 'E-shopper', 'E-shopper', 'read', 'e_shopper_welcome', array( $this, 'e_shopper_welcome_screen' ) );
	}

	/**
	 * The welcome screen
	 * @since 1.0.0
	 */
	public function e_shopper_welcome_screen() {
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>
		<div class="wrap about-wrap">

			<?php
			/**
			 * @hooked e_shopper_welcome_intro - 10
			 * @hooked e_shopper_welcome_getting_started - 20
			 */
			do_action( 'e_shopper_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Welcome screen intro
	 * @since 1.0.0
	 */
	public function e_shopper_welcome_intro() {

		?>
		<div class="feature-section col two-col" style="margin-bottom: 1.618em; overflow: hidden;">
			<div class="col-1">
				<h1 style="margin-right: 0;"><?php echo '<strong>E-shopper</strong> <sup style="font-weight: bold; font-size: 50%; padding: 5px 10px; color: #666; background: #fff;">v1.0.1</sup>'; ?></h1>

				<p style="font-size: 1.2em;"><?php _e( 'Awesome! You\'ve decided to use E-shopper to enrich your WooCommerce store design.', 'e_shopper' ); ?></p>
				<p><?php _e( 'Whether you\'re a store owner, WordPress developer, or both - we hope you enjoy E-shopper\'s deep integration with WooCommerce core (including several popular WooCommerce extensions), plus the flexible design and extensible codebase that this theme provides.', 'e_shopper' ); ?>
			</div>

			<div class="col-2 last-feature">
				<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" class="image-50" width="440" />
			</div>
		</div>

		<hr />
		<?php
	}

	/**
	 * Welcome screen getting started section
	 * @since 1.0.0
	 */
	public function e_shopper_welcome_getting_started() {
		// get theme customizer url
		$url 	= admin_url() . 'customize.php?';
		$url 	.= 'url=' . urlencode( site_url() . '?storefront-customizer=true' );
		$url 	.= '&return=' . urlencode( admin_url() . 'themes.php?page=e_shopper_welcome' );
		$url 	.= '&storefront-customizer=true';
		?>
		<div class="feature-section col two-col" style="margin-bottom: 1.618em; padding-top: 1.618em; overflow: hidden;">

			<h2><?php _e( 'Using E-shopper', 'e_shopper' ); ?> <div class="dashicons dashicons-lightbulb"></div></h2>
			<p><?php _e( 'We\'ve purposely kept E-shopper lean & mean so configuration is a breeze. Here are some common theme-setup tasks:', 'e_shopper' ); ?></p>

			<div class="col-1">
				<?php if ( ! class_exists( 'WooCommerce' ) ) { ?>
					<h4><?php _e( 'Install WooCommerce' ,'e_shopper' ); ?></h4>
					<p><?php _e( 'Although E-shopper works fine as a standard WordPress theme, it really shines when used for an online store. Install WooCommerce and start selling now.', 'e_shopper' ); ?></p>

					<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' ) ); ?>" class="button"><?php _e( 'Install WooCommerce', 'e_shopper' ); ?></a></p>
				<?php } ?>

				<h4><?php _e( 'Configure menu locations' ,'e_shopper' ); ?></h4>
				<p><?php _e( 'E-shopper includes two menu locations for primary and secondary navigation. The primary navigation is perfect for your key pages like the shop and product categories. The secondary navigation is better suited to lower traffic pages such as terms and conditions.', 'e_shopper' ); ?></p>
				<p><a href="<?php echo esc_url( self_admin_url( 'nav-menus.php' ) ); ?>" class="button"><?php _e( 'Configure menus', 'e_shopper' ); ?></a></p>

				<h4><?php _e( 'Create a color scheme' ,'e_shopper' ); ?></h4>
				<p><?php _e( 'Using the WordPress Customizer you can tweak E-shopper\'s appearance to match your brand.', 'e_shopper' ); ?></p>
				<p><a href="<?php echo esc_url( $url ); ?>" class="button"><?php _e( 'Open the Customizer', 'e_shopper' ); ?></a></p>
			</div>

			<div class="col-2 last-feature">
				<h4><?php _e( 'Configure homepage template', 'e_shopper' ); ?></h4>
				<p><?php _e( 'E-shopper includes a homepage template that displays a selection of products from your store.', 'e_shopper' ); ?></p>
				<p><?php echo sprintf( esc_html__( 'To set this up you will need to create a new page and assign the "Homepage" template to it. You can then set that as a static homepage in the %sReading%s settings.', 'e_shopper' ), '<a href="' . esc_url( self_admin_url( 'options-reading.php' ) ) . '">', '</a>' ); ?></p>
				<p><?php echo sprintf( esc_html__( 'Once set up you can toggle and re-order the homepage components using the %sHomepage Control%s plugin.', 'e_shopper' ), '<a href="https://wordpress.org/plugins/homepage-control/">', '</a>' ); ?></p>

				<h4><?php _e( 'Add your logo', 'e_shopper' ); ?></h4>
				<p><?php echo sprintf( esc_html__( 'Activate %sJetpack%s to enable a custom logo option in the Customizer.', 'e_shopper' ), '<a href="https://wordpress.org/plugins/jetpack/">', '</a>' ); ?></p>
				
				<h4><?php _e( 'Themes Option', 'e_shopper' ); ?></h4>
				<p><?php echo sprintf( esc_html__( 'To Control E-shopper template browse', 'e_shopper' ) ); ?></p>
				<p><?php echo sprintf( esc_html__( '%sThemes Option%s.', 'e_shopper' ), '<a class="button" href="#">', '</a>' ); ?></p>
			</div>

		</div>

		<hr style="clear: both;">
		<?php
	}
}

$GLOBALS['E_shopper_Welcome'] = new E_shopper_Welcome();
