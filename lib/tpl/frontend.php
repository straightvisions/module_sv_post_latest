<div class="sv-post-latest-container quiet">
	<div class="bg-primary sv-post-latest-title text-center text-white padding-v-xs">
		<h3 class="m-0 font-weight-normal"><?php echo $settings['title']; ?></h3>
	</div>
	<?php if (is_active_sidebar($this->get_module_name())){ ?>
		<div id="<?php echo $this->get_module_name(); ?>_widgets" class="widget-area font-size-sm">
			<ul>
				<?php dynamic_sidebar($this->get_module_name()); ?>
			</ul>
		</div>
	<?php } ?>
	<div class="sv-post-latest-body container bg-white padding-v-sm">
		<?php
		
		$query = new WP_Query( array(
			'cat' => $settings['id'],
			'posts_per_page' => $settings['limit'],
		)); 
		
		if ( $query->have_posts() ){
			$i = 1;
			while ( $query->have_posts() ){
				$query->the_post(); 
				if($i > 1){
					echo '<p>&nbsp;</p>';
				}
				?>

  				<h4 class="sv-post-latest-post-titlx"><?php echo the_title(); ?></h4>
					<div class="sv-post-latest-post-thumb mb-3">
						<?php echo the_post_thumbnail(); ?>
					</div>
					<div class="sv-post-latest-post-text">
						<p class=""><?php echo get_the_content(); ?></p>
					</div>	
				<?php
				$i++;
			}
			wp_reset_postdata();
		}else{
			echo '<p>'.__('No News').'</p>';
		}		
    ?>
  </div>
</div>