<?php

class Z_Zoninator_Layout_Widget extends Extended_Widget {

	public function __construct() {
		parent::__construct( false, __( 'Zone Layout', 'zoninator-layout-widget' ) );	
	}

	public function get_template_name() {
		if ( isset( $this->instance['layout_id'] ) ) {
			return $this->instance['layout_id'];
		}
		return '';
	}

	public function get_vars() {

		$layouts   = Zoninator_Layout::get_layouts();
		$zone_id   = isset( $this->instance['zone_id'] ) ? absint( $this->instance['zone_id'] ) : 0;
		$layout_id = isset( $this->instance['layout_id'] ) ? $this->instance['layout_id'] : '';

		if ( ! $zone_id ) {
			return [];
		}
		
		$zone = z_get_zone( $zone_id );
		if ( ! $zone ) {
			return [];
		}
		
		$posts = z_get_posts_in_zone( $zone_id );
		if ( empty( $posts ) ) {
			return [];
		}

		return [
			'posts' => $posts,
			'zone'  => $zone,
		];
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance = array_merge( [
			'zone_id' => 0,
		], $new_instance );
		$new_instance['zone_id'] = absint( $new_instance['zone_id'] );
		$new_instance['layout_id'] = sanitize_text_field( $new_instance['layout_id'] );
		return $new_instance;
	}

	public function form( $instance ) {
		$zones = z_get_zones();
		if ( empty( $zones ) ) {
			esc_html_e( 'You need to create at least one zone before you use this widget.', 'zoninator-layout-widget' );
			return;
		}
		$layouts   = Zoninator_Layout::get_layouts();
		$zone_id   = isset( $instance['zone_id'] ) ? absint( $instance['zone_id'] ) : 0;
		$layout_id = isset( $instance['layout_id'] ) ? $instance['layout_id'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'zone_id' ) ); ?>"><?php esc_html_e( 'Zone:', 'zoninator-layout-widget' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'zone_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'zone_id' ) ); ?>">
				<option value="">
					<?php esc_html_e( '-- Select a zone --', 'zoninator-layout-widget' ); ?>
				</option>

				<?php foreach ( $zones as $zone ) : ?>
					<option value="<?php echo absint( $zone->term_id ); ?>" <?php selected( $zone_id, $zone->term_id ); ?>>
						<?php echo esc_html( $zone->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

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
