<?php // phpcs:ignore
/**
 * Fetching a backup zipstream of requested files from the plugin to the service.
 *
 * @package snapshot
 */

namespace WPMUDEV\Snapshot4\Task\Backup\Zipstream;

use WPMUDEV\Snapshot4\Task;
use WPMUDEV\Snapshot4\Helper\Fs;
use WPMUDEV\Snapshot4\Helper\Log;
use WPMUDEV\Snapshot4\Helper\Settings;

/**
 * Backup zipstream files task class
 */
class Files extends Task\Backup\Zipstream {

	const ERR_STRING_REQUEST_PARAMS = 'Request for files zipstream was not successful';

	/**
	 * Required request parameters, with their sanitization method
	 *
	 * @var array
	 */
	protected $required_params = array(
		'ex_rt' => 'intval',
		'files' => null,
	);

	/**
	 * Runs over the requested files and builds a zipstream out of them.
	 *
	 * @param array $args Info about the current file requesting, like what time it started, the files to be included, etc.
	 */
	public function apply( $args = array() ) {
		require dirname( SNAPSHOT_PLUGIN_FILE ) . '/vendor/autoload.php';

		// If we've any output, we need to discard them.
		if ( ob_get_level() > 0 ) {
			$content = ob_get_clean();
			unset( $content );
		}

		$model = $args['model'];

		// Enable output of HTTP headers.
		$zipstream_options = new \ZipStream\Option\Archive();
		$zipstream_options->setSendHttpHeaders( true );
		if ( Settings::get_zipstream_flush_buffer() ) {
			$zipstream_options->setFlushOutput( true );
		}

		$this->zipstream_files( $model, $zipstream_options );
	}

	/**
	 * Builds a zipstream out of requested files for as long as the timelimit allows it.
	 *
	 * @param object $model   WPMUDEV\Snapshot4\Model\Backup\Zipstream\Files instance.
	 * @param object $options \ZipStream\Option\Archive instance.
	 */
	public function zipstream_files( $model, $options ) {
		Settings::get_zipstream_log_verbose() && Log::info( __( 'The "Zipstream" task is started', 'snapshot' ) );
		include_once ABSPATH . 'wp-admin/includes/file.php';

		// Create a new zipstream object.
		$zip     = new \ZipStream\ZipStream( $model->name_zipstream(), $options );
		$files   = $model->get( 'requested_files' );
		$encoded = (bool) $model->get( 'is_encoded' );

		if ( $encoded ) {
			$decodable = $files[0] === base64_encode( base64_decode( $files[0] ) );
			$files = $decodable ? array_map( array( $this, 'url_safe_base64_decode' ), $files ) : $files;
		}

		/**
		 * Filters the requested files before the streaming of the zip file.
		 *
		 * @since 4.3.5
		 *
		 * @param array $files List of requested files to include in Zip.
		 */
		$requested_files = apply_filters( 'snapshot4_zipstream_requested_files', $files );

		foreach ( $requested_files as $file ) {
			$file_path = trailingslashit( Fs::get_root_path() ) . ltrim( $file, '/' );

			Settings::get_zipstream_log_verbose() &&
				/* translators: %s - current path in filelist task */
				Log::info( sprintf( __( 'The "Zipstream" task - current file: %s', 'snapshot' ), $file_path ) );

			if ( ! file_exists( $file_path ) ) {
				/* translators: %s - filename */
				Log::warning( sprintf( __( 'The requested %s file does not exist and is not included in the backup.', 'snapshot' ), $file ) );
				$model->add( 'files_skipped', $file );
				continue;
			}

			if ( ! apply_filters( 'wp_snapshot_writable_file_to_zipstream', is_readable( $file_path ), $file_path ) ) {
				/* translators: %s - filename */
				Log::warning( sprintf( __( 'The requested %s file is not readable and can not be included in the backup.', 'snapshot' ), $file ) );
				$model->add( 'files_skipped', $file );
				continue;
			}

			$zip->addFileFromPath( $file, $file_path );
			$model->add( 'files_added', $file );

			if ( $model->has_exceeded_timelimit() ) {
				if ( Settings::get_zipstream_log_verbose() ) {
					$time_diff_str = number_format( microtime( true ) - $model->get( 'start_time' ), 2, '.', '' );
					/* translators: %s - exceeded timelimit in filelist task */
					Log::info( sprintf( __( 'The "Zipstream" task - time limit exceeded: %s', 'snapshot' ), $time_diff_str ) );
				}
				break;
			}
		}

		if ( ! empty( $model->get( 'files_skipped', array() ) ) ) {
			$zip->addFile( 'manifest-skip.txt', '"' . implode( '","', $model->get( 'files_skipped', array() ) ) . '"' );
		}
		$zip->addFile( 'manifest.txt', '"' . implode( '","', $model->get( 'files_added', array() ) ) . '"' );
		// finish the zip stream.
		$zip->finish();
	}
}