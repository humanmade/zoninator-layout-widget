<?php

class Zoninator_Layout {

	public static function get_layouts() {
		$dirs = [
			get_stylesheet_directory(),
			get_template_directory(),
		];
		$path = '/widgets/zoninator-layout-*.php';
		$files = [];
		foreach ( $dirs as $dir ) {
			foreach ( glob( $dir . $path ) as $file ) {
				$f = str_replace( 'zoninator-layout-', '', basename( $file, '.php' ) );
				$name = str_replace( array( '-', '_' ), ' ', $f );
				$name = ucwords( $name );
				$files[ $f ] = $name;
			}
		}
		// sort( $files, SORT_NATURAL );
		return $files;
	}

}
