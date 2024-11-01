<?php
/*
 * Plugin Name: WebD Modal Widget
 * Plugin URI: https://webdeveloping.gr/projects/add-modal-popup-widget-wordpress-site/
 * Description: Modal  - Popup Widget for your Wordpress Site.
 * Version: 1.1
 * Author: webdeveloping.gr
 * Author URI: https://webdeveloping.gr
 * License: GPL2
 * Created On: 18-12-2017
 * Updated On: 31-10-2018
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
  
class WeBdModalWidgetInit extends WP_Widget{
		
		public $plugin = 'WebdModalWidget';		
		public $name = 'WebD Modal Widget';
		public $shortName = 'Modal Widget';
		public $slug = 'webd-modal-widget';
		public $dashicon = 'dashicons-editor-table';
		public $proUrl = 'https://webdeveloping.gr/product/wordpress-modal-widget-pro';
		public $menuPosition ='50';
		public $localizeBackend;
		public $localizeFrontend;
		public $description = 'Modal  - Popup Widget for your Wordpress Site.';
 
		public function __construct() {			
			add_action('wp_enqueue_scripts', array($this, 'FrontEndScripts') );
			add_action('admin_enqueue_scripts', array($this, 'BackEndScripts') );
			add_filter('widget_text', 'do_shortcode');	
			//add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'Links'),1 );

			$widget_details = array(
				'classname' => $this->slug,
				'description' => $this->description
			);
			parent::__construct( $this->slug, $this->name, $widget_details );						
		
		}
 
		public function BackEndScripts(){
			wp_enqueue_style( $this->plugin."adminCss", plugins_url( "/css/backend.php", __FILE__ ) );	
			wp_enqueue_style( $this->plugin."adminCss");				
			wp_enqueue_script('jquery');		
			wp_enqueue_script( $this->plugin."adminJs", plugins_url( "/js/backend.js", __FILE__ ) , array('jquery') , null, true);	
						
			$this->localizeBackend = array( 
				'plugin_url' => plugins_url( '', __FILE__ ),
				'siteUrl'	=>	site_url(),
				'plugin_wrapper'=> $this->plugin,
			);		
			wp_localize_script($this->plugin."adminJs", $this->plugin , $this->localizeBackend );
			wp_enqueue_script( $this->plugin."adminJs");
			
		}
		
		public function FrontEndScripts(){
			wp_enqueue_style( $this->plugin."css", plugins_url( "/css/frontend.php", __FILE__ ) );	
			wp_enqueue_style( $this->plugin."css");
				
			wp_enqueue_script('jquery');
			wp_enqueue_script( $this->plugin."js", plugins_url( "/js/frontend.js", __FILE__ ) , array('jquery') , null, true);	
			
			$this->localizeFrontend = array( 
				'plugin_url' => plugins_url( '', __FILE__ ),
				'siteUrl'	=>	site_url(),
				'plugin_wrapper'=> $this->plugin,
			);		
			wp_localize_script($this->plugin."js", $this->plugin , $this->localizeFrontend );
			wp_enqueue_script( $this->plugin."js");
		}		
		
	
		public function Links($links){
			//$mylinks[] =  '<a href="' . admin_url( "admin.php?page=".$this->slug ) . '">Settings</a>';
			$mylinks[] = "<a href='".$this->proUrl."' target='_blank'>PRO Version</a>";
			return array_merge( $links, $mylinks );		
		}

		public function form( $instance ) {			
			$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : '';
			$header_align = ( !empty( $instance[$this->plugin.'header_align'] ) ) ? $instance[$this->plugin.'header_align'] : 'center';
			$content = ( !empty( $instance[$this->plugin.'content'] ) ) ? $instance[$this->plugin.'content'] : '';
			$content_align = ( !empty( $instance[$this->plugin.'content_align'] ) ) ? $instance[$this->plugin.'content_align'] : 'left';
			$footer = ( !empty( $instance[$this->plugin.'footer'] ) ) ? $instance[$this->plugin.'footer'] : '';
			$footer_align = ( !empty( $instance[$this->plugin.'footer_align'] ) ) ? $instance[$this->plugin.'footer_align'] : 'center';
			$modal_width = ( !empty( $instance[$this->plugin.'modal_width'] ) ) ? $instance[$this->plugin.'modal_width'] : '50%';
						
			?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ); ?>">Title </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>	
				<label for="<?php echo $this->get_field_name( $this->plugin.'header_align' ); ?>">Title Alignment</label><br/>
				<select class="widefat" id="<?php echo $this->get_field_id( $this->plugin.'header_align' ); ?>" name='<?php echo $this->get_field_name( $this->plugin.'header_align' ); ?>'>
					<?php if(!empty (esc_attr( $header_align )) ){
						?><option value='<?php echo esc_attr( $header_align ); ?>'><?php echo esc_attr( $header_align ); ?></option><?php
						}else ?><option value=''>Select...</option> <?php 
					?>
					<option value='left'>left</option>
					<option value='right'>right</option>
					<option value='center'>center</option>
				</select>				
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_name( 'content' ); ?>">Content Text</label>
				
				<?php 
				$settings = array(
					'media_buttons' => true,
					'textarea_rows' => 6,
					'tinymce'		=> false,
					'textarea_name' => $this->get_field_name( $this->plugin.'content' ),
					//'teeny'         => false,
				);				
				wp_editor( esc_attr($content), $this->get_field_id( $this->plugin.'content' ) ,$settings );
							
				?>
				
			</p>			
			<p>	
				<label for="<?php echo $this->get_field_name( $this->plugin.'content_align' ); ?>">Content Alignment</label><br/>
				<select class="widefat" id="<?php echo $this->get_field_id( $this->plugin.'content_align' ); ?>" name='<?php echo $this->get_field_name( $this->plugin.'content_align' ); ?>'>
					<?php if(!empty (esc_attr( $content_align )) ){
						?><option value='<?php echo esc_attr( $content_align ); ?>'><?php echo esc_attr( $content_align ); ?></option><?php
						}else ?><option value=''>Select...</option> <?php 
					?>
					<option value='left'>left</option>
					<option value='right'>right</option>
					<option value='center'>center</option>
				</select>				
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( $this->plugin.'footer' ); ?>">Footer Text</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $this->plugin.'footer' ); ?>" name="<?php echo $this->get_field_name( $this->plugin.'footer' ); ?>" type="text" value="<?php echo esc_attr( $footer ); ?>" />
			</p>
			

			<p>	
				<label for="<?php echo $this->get_field_name( $this->plugin.'footer_align' ); ?>">Footer Alignment</label><br/>
				<select class="widefat" id="<?php echo $this->get_field_id( $this->plugin.'footer_align' ); ?>" name='<?php echo $this->get_field_name( $this->plugin.'footer_align' ); ?>'>
					<?php if(!empty (esc_attr( $footer_align )) ){
						?><option value='<?php echo esc_attr( $footer_align ); ?>'><?php echo esc_attr( $footer_align ); ?></option><?php
						}else ?><option value=''>Select...</option> <?php 
					?>
					<option value='left'>left</option>
					<option value='right'>right</option>
					<option value='center'>center</option>
				</select>
				
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( $this->plugin.'modal_width' ); ?>">Modal Width (in px,%)</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $this->plugin.'modal_width' ); ?>" name="<?php echo $this->get_field_name( $this->plugin.'modal_width' ); ?>" type="text" value="<?php echo esc_attr( $modal_width ); ?>" placeholder='eg 50%' />
			</p>
			
			<!-- PRO VERSION -->
			
			<p>
				<label>
				<a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Select Title Backround - in PRO Version</a>
				</label><br/>	
				<input class="widefat colorp"  readonly disabled type="text" placeholder='Select Color' />			
			</p>
			<p>	
				<label>
				<a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Title Color - in PRO VERSION</a>
				</label><br/>
				<input class="widefat colorp"   readonly disabled  type="text" placeholder='Select Color'  />
			</p>			

				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Title Wrapper  - in PRO VERSION</a></label><br/>
				<select class="widefat" readonly disabled>
					<option value=''>Select between h1,h2,h3,h4,p,strong...</option>
				</select>				
			</p>		
			<p>
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Content Backround - in PRO VERSION</a></label><br/>
				<input class="widefat colorp"   readonly disabled type="text" placeholder='Select Color'/>
				
			</p>
			<p>	
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Content Color - in PRO VERSION</a></label><br/>
				<input class="widefat colorp" readonly disabled type="text" placeholder='Select Color' />
				
			</p>			

			<p>
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Footer Backround - in PRO VERSION</a></label><br/>
				<input class="widefat colorp" readonly disabled type="text" placeholder='Select Color' />
				
			</p>
			<p>	
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Footer Color - in PRO VERSION</a></label><br/>
				<input class="widefat colorp" readonly disabled type="text" placeholder='Select Color' />
			</p>

			
			<p>	
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Footer Wrapper - in PRO VERSION</a></label><br/>
				<select class="widefat" readonly disabled>
					<option value=''>Select between h1,h2,h3,h4,p,strong...</option>
				</select>			
			</p>
			
			<p>	
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>Close Button Color - in PRO VERSION</a></label><br/>
				<input class="widefat colorp"  readonly disabled type="text" placeholder='Select Color' />
			</p>	
			
			<p>
				<input class="widefat" disabled readonly type='checkbox' /> 			
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>			
					<strong>Don't show Popup in Same User Again if hits Close Button - in PRO VERSION</strong>
				</a></label>

			</p>
			<p>
				<label><a class='pro' href='<?php print $this->proUrl; ?>' target='_blank'>			
					Display Any Content with a shortcode in Content Area of Popup - in PRO VERSION
				</a></label>
			</p>
			
			<p style='text-align:center;font-style:16px;font-weight:bold;'>
				<a class='proButton' href='<?php print $this->proUrl; ?>' target='_blank'>Get Pro Version for 4&euro;!</a>
			</p>
					
			<?php
		}
		
		
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			?>
			<div id="<?php print $this->plugin;?>-Modal" class="<?php print $this->plugin;?>-modal">

			  <!-- Modal content -->
			  <div class="<?php print $this->plugin;?>-modal-content">
			  
				<?php if( !empty( $instance['title'] ) ) { ?>
				<div class="<?php print $this->plugin;?>-modal-header" 
				style='background:<?php print $instance[$this->plugin.'header_background'];?>; 
				color:<?php print $instance[$this->plugin.'header_color'];?>;
				text-align:<?php print $instance[$this->plugin.'header_align'];?>'
				>
				  <span class="<?php print $this->plugin;?>-close" 
				  <?php if(!empty($instance[$this->plugin.'close_button'])){ ?>
					style='color:<?php print $instance[$this->plugin.'close_button'];?>'
				  <?php } ?>
				  
				  >&times;</span>
				  
				  <?php if(!empty($instance[$this->plugin.'header_wrapper'])){ ?>
					<?php print "<".$instance[$this->plugin.'header_wrapper']." style='color:".$instance[$this->plugin.'header_color']."' >" ; ?>
				  <?php }else{ ?>
						<h2>
				  <?php } ?>
					<?php echo $instance['title']; ?>	
							  
				  <?php if(!empty($instance[$this->plugin.'header_wrapper'])){ ?>
					<?php print "</".$instance[$this->plugin.'header_wrapper'].">" ; ?>
				  <?php }else{ ?>
						</h2>
				  <?php } ?>
				  
				</div>
				<?php } ?>
				<?php if( !empty( $instance[$this->plugin.'content'] ) ) { ?>
				<div class="<?php print $this->plugin;?>-modal-body"
				style='background:<?php print $instance[$this->plugin.'content_background'];?>; 
				color:<?php print $instance[$this->plugin.'content_color'];?>;
				text-align:<?php print $instance[$this->plugin.'content_align'];?>;
				position:relative;
				margin:0 auto;
				'				
				>				 
				  <?php echo $instance[$this->plugin.'content'];  ?>			  
				</div>
				<?php } ?>
				<?php if( !empty( $instance[$this->plugin.'footer'] ) ) { 	
						
				?>
				<div class="<?php print $this->plugin;?>-modal-footer"
				style='background:<?php print $instance[$this->plugin.'footer_background'];?>; 
				color:<?php print $instance[$this->plugin.'footer_color'];?> !important;
				text-align:<?php print $instance[$this->plugin.'footer_align'];?>'						
				>
				  <?php if(!empty($instance[$this->plugin.'footer_wrapper'])){ ?>
					<?php print "<".$instance[$this->plugin.'footer_wrapper']." style='color:".$instance[$this->plugin.'footer_color']."'>" ; ?>
				  <?php }else{ ?>
						<h4>
				  <?php } ?>
				  
				  <?php echo $instance[$this->plugin.'footer']; ?>
				  
				  <?php if(!empty($instance[$this->plugin.'footer_wrapper'])){ ?>
					<?php print "</".$instance[$this->plugin.'footer_wrapper'].">" ; ?>
				  <?php }else{ ?>
						</h4>
				  <?php } ?>
				  
				</div>
				<?php } ?>
			  </div>

			</div>
			
			<style>
				.<?php print $this->plugin;?>-modal-content{
				<?php if(!empty($instance[$this->plugin.'modal_width'])){ ?>
					width:<?php print $instance[$this->plugin.'modal_width'];  ?>
				<?php }else{ ?>
					width:70%;
				<?php } ?>				
				}
				
				@media(max-width:980px){
					.<?php print $this->plugin;?>-modal-content{
						width:90%;
					}
				}				
			</style>

			
			<?php
			echo $args['after_widget'];
		}	
		
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );			
			$instance[ $this->plugin.'header_align' ] = strip_tags( $new_instance[ $this->plugin.'header_align' ] );			
			$instance[ $this->plugin.'content' ]	= $new_instance[ $this->plugin.'content' ] ;	
			$instance[ $this->plugin.'content_align' ] = strip_tags( $new_instance[ $this->plugin.'content_align' ] );			
			$instance[ $this->plugin.'footer' ] = strip_tags( $new_instance[ $this->plugin.'footer' ] );	
			$instance[ $this->plugin.'footer_align' ] = strip_tags( $new_instance[ $this->plugin.'footer_align' ] );
			
			$instance[ $this->plugin.'modal_width' ] = strip_tags( $new_instance[ $this->plugin.'modal_width' ] );	
			
			return $instance;
		}

		
}

$instantiate = new WeBdModalWidgetInit();
add_action( 'widgets_init', function(){
	register_widget( 'WeBdModalWidgetInit');
});	


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'WeBdModalWidgetInit' );
function WeBdModalWidgetInit( $links ) {
   $links[] = '<a href="https://webdeveloping.gr/product/wordpress-modal-widget-pro" target="_blank">PRO Version</a>';
   return $links;
}

