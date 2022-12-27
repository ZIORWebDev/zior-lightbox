<?php
/**
 * Class for registering a new settings page under Settings.
 */
class ZIOR_Lightbox_Options_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_init', [ $this, 'registerSettingsGroups' ] );
		add_action( 'admin_init', [ $this, 'registerFields'] );
	}

	public function registerSettingsGroups() {
		add_settings_section(
			'zior_lightbox_settings',
			'',
			'',
			'zior_lightbox_settings',
			''
		);
	}

	/**
	 * Register fields
	 */
	public function registerFields() {
		add_settings_field( 'zior_lightbox_settings', __( 'Lightbox Settings', 'zior-lightbox' ),
				[ $this, 'render_lightbox_settings'], 'zior_lightbox_settings', 'zior_lightbox_settings' );
		
		register_setting( 'zior_lightbox_settings', 'zrl_disable_on_href', [ 'type' => 'boolean', 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean' ] );
		register_setting( 'zior_lightbox_settings', 'zrl_allowed_classes', [ 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'zior_lightbox_settings', 'zrl_allowed_parent_classes', [ 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'zior_lightbox_settings', 'zrl_disabled_classes', [ 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'zior_lightbox_settings', 'zrl_disabled_parent_classes', [ 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
	}

	/**
	 * Registers a new settings page under Settings.
	 */
	public function admin_menu() {
		add_options_page(
			__( 'ZIOR Lightbox', 'zior-lightbox' ),
			__( 'ZIOR Lightbox', 'zior-lightbox' ),
			'manage_options',
			'zior_lightbox_settings',
			[
				$this,
				'settings_page',
			]
		);
	}
	
	/**
	 * Render lightbox setting fields
	 */
	public function render_lightbox_settings() {
		$zrl_disable_on_href = get_option( 'zrl_disable_on_href', true );
		$zrl_allowed_classes = get_option( 'zrl_allowed_classes', '' );
		$zrl_allowed_parent_classes = get_option( 'zrl_allowed_parent_classes', '' );
		$zrl_disabled_classes = get_option( 'zrl_disabled_classes', '' );
		$zrl_disabled_parent_classes = get_option( 'zrl_disabled_parent_classes', '' );
		?>
		<fieldset>
			<label for="zrl_disable_on_href">
				<input type="checkbox" id="zrl_disable_on_href" name="zrl_disable_on_href" value="1" <?php
					checked( '1', $zrl_disable_on_href ); ?> />
				<?php echo esc_html__('Disable Lightbox on images with links', 'zior-lightbox'); ?>
			</label>
			<p class="description"><?php
				echo esc_html__('Disable lightbox if the image is wrapped with link.', 'zior-lightbox');
				?></p>
			<br/>
			<label for="zrl_allowed_classes"><?php echo esc_html__( 'Allow lightbox on the following class', 'zior-lightbox'); ?></label><br/>
			<textarea name="zrl_allowed_classes" row="5"><?php echo esc_textarea( $zrl_allowed_classes ); ?></textarea>
			<p class="description"><?php
				echo esc_html__('Allow lightbox on the specified classes only. Enter class separated by comma (,).', 'zior-lightbox');
				?></p>
			<br/>
			<label for="zrl_allowed_parent_classes"><?php echo esc_html__( 'Allow lightbox on the following parent class', 'zior-lightbox'); ?></label><br/>
			<textarea name="zrl_allowed_parent_classes" row="10"><?php echo esc_textarea( $zrl_allowed_parent_classes ); ?></textarea>
			<p class="description"><?php
				echo esc_html__('Allow lightbox on the specified parent classes only. Enter class separated by comma (,).', 'zior-lightbox');
				?></p>
			<br/>
			<label for="zrl_disabled_classes"><?php echo esc_html__( 'Disable lightbox on the following class', 'zior-lightbox'); ?></label><br/>
			<textarea name="zrl_disabled_classes" row="5"><?php echo esc_textarea( $zrl_disabled_classes ); ?></textarea>
			<p class="description"><?php
				echo esc_html__( 'Disabled lightbox on the specified classes. Enter class separated by comma (,).', 'zior-lightbox' );
				?></p>
			<br/>
			<label for="zrl_disabled_parent_classes"><?php echo esc_html__( 'Disable lightbox on the following parent class', 'zior-lightbox'); ?></label><br/>
			<textarea name="zrl_disabled_parent_classes" row="5"><?php echo esc_textarea( $zrl_disabled_parent_classes ); ?></textarea>
			<p class="description"><?php
				echo esc_html__('Disable lightbox on the specific parent class. Enter class separated by comma (,).', 'zior-lightbox');
				?></p>
			<br/>
		</fieldset>
		<?php
	}

	/**
	 * Settings page display callback.
	 */
	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<input type="hidden" name="action" name="update_zior_lightbox_settings" />
				<?php settings_fields( 'zior_lightbox_settings' ); ?>
				<?php do_settings_sections( 'zior_lightbox_settings' ); ?>
				<?php submit_button( esc_html__('Save Changes', 'zior-lightbox') ); ?>
			</form>
		</div>
	<?php
	}
}

new ZIOR_Lightbox_Options_Page;