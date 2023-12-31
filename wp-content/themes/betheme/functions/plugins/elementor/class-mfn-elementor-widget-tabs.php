<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Mfn_WPML_Elementor_Widget_Tabs extends WPML_Elementor_Module_With_Items  {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'title', 'content' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'title':
					return esc_html__( 'Tab title', 'sitepress' );
				case 'content':
					return esc_html__( 'Tab content', 'sitepress' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'title':
					return 'LINE';
				case 'content':
					return 'VISUAL';
				default:
					return '';
			}
		}

	}
}

class Mfn_Elementor_Widget_Tabs extends \Elementor\Widget_Base {

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {

		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );

		parent::__construct( $data, $args );
	}

	/**
	 * WPML compatibility
	 */

	public function wpml_widgets_to_translate_filter( $widgets ) {

	  $widgets[ $this->get_name() ] = [
			'conditions' => [
				'widgetType' => $this->get_name(),
			],
			'fields' => [
				[
					'field' => 'title',
					'type' => $this->get_title() .'<br />'. __( 'Title', 'mfn-opts' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'Mfn_WPML_Elementor_Widget_Tabs',
	  ];

	  return $widgets;
	}

  /**
	 * Get script dependences
	 */

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'mfn-tabs', get_theme_file_uri( '/functions/plugins/elementor/assets/widget-tabs-preview.js' ), [ 'elementor-frontend' ], MFN_THEME_VERSION, true );
			return [ 'mfn-tabs' ];
		}

		return [];
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'mfn_tabs';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return __( 'Be • Tabs', 'mfn-opts' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'far fa-folder';
	}

	/**
	 * Get widget categories
	 */

	public function get_categories() {
		return [ 'mfn_builder' ];
	}

	/**
	 * Register widget controls
	 */

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is the heading', 'mfn-opts' ),
			]
		);

    $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Tab title', 'mfn-opts' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => __( 'Content', 'mfn-opts' ),
        'description' => __('<b>JavaScript</b> content like Google Maps and some plugins shortcodes do <b>not work</b> in tabs', 'mfn-opts'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Tab content', 'mfn-opts' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Tab #1', 'mfn-opts' ),
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					],
					[
						'title' => __( 'Tab #2', 'mfn-opts' ),
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_section',
			[
				'label' => __( 'Advances', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label' => __( 'Style', 'mfn-opts' ),
        'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
          'horizontal' => __('Horizontal', 'mfn-opts'),
          'centered' => __('Horizontal (centered tab)', 'mfn-opts'),
          'vertical' => __('Vertical', 'mfn-opts'),
				),
				'default' => 'horizontal',
			]
		);

    $this->add_control(
      'padding',
      [
        'label' => __( 'Content padding', 'mfn-opts' ),
        'type' => \Elementor\Controls_Manager::TEXT,
      ]
    );

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

		echo sc_tabs( $settings );

	}

}
