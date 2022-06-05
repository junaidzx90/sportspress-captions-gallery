<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Gallery
 * @subpackage Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gallery
 * @subpackage Gallery/admin
 * @author     Md captions_galleries <admin@easeare.com>
 */
class Caption_Gallery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version; 
		
		add_image_size( 'caption_gallery_thumb', '140','140', true );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'caption-fancybox', plugin_dir_url( __FILE__ ) . 'css/fancybox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caption-gallery-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'caption-admin-css', plugin_dir_url( __FILE__ ) . 'css/caption-gallery-admin.css', array(), $this->version, 'all' );
		wp_enqueue_script( 'caption-fancybox-js', plugin_dir_url( __FILE__ ) . 'js/fancybox.js', array(  ), $this->version, false );
		wp_enqueue_script( 'caption-general-js', plugin_dir_url( __FILE__ ) . 'js/general.js', array( 'caption-fancybox-js' ), $this->version, true );
		wp_localize_script( 'caption-general-js', 'caption_gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function public_enqueue_scripts() {
		wp_enqueue_style( 'caption-fancybox-css', plugin_dir_url( __FILE__ ) . 'css/fancybox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caption-gallery-public.css', array(), $this->version, 'all' );
		
		wp_enqueue_script( 'caption-fancybox-js', plugin_dir_url( __FILE__ ) . 'js/fancybox.js', array(  ), $this->version, false );
		wp_enqueue_script( 'jqform', plugin_dir_url( __FILE__ ) . 'js/jquery.form.min.js', array(  ), $this->version, false );
		wp_enqueue_script( 'caption-general-js', plugin_dir_url( __FILE__ ) . 'js/general.js', array( 'caption-fancybox-js' ), $this->version, false );
		wp_localize_script( 'caption-general-js', 'caption_gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/caption-gallery-post.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'caption_gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
	}

	function captions_galleries_team_template($data){
		$captions_galleries = array(
			'captions_galleries' => array(
				'title' => __( 'Caption Gallery', 'sportspress' ),
				'option' => 'sportspress_team_show_captions_galleries',
				'action' => [$this,'sportspress_output_captions_galleries'],
				'default' => 'yes',
			),
		);
		return array_merge($data, $captions_galleries);
	}

	function captions_galleries_player_template($data){
		$captions_galleries = array(
			'captions_galleries' => array(
				'title' => __( 'Caption Gallery', 'sportspress' ),
				'option' => 'sportspress_player_show_captions_galleries',
				'action' => [$this,'sportspress_output_captions_galleries'],
				'default' => 'yes',
			),
		);
		return array_merge($data, $captions_galleries);
	}
	
	function sportspress_output_captions_galleries(){
		require_once plugin_dir_path( __FILE__ )."partials/public-caption-gallery.php";
	}

	function caption_gallery_meta_boxes(){
		$screens = ['sp_player'];
		foreach($screens as $screen){
			add_meta_box( 'user_caption_gallery', 'Caption Gallery', [$this,'admin_caption_gallery_meta'], $screen, 'normal', 'default' );
		}
	}

	function admin_caption_gallery_meta(){
		global $wpdb;
		$post_id = get_post()->ID;
		require_once plugin_dir_path( __FILE__ )."partials/admin-caption-gallery.php";
	}

	// Woocommerce menuitem
	function junu_one_more_link( $menu_links ){
		// we will hook "caption_gallery" later
		$new = array( 'caption-gallery' => 'Caption Gallery' );
	
		// array_slice() is good when you want to add an element between the other ones
		$menu_links = array_slice( $menu_links, 0, 1, true ) 
		+ $new 
		+ array_slice( $menu_links, 1, NULL, true );

		return $menu_links;
	}

	function junu_hook_endpoint( $url, $endpoint, $value, $permalink ){
		if( $endpoint === 'caption-gallery' ) {
	 
			// ok, here is the place for your custom URL, it could be external
			$url = site_url().'/my-account/caption-gallery';
	 
		}
		return $url;
	}

	function junu_add_endpoint() {
		add_rewrite_endpoint( 'caption-gallery', EP_PAGES );
	}

	function junu_my_account_endpoint_content() {
		require_once plugin_dir_path( __FILE__ )."partials/user-caption-gallery.php";
	}

	function upload_documents($file){
		$wpdir = wp_upload_dir(  );
		$max_upload_size = wp_max_upload_size();
		$fileSize = $file['size'];
		$imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

		$filename = rand(10,100);

		$folderPath = $wpdir['basedir'];
		$uploadPath = $folderPath."/captions-galleries/$filename.$imageFileType";
		$uploadedUrl = $wpdir['baseurl']."/captions-galleries/$filename.$imageFileType";

		if (!file_exists($folderPath."/captions-galleries")) {
			mkdir($folderPath."/captions-galleries", 0777, true);
		}

		// Allow certain file formats
		$allowedExt = array("jpg", "jpeg", "png", "PNG", "JPG", "gif");

		if(!in_array($imageFileType, $allowedExt)) {
			echo json_encode(array("error" => "Unsupported file format!"));
			die;
		}

		if ($fileSize > $max_upload_size) {
			echo json_encode(array("error" => "Maximum upload size $max_upload_size"));
			die;
		}

		if(empty($comp_alerts)){
			if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
				return $uploadedUrl;
			}
		}
	}

	function store_caption_gallery_image(){
		$imageUrl = '';
		$gallery_caption = '';
		if(isset($_POST['spg_image_url'])){
			$imageUrl = $_POST['spg_image_url'];			
		}
		if(isset($_POST['gallery_caption'])){
			$gallery_caption = sanitize_text_field( $_POST['gallery_caption'] );
		}

		if(empty($imageUrl)){
			if(isset($_FILES['spg_upload_image'])){
				$file = $_FILES['spg_upload_image'];
				$imageUrl = $this->upload_documents($file);
			}
		}

		if(!empty($imageUrl)){
			$caption_gallery = get_user_meta(get_current_user_id(  ), 'gcb_caption_gallery', true );
			if(!is_array($caption_gallery)){
				$caption_gallery = [];
			}

			$caption_gallery[] = [
				'image' => $imageUrl,
				'caption' => $gallery_caption
			];
			update_user_meta( get_current_user_id(  ), 'gcb_caption_gallery', $caption_gallery );
			echo json_encode(array('success' => "Image successfully uploaded."));
			die;
		}

		echo json_encode(array("error" => "We're sorry you're having trouble uploading an image!"));
		die;
	}

	function delete_caption_gallery_item(){
		if(isset($_POST['index']) && isset($_POST['user_id'])){
			$user_id = intval($_POST['user_id']);
			$index = intval($_POST['index']);

			$caption_gallery = get_user_meta($user_id, 'gcb_caption_gallery', true );
			if(!is_array($caption_gallery)){
				$caption_gallery = [];
			}

			if(array_key_exists($index, $caption_gallery)){
				unset($caption_gallery[$index]);
				update_user_meta( $user_id, 'gcb_caption_gallery', $caption_gallery );
			}

			echo json_encode(array('success' => "Image successfully deleted."));
			die;
		}
	}
}