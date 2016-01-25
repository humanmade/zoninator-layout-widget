<?php

class Z_Archive_Layout_Widget extends Extended_Widget {

	/**
	 * Stores the index of the current post in the loop.
	 *
	 * @var integer
	 */
	protected $post_counter = 0;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( false, __( 'Archive Layout', 'zoninator-layout-widget' ) );
		add_action( 'the_post', [ $this, 'action_the_post' ], 10, 2 );
	}

	/**
	 * Increments the post counter when each post in the loop is iterated upon.
	 *
	 * @param  WP_Post  $post  The current post object.
	 * @param  WP_Query $query The current query object.
	 */
	public function action_the_post( WP_Post $post, WP_Query $query ) {
		$this->post_counter++;
	}

	/**
	 * Return the template slug for this widget.
	 *
	 * @return string The slug name for the generic template.
	 */
	protected function get_template_slug() {
		return 'zoninator-layout';
	}

	/**
	 * Return the template name for this widget.
	 *
	 * @return string The name of the specialised template. Empty string when not used.
	 */
	public function get_template_name() {
		if ( isset( $this->instance['layout_id'] ) ) {
			return $this->instance['layout_id'];
		}
		return '';
	}

	/**
	 * Return the variables for use in this widget's template output.
	 *
	 * @return array Associative array of template variables.
	 */
	public function get_vars() {
		global $wp_query;

		$layouts   = Zoninator_Layout::get_layouts();
		$layout_id = isset( $this->instance['layout_id'] ) ? $this->instance['layout_id'] : '';

		// For each successive widget, the `$posts` array is the current loop's posts minus the posts
		// that have already been displayed.
		$posts = array_slice( $wp_query->posts, $this->post_counter );

		if ( empty( $posts ) ) {
			return [];
		}

		return [
			'posts'     => $posts,
			'layout_id' => $layout_id,
		];
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance['layout_id'] = sanitize_text_field( $new_instance['layout_id'] );
		return $new_instance;
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$layouts   = Zoninator_Layout::get_layouts();
		$layout_id = isset( $instance['layout_id'] ) ? $instance['layout_id'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout_id' ) ); ?>"><?php esc_html_e( 'Layout:', 'zoninator-layout-widget' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout_id' ) ); ?>">
				<option value="0">
					<?php esc_html_e( '-- Select a layout --', 'zoninator-layout-widget' ); ?>
				</option>

				<?php foreach ( $layouts as $layout => $name ) : ?>
					<option value="<?php echo esc_attr( $layout ); ?>" <?php selected( $layout_id, $layout ); ?>>
						<?php echo esc_html( $name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

	<?php
	}

}
