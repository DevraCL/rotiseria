<div class="team-wrapper clearfix">
	<article id="team-<?php the_ID(); ?>" <?php post_class(); ?>>		
		<div class="team-single ">
			<div class="team-content">
				<div class="team-info">
				 	<div class="team-preview">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail">
					        <a href="<?php the_permalink(); ?>" class="teacher-box-image-inner ">	
					         	<?php the_post_thumbnail('full'); ?>
					        </a>
						</div>
					<?php endif; ?>
					</div><!-- .image-thumbnail -->

					<div class="text-center">
						<div class="team-job">
							<?php echo wpopal_getMetaboxValue( get_the_ID(), 'team_job'); ?>
						</div>
						<div class="social">
							<a href="<?php echo esc_url( wpopal_getMetaboxValue( get_the_ID(), 'team_facebook') ); ?>"><i class="fa fa-facebook"></i> </a>
							<a href="<?php echo esc_url( wpopal_getMetaboxValue( get_the_ID(), 'team_google') ); ?>"><i class="fa fa-google"></i></a>
							<a href="<?php echo esc_url( wpopal_getMetaboxValue( get_the_ID(), 'team_twitter') ); ?>"><i class="fa fa-twitter"></i></a>
							<a href="<?php echo esc_url( wpopal_getMetaboxValue( get_the_ID(), 'team_pinterest') ); ?>"><i class="fa fa-pinterest"></i></a>
						</div>

					</div>
					<ul class="metabox">
						<li class="address">
							<span><?php esc_html_e( 'Address : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_address') ); ?></li>
						<li class="phone">
							<span><?php esc_html_e( 'Phone : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_phone_number') ); ?></li>
						<li class="mobile">
							<span><?php esc_html_e( 'Mobile : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_mobile') ); ?></li>
						<li class="fax">
							<span><?php esc_html_e( 'Fax : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_fax') ); ?></li>
						<li class="web">
							<span><?php esc_html_e( 'Web : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_web') ); ?></li>
						<li class="email">
							<span><?php esc_html_e( 'Email : ', 'wpopal-themer' ); ?></span>
							<?php echo esc_html( wpopal_getMetaboxValue( get_the_ID(), 'team_email') ); ?></li>
					</ul>
				</div>
				<div class="team-body">
					
					<?php the_title( '<h1 class="team-title">', '</h1>' ); ?>
					<?php
						the_content( sprintf(
							esc_html__( 'Continue reading %s', 'wpopal-themer').'<span class="meta-nav">&rarr;</span>',
							the_title( '<span class="screen-reader-text">', '</span>', false )
						) ); 
					?> <!-- .the-content -->

					<?php if( opalhomes_fnc_theme_options('blog-show-share-post', true) ){
						get_template_part( 'page-templates/parts/sharebox' );
					} ?>
				</div><!-- .team-header -->

			</div><!-- .team-content -->

		</div>
	</article><!-- #team-## -->

</div>

