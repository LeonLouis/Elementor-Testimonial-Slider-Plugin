<?php
class CBL_Elementor_Testimonial_Slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'cbl_elementor_testimonial_slider';
	}

	public function get_title() {
		return esc_html__( 'CBL Testimonial Slider', 'cbl-ets' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'slider' ];
	}

  public function get_style_depends() {
		return [ 'cbl-ets-styles', 'cbl-ets-slick' ];
	}

  public function get_script_depends() {
		return [ 'cbl-ets-js', 'cbl-ets-slick-js' ];
	}

	protected function register_controls() {

		// Content Tab Start

    $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'cbl-ets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_name', [
        'label' => esc_html__( 'Name', 'cbl-ets' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__( 'List Name' , 'cbl-ets' ),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'list_content', [
        'label' => esc_html__( 'Content', 'cbl-ets' ),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => esc_html__( 'List Content' , 'cbl-ets' ),
      ]
    );

    $repeater->add_control(
      'list_image', [
        'label' => esc_html__( 'Image', 'cbl-ets' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => __( 'Repeater List', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_name' => esc_html__( 'John Doe', 'cbl-ets' ),
						'list_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh viverra non semper suscipit posuere a pede.', 'cbl-ets' ),
					],
				],
				'title_field' => '{{{ list_name }}}',
      ]
    );

		$this->end_controls_section();

		// Content Tab End


		// Style Tab Start

    $this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'cbl-ets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ets-title',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'cbl-ets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ets-content',
			]
		);

		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
    
		if ( $settings['list'] ) {
			echo '<div class="cbl-ets-wrapper">';
			foreach (  $settings['list'] as $item ) {
				echo '<div class="ets-item ets-' . esc_attr( $item['_id'] ) . '">';
        echo '<img class="ets-img" alt="' . $item['list_name'] . '" title="' . $item['list_name'] . '" src="' . $item['list_image']['url'] . '" />';
        echo '<p class="ets-content">' . $item['list_content'] . '</p>';
        echo '<p class="ets-title">- ' . $item['list_name'] . '</p>';
				echo '</div>';
			}
			echo '</div>';
		}
	}

	protected function content_template() {
		?>
		<# if ( settings.list.length ) { #>
			<div class="cbl-ets-wrapper">
			<# _.each( settings.list, function( item ) { #>
        <div class="ets-item ets-{{ item._id }}">
          <img class="ets-content" alt="{{ item.list_name }}" title="{{ item.list_name }}" src="{{ item.list_image['url'] }}" />
          <p class="ets-content">{{{ item.list_content }}}</p>
          <p class="ets-title">- {{{ item.list_name }}}</p>
				</div>
			<# }); #>
      </div>
		<# } #>
		<?php
	}
}