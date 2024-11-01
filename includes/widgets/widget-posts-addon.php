<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class Elementor_WPHD_Posts_Addon_Widget extends \Elementor\Widget_Base
{
  public function get_custom_help_url()
  {
    return 'https://go.elementor.com/widget-name';
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_script('wphd_slick', plugins_url('../assets/js/slick.min.js', __FILE__), ['elementor-frontend'], '1.0.0', true);
    wp_register_script('wphd_script', plugins_url('../assets/js/main.js', __FILE__), ['elementor-frontend'], '1.0.0', true);

    wp_register_style('wphd_style', plugins_url('../assets/css/widget.css', __FILE__),);
    wp_register_style('wphd_style_slick', plugins_url('../assets/css/slick.css', __FILE__),);
  }


  public function get_script_depends()
  {
    return ['wphd_slick', 'wphd_script'];
  }
  public function get_style_depends()
  {
    return ['wphd_style', 'wphd_style_slick'];
  }


  public function get_name()
  {
    return 'wphd-posts-addon';
  }

  public function get_title()
  {
    return esc_html__('Posts Addon', 'wphd-posts-addon');
  }

  public function get_icon()
  {
    return 'eicon-gallery-grid';
  }


  protected function register_controls()
  {

    $this->start_controls_section(
      'content_posts_section',
      [
        'label' => esc_html__('Content', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'post_style',
      [
        'label' => esc_html__('Show post as ...', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'grid',
        'options' => [
          'grid'  => esc_html__('Grid', 'wphd-posts-addon'),
          'list' => esc_html__('List', 'wphd-posts-addon'),
          'carousel' => esc_html__('Carousel', 'wphd-posts-addon'),
        ],
      ]
    );
    $args = array(
      'public'   => true,
    );

    $this->add_control(
      'post_type',
      [
        'label' => esc_html__('Post Type', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post',
        'options' => get_post_types($args)
      ]
    );


    $this->add_control(
      'post_qty',
      [
        'label' => esc_html__('Posts per page', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => -1,
        'max' => 100,
        'step' => 1,
        'default' => 6,
      ]
    );

    $this->add_control(
      'order_by',
      [
        'label' => esc_html__('Order by', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'ID',
        'options' => [
          'title'  => esc_html__('Title', 'wphd-posts-addon'),
          'ID' => esc_html__('ID', 'wphd-posts-addon'),
          'author' => esc_html__('Author', 'wphd-posts-addon'),
          'date' => esc_html__('Date', 'wphd-posts-addon'),
        ],
      ]
    );

    $this->add_control(
      'sorted',
      [
        'label' => esc_html__('How to order', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'ASC',
        'options' => [
          'ASC'  => esc_html__('ASC', 'wphd-posts-addon'),
          'DESC' => esc_html__('DESC', 'wphd-posts-addon'),

        ],
      ]
    );

    $this->end_controls_section();

    ///////////////////////////////////////
    //////// Tab Styles ///////////////////
    //////////////////////////////////////

    ///////////////////////////////////////////
    ///////// Carousel Styles ////////////////
    /////////////////////////////////////////


    $this->start_controls_section(
      'carousel',
      [
        'label' => esc_html__('Carousel Options', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => ['post_style' => ['carousel']],
      ]
    );

    $this->add_control(
      'carousel-post-qty',
      [
        'label' => esc_html__('Posts to show', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '2',
        'options' => [
          '1' => esc_html__('1', 'wphd-posts-addon'),
          '2' => esc_html__('2', 'wphd-posts-addon'),
          '3'  => esc_html__('3', 'wphd-posts-addon'),
          '4' => esc_html__('4', 'wphd-posts-addon'),
        ],

      ]
    );

    $this->add_control(
      'dots',
      [
        'label' => esc_html__('Show Dots', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );

    $this->add_control(
      'arrows',
      [
        'label' => esc_html__('Show Arrows', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );

    $this->add_control(
      'carousel_speed',
      [
        'label' => esc_html__('Speed', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 10000,
        'step' => 50,
        'default' => 300,
      ]
    );

    $this->add_control(
      'arrows_style',
      [
        'label' => esc_html__('Arrows Styles', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_control(
      'prev-icon',
      [
        'label' => __('Previous Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-long-arrow-alt-left',
          'library' => 'solid',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_control(
      'next-icon',
      [
        'label' => __('Next Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-long-arrow-alt-right',
          'library' => 'solid',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_control(
      'arrow-position',
      [
        'label' => esc_html__('Arrow Position', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'bottom:-50px',
        'options' => [
          'top:-20px' => esc_html__('Top', 'wphd-posts-addon'),
          'top:48%' => esc_html__('Middle', 'wphd-posts-addon'),
          'bottom:-50px'  => esc_html__('Bottom', 'wphd-posts-addon'),
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-arrow' => '{{VALUE}}',
        ],
        'condition' => ['arrows' => ['true']],

      ]
    );

    $this->add_responsive_control(
      'arrow-icon-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Arrow Icon Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 50,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 20,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 25,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-image' => 'width: {{SIZE}}{{UNIT}} !important;',
          '{{WRAPPER}} .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}} !important;',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'arrow-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Arrow Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 55,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 30,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 25,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-arrow' => 'width: {{SIZE}}{{UNIT}} !important;',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'arrow-height',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Arrow Height', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 55,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 30,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 25,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-arrow' => 'height: {{SIZE}}{{UNIT}} !important;',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'arrow-border',
        'label' => esc_html__('Arrow Button Border', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .slick-arrow',
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_control(
      'arrow-border-radius',
      [
        'label' => esc_html__('Border Radius', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],
        'condition' => ['arrows' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'arrow_bg_color',
        'label' => esc_html__('Arrow Background', 'wphd-posts-addon'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .slick-arrow',
        'condition' => ['arrows' => ['true']],
      ]
    );

    /////////////////////////////////////////
    ////////// Dots Styles /////////////////
    ////////////////////////////////////////

    $this->add_control(
      'dots_style',
      [
        'label' => esc_html__('Dots Styles', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'dots-gap',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Dots Gap', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'desktop_default' => [
          'size' => 15,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-dots' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'dots-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Dot Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 15,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-dots li button' => 'width: {{SIZE}}{{UNIT}} !important;',

        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'dots-height',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Dot Height', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 15,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-dots li button' => 'height: {{SIZE}}{{UNIT}} !important;',

        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'dots_bg_color',
        'label' => esc_html__('Dot Background', 'wphd-posts-addon'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .slick-dots li button',
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_control(
      'dots-border-radius',
      [
        'label' => esc_html__('Dots Border Radius', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'dots-border',
        'label' => esc_html__('Dot Button Border', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .slick-dots li button',
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_control(
      'active_dots_style',
      [
        'label' => esc_html__('Active Dots Styles', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'active_dots-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Active Dot Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 15,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-dots .slick-active button' => 'width: {{SIZE}}{{UNIT}} !important;',

        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_responsive_control(
      'active_dots-height',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Active Dot Height', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 150,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 15,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .slick-dots .slick-active button' => 'height: {{SIZE}}{{UNIT}} !important;',

        ],
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'active_dots_bg_color',
        'label' => esc_html__('Active Dot Background', 'wphd-posts-addon'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .slick-dots .slick-active button',
        'condition' => ['dots' => ['true']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'active_dots-border',
        'label' => esc_html__('Active Dot Button Border', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .slick-dots .slick-active button',
        'condition' => ['dots' => ['true']],
      ]
    );
    $this->end_controls_section();



    /////////////////////// Image block ////////////////////////////////

    $this->start_controls_section(
      'image_style',
      [
        'label' => esc_html__('Image', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,

      ]
    );

    $this->add_control(
      'show_image',
      [
        'label' => esc_html__('Show Image', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'img-border-radius',
      [
        'label' => esc_html__('Border Radius', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => ['show_image' => ['yes']],
      ]
    );

    $this->add_responsive_control(
      'image-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Image Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 100,
          'unit' => '%',
        ],
        'tablet_default' => [
          'size' => 100,
          'unit' => '%',
        ],
        'mobile_default' => [
          'size' => 100,
          'unit' => '%',
        ],
        'selectors' => [
          '{{WRAPPER}} .post-image' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ['show_image' => ['yes']],
      ]
    );

    $this->add_responsive_control(
      'image-height',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Image Height', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', 'em'],
        'desktop_default' => [
          'size' => 200,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 100,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 90,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .post-image' => 'height: {{SIZE}}{{UNIT}} !important;',
        ],
        'condition' => ['show_image' => ['yes']],
      ]
    );

    $this->add_control(
      'image-position',
      [
        'label' => esc_html__('Image position', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'center center',
        'options' => [
          'top left' => esc_html__('Top Left', 'wphd-posts-addon'),
          'top right' => esc_html__('Top Right', 'wphd-posts-addon'),
          'center center'  => esc_html__('Center Center', 'wphd-posts-addon'),
          'bottom left' => esc_html__('Bottom Left', 'wphd-posts-addon'),
          'bottom right' => esc_html__('Bottom Right', 'wphd-posts-addon'),

        ],
        'selectors' => [
          '{{WRAPPER}} .post-image' => 'object-position: {{VALUE}} !important;',
        ],
        'condition' => ['show_image' => ['yes']],
      ]
    );

    $this->add_control(
      'img-margin',
      [
        'label' => esc_html__('Image Margin', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => ['show_image' => ['yes']],
      ]
    );


    $this->end_controls_section();



    /////////////////////////////////////////////////
    /////////// Title Styles ///////////////////////
    ///////////////////////////////////////////////

    $this->start_controls_section(
      'post_title_style',
      [
        'label' => esc_html__('Title', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => 'Post title',
        'name' => 'post_title_typography',
        'selector' => '{{WRAPPER}} .post_title',
      ]
    );

    $this->add_control(
      'title_align',
      [
        'label' => esc_html__('Alignment', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__('Right', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => 'left',
        'toggle' => true,
        'selectors' => [
          '{{WRAPPER}} .post_title' => 'text-align: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'post_title_color',
      [
        'label' => esc_html__('Post Title Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'dynamic' => [
          'active' => true,
        ],
        'default' => '#1d1d1d',
        'selectors' => [
          '{{WRAPPER}} .post_title' => 'color: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'post-title-margin',
      [
        'label' => esc_html__('Title Margin', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],

      ]
    );

    $this->end_controls_section();

    /////////////////////// Exerpt block ////////////////////////////////

    $this->start_controls_section(
      'excerpt_style',
      [
        'label' => esc_html__('Excerpt', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => 'Post excerpt',
        'name' => 'post_excerpt_typography',
        'selector' => '{{WRAPPER}} .post-excerpt',
      ]
    );

    $this->add_control(
      'excerpt_align',
      [
        'label' => esc_html__('Excerpt Alignment', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__('Right', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => 'left',
        'toggle' => true,
        'selectors' => [
          '{{WRAPPER}} .post-excerpt' => 'text-align: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'excerpt',
      [
        'label' => esc_html__('Words per post', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 1220,
        'step' => 1,
        'default' => 20,
      ]
    );

    $this->add_control(
      'post_excerpt_color',
      [
        'label' => esc_html__('Post Excerpt Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#3c4752',
        'selectors' => [
          '{{WRAPPER}} .post-excerpt' => 'color: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'excerpt-margin',
      [
        'label' => esc_html__('Excerpt Margin', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],

      ]
    );

    $this->end_controls_section();


    ////////////////////////////////////////////////////
    ////////////////// Author and Date Block /////////////////////
    //////////////////////////////////////////////////

    $this->start_controls_section(
      'info_style',
      [
        'label' => esc_html__('Author and date', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'default-avatar',
      [
        'label' => esc_html__('Default Avatar', 'textdomain'),
        'type' => \Elementor\Controls_Manager::MEDIA,
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => 'Typography',
        'name' => 'post_information_typography',
        'selector' => '{{WRAPPER}} .post-info',
      ]
    );



    $this->add_control(
      'post_info_color',
      [
        'label' => esc_html__('Text Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#007ce0',
        'selectors' => [
          '{{WRAPPER}} .post-info' => 'color: {{VALUE}} !important;',
        ],
      ]
    );


    $this->add_control(
      'show_post_autor',
      [
        'label' => esc_html__('Show Post Author', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'show_date',
      [
        'label' => esc_html__('Show Date', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'info-block-margin',
      [
        'label' => esc_html__('Margin', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],

      ]
    );

    $this->end_controls_section();



    ///////////////////////////////////////////
    //////////////////Price style ///////////////
    /////////////////////////////////////////////

    $this->start_controls_section(
      'price_style',
      [
        'label' => esc_html__('Price', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => ['post_type' => ['product']],
      ]
    );

    $this->add_control(
      'price_color',
      [
        'label' => esc_html__('Price Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#007ce0',
        'selectors' => [
          '{{WRAPPER}} .grid-price' => 'color: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => 'Price Typography',
        'name' => 'price_typography',
        'selector' => '{{WRAPPER}} .grid-price',
      ]
    );

    $this->add_control(
      'price_align',
      [
        'label' => esc_html__('Alignment', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__('Right', 'wphd-posts-addon'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => 'left',
        'toggle' => true,
        'selector' => '{{WRAPPER}} .grid-price',
      ]
    );

    $this->end_controls_section();


    ////////////////////////// Post wrapper /////////////////////////
    $this->start_controls_section(
      'post_wrapper_style',
      [
        'label' => esc_html__('Single post wrapper', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,

      ]
    );
    $this->add_responsive_control(
      'posts-gap',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Gap', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'desktop_default' => [
          'size' => 35,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 20,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 20,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .posts-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ['post_style' => ['grid', 'list']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'bg_block_color',
        'label' => esc_html__('Background', 'wphd-posts-addon'),
        'types' => ['classic', 'gradient', 'video'],
        'selector' => '{{WRAPPER}} .post-item',

      ]
    );

    $this->add_responsive_control(
      'margin',
      [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__('Margin', 'wphd-posts-addon'),
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .post-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'condition' => ['post_style' => ['grid', 'list']],
      ]
    );


    $this->add_responsive_control(
      'post-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%'],
        'desktop_default' => [
          'size' => 48,
          'unit' => '%',
        ],
        'tablet_default' => [
          'size' => 100,
          'unit' => '%',
        ],
        'mobile_default' => [
          'size' => 100,
          'unit' => '%',
        ],
        'selectors' => [
          '{{WRAPPER}} .grid .post-item' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ['post_style' => ['grid']],
      ]
    );

    $this->add_responsive_control(
      'padding',
      [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__('Padding', 'wphd-posts-addon'),
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],

      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'border',
        'label' => esc_html__('Border', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .post-item',

      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'box_shadow',
        'label' => esc_html__('Box Shadow', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .post-item',
      ]
    );

    $this->add_control(
      'border-radius',
      [
        'label' => esc_html__('Border Radius', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    ////////////////////////////////////////////////////////////////////
    //////////////////////// Post button //////////////////////////////
    //////////////////////////////////////////////////////////////////

    $this->start_controls_section(
      'post_button_style',
      [
        'label' => esc_html__('Button', 'wphd-posts-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );



    $this->add_control(
      'show_button',
      [
        'label' => esc_html__('Show Button', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'your-plugin'),
        'label_off' => esc_html__('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => 'Button',
        'name' => 'button_information_typography',
        'selector' => '{{WRAPPER}} .post-btn',
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_responsive_control(
      'btn-width',
      [
        'type' => \Elementor\Controls_Manager::SLIDER,
        'label' => esc_html__('Button Width', 'wphd-posts-addon'),
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1500,
          ],
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'size_units' => ['px', '%', 'em'],
        'desktop_default' => [
          'size' => 100,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 100,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 100,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'btn_text',
      [
        'type' => \Elementor\Controls_Manager::TEXT,
        'label' => esc_html__('Text on the Button', 'wphd-posts-addon'),
        'default' => esc_html__('Read More', 'wphd-posts-addon'),
        'placeholder' => esc_html__('Enter your text', 'wphd-posts-addon'),
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'button_border',
        'label' => esc_html__('Border', 'wphd-posts-addon'),
        'selector' => '{{WRAPPER}} .post-btn',
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'btn_border-radius',
      [
        'label' => esc_html__('Border Radius', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'btn_padding',
      [
        'label' => esc_html__('Button Padding', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );


    $this->add_control(
      'btn_margin',
      [
        'label' => esc_html__('Button Margin', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'button_color',
      [
        'label' => esc_html__('Button Text Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'color: {{VALUE}} !important ',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'button_color_hover',
      [
        'label' => esc_html__('Button Text Color on Hover', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .post-btn:hover' => 'color: {{VALUE}} !important;',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'button_bg_color',
      [
        'label' => esc_html__('Button Background Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .post-btn' => 'background-color: {{VALUE}} !important;',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );

    $this->add_control(
      'button_bg_hover_color',
      [
        'label' => esc_html__('Button Background on Hover Color', 'wphd-posts-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .post-btn:hover' => 'background-color: {{VALUE}} !important;',
        ],
        'condition' => ['show_button' => ['yes']],
      ]
    );



    $this->end_controls_section();
  }

  public function get_categories()
  {
    return ['wphd'];
  }

  protected function render()
  {
    $allowed = array(
      'strong' => array(),
    );
    $settings = $this->get_settings_for_display();

    $query = new WP_Query(array(
      'post_type' =>  $settings['post_type'],
      'posts_per_page' =>  $settings['post_qty'],
      'orderby' => $settings['order_by'],
      'order' => $settings['sorted'],


    ));

    global $post;
    if ($settings['dots'] == 'true') {
      $dots = 'true';
    } else {
      $dots = 'false';
    }

    if ($settings['arrows'] == 'true') {
      $arrows = 'true';
    } else {
      $arrows = 'false';
    }
    if ($settings['arrows'] == 'true') {
      if (isset($settings['next-icon']['value']['url'])) {
        $nexticon = $settings['next-icon']['value']['url'];
      } else {
        $nexticon = $settings['next-icon']['value'];
      }

      if (isset($settings['prev-icon']['value']['url'])) {
        $previcon = $settings['prev-icon']['value']['url'];
      } else {
        $previcon = $settings['prev-icon']['value'];
      }
    } else {
      $nexticon = "";
      $previcon = "";
    }

    echo '<div class="posts-wrapper ' . esc_attr($settings['post_style']) . '" data-columns="' . esc_attr($settings['carousel-post-qty']) . '" data-dots="' . esc_attr($dots) . '" data-speed="' . esc_attr($settings['carousel_speed']) . '" data-arrows ="' . esc_attr($arrows) . '" data-prev="' . esc_attr($previcon) . '" data-next="' . esc_attr($nexticon) . '">';

    while ($query->have_posts()) : $query->the_post();
      setup_postdata($post);

      echo '<a href="' . esc_attr(get_post_permalink()) . '" class="post-item">';

      //if post style is grid
      if ($settings['post_style'] == 'grid' || $settings['post_style'] == 'carousel') :
        echo '<div class="post-content">';
      endif;

      // if there the post has thumbnail
      if (has_post_thumbnail() && $settings['show_image'] == 'yes') {

        echo '<img src="' . get_the_post_thumbnail_url() . '" class="post-image" />';
      }

      //if post style is list
      if ($settings['post_style'] == 'list') :
        echo '<div class="post-container">
        <div class="top-block">';
      endif;

      echo '<h2 class="post_title">' . esc_html($post->post_title) . '</h2>';

      if (!has_excerpt()) {
        if ($settings['post_type'] !== 'page') :
          echo '<div class="post-excerpt">';
          $content = wp_trim_words(get_the_content(), $settings['excerpt'], '...');
          echo  wp_kses($content, $allowed);
          echo '</div>';
        endif;
      } else {
        echo '<div class="post-excerpt">';
        echo   wp_kses(get_the_excerpt(), $allowed);
        echo '</div>';
      }

      if ($settings['post_style'] == 'list') :
        echo '</div><div class="post-bottom-block">';
      endif;

      //if post style is grid
      if ($settings['post_style'] == 'grid' || $settings['post_style'] == 'carousel') :
        echo '</div>';
        echo '<div class="post-bottom-block">';
      endif;

      // If product 
      if ($settings['post_type'] == 'product') {
        global $product;
        echo '<p class="grid-price">' .  wp_kses($product->get_price_html(), $allowed) . '</p>';
      }

      // Showing post info, avatar, autor and date
      if ($settings['post_type'] !== 'product') :
        echo '<div class="post-info-block" >';

        if ($settings['show_post_autor'] === "yes") :
          echo '<div class="post-info">';
          if ($settings['default-avatar']['url'] !== '') {
            echo '<img src="' . esc_html($settings['default-avatar']['url']) . '" style="width:40px;height:40px;border-radius:50%;object-fit:cover;" class="avatar" />';
          } else {
            echo get_avatar($post->post_author, '40');
          }
          echo esc_html__('by', 'wphd-posts-addon') . ' ' . esc_html(get_the_author());
          echo '</div>';
        endif;
        if ($settings['show_date'] === "yes") :
          echo '<div class="post-info">';
          echo esc_html(get_the_date());
          echo '</div>';
        endif;
        echo '</div>';
      endif;
      if ($settings['show_button'] === 'yes') :
        echo '<p class="post-btn"><span class="post-btn__text">' .  esc_html__($settings['btn_text'], 'wphd-posts-addon') .  '</span>
        </p> ';
      endif;
      if ($settings['post_style'] == 'list') :
        echo '</div>'; // close the post-bottom-block of list
      endif;
      echo '</div>';
      echo '</a>';

    endwhile;
    echo '</div>';

    wp_reset_postdata();
  }


  public function get_keywords()
  {
    return ['post grid', 'products grid', 'post carousel', 'post slick slider'];
  }
}
