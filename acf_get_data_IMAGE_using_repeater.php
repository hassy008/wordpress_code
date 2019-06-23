<?php 
/**
 * Template Name: Agents
 **/
	get_header('custom'); 
?>

<?php 	
    $args = array(
    	'posts_per_page'   => -1,
		//'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'estate_agent',
	);

	$agents = get_posts( $args ); 
		// echo "<pre>";
	 //    print_r($agents);
	 //    echo"</pre>";

 ?>

<style>
	.about-agent-hero-section{
		background-image: url(<?= the_post_thumbnail_url('full'); ?>); 
		/*background-image: url('/wp-content/plugins/opcodespace/assets/images/about-agent-bg.jpg');*/
	}
</style>

<div class="pt-92"></div>
<!-- hero area start -->
<div class="about-agent-hero-section overflow-hidden">
	<div class="container">
		<div class="about-hero-display-table">
			<div class="about-hero-agent-content text-center">
				<h1><?= get_field('title'); ?></h1>
				<p><?= get_field('sub_title'); ?></p>
				<a href="<?= get_field('link'); ?>" class="cmn-btn">Connect With an Agent</a>
			</div>
		</div>
	</div>
</div> <!-- hero area ending tag-->
<!-- agent gellary start -->
<div class="agents-gellary overflow-hidden">
	<div class="container">
		<div class="row">

			<?php foreach ($agents as $agent) : ?>
			 <div class="col-md-3 col-sm-4">
				<div class="single-agent-profile-wrapper">
					<div class="agent-img">
						<?= get_the_post_thumbnail($agent->ID, 'full'); ?>	 	<!-- get_the_post_thumbnail()->uses inside loop -->			
					</div>
					<div class="agent-details">
						<div class="agent-name"><a href="/about/dustin-humphreys"><?= $agent->post_title; ?></a><span class="bordered"></span><span class="designation"><?= $agent->agent_position; ?></span></div>
						<div class="agent-email-warp">
							<span class="mail"><a href="mailto: <?= $agent->agent_email; ?>"><i class="fa fa-envelope-o"></i> Email</a></span>
							<span class="divider-border"></span> 
							<span class="phone"><a href="tel: <?= $agent->agent_phone; ?>"><?= $agent->agent_phone; ?></a></span>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

		</div>
	</div>
</div> <!-- agent gellary ending tag -->

<!-- apply area start -->
<div class="apply-area apply-area-padding overflow-hidden">
	<div class="container">
		<div class="apply-area-inner text-center">
			<span class="heading">Recruitment message can go here.</span>
			<span><a href="" class="cmn-btn apply-cmn-btn">Apply</a></span>
		</div>
	</div>
</div> <!-- apply area ending tag  -->

<?php get_footer(); ?>




############################################################################################################################################
############################################################################################################################################
######################################################################
###################################### 					 Agent Experience									################################
############################################################################################################################################
############################################################################################################################################
############################################################################################################################################
<?php 
/**
 * Template Name: Agent Experience
 **/
get_header('custom'); ?>
<style>
.agent-experience-hero-section{
	background-image: url(<?= get_the_post_thumbnail_url($post->ID, 'full'); ?>); 
}
</style>
<div class="pt-92"></div>
<!-- hero area start -->
<div class="agent-experience-hero-section overflow-hidden">
	<div class="container">
		<div class="about-hero-display-table">
			<div class="about-hero-agent-content text-center">
				<h1><?= get_field('title'); ?></h1>
				<p><?= get_field('content'); ?></p>
				<a href="<?= get_field('content_url'); ?>" class="cmn-btn">Connect With an Agent</a>
			</div>
		</div>
	</div>
</div> <!-- hero area ending tag-->

<!-- testimonial area start -->
<div class="testimonial-area overflow-hidden">
	<div class="container">
		<div class="row">

		<!-- USING AFC REPEATER  -->
			<div class="col-md-10 col-md-offset-1">
				<div class="testimonial-slider-wrapper">
					<?php if(get_field('slider')): ?>
						<?php while(has_sub_field('slider')): ?>
					<div class="single-testimonial">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="testimonial-auth-img">
									<img src="<?php the_sub_field('slider_image'); ?>" alt="" />
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="testi-content">
									<h2><?= get_sub_field('slider_title'); ?></h2>
									<p><?= get_sub_field('slider_subtitle'); ?></p>
									<div class="auth-name text-right"><span>-</span><?= get_sub_field('slider_name'); ?></div>
								</div>
							</div>
	
						</div>
						
					</div>
						<?php endwhile; ?>
					<?php endif; ?>
<!-- 
					<div class="single-testimonial">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="testimonial-auth-img">
									<img src="<?php echo OP_ASSETSURL."images/testimonial-auth.jpg"?>" alt="">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="testi-content">
									<h2>Scout Real Estate Agent Testimonials</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
									<div class="auth-name text-right"><span>-</span>James Smith</div>
								</div>
							</div>
						</div>
					</div>
-->

				</div>
			</div>

		</div>
	</div>
</div> <!-- testimonial ending tag -->

<!-- video section start -->
<div class="video-section video-section-full-width">
	<div class="container">
		<div class="video-section-wrapper">
			<div class="video-top-ttl text-center">
				<div class="heading-wrapper">
					<h3><?= the_field('video_title')?></h3>
					<p><?= the_field('video_subtitle')?></p>
				</div>
			</div>
			<div class="heading-wrapper">
					<div class="video-play text-center" style="background-image: url(<?= get_field('video_image')['url'] ;?>)">
					<div class="vd-table-cell">
						<a class="mfp-iframe video-play-btn" href="<?= the_field('video_link');?>"><i class="fa fa-play"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- video section ending tag -->

<!-- tab area -->
<div class="tablisting-area">
	<div class="container">
		<div class="video-top-ttl text-center">
			<div class="heading-wrapper">
				<h3><?= the_field('video_title')?></h3>
				<p><?= the_field('video_subtitle')?></p>
			</div>
		</div>
		<div class="tab-section">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/contact.png"?>" alt="">Contact</a></li>
				<li role="presentation"><a href="#listing" aria-controls="listing" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/listing.png"?>" alt="">listing</a></li>
				<li role="presentation"><a href="#marketing" aria-controls="marketing" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/marketing.png"?>" alt="">marketing</a></li>
				<li role="presentation"><a href="#photoVideo" aria-controls="photoVideo" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/photo.png"?>" alt="">Photo Video</a></li>
				<li role="presentation"><a href="#support" aria-controls="support" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/support.png"?>" alt="">support</a></li>
				<li role="presentation"><a href="#training" aria-controls="training" role="tab" data-toggle="tab"><img src="<?php echo OP_ASSETSURL."images/training.png"?>" alt="">training</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="contact">
					<div class="tab-item-content-wrapper">
						<?= get_field('contact'); ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="listing">
					<div class="tab-item-content-wrapper">
						<?= get_field('listing'); ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="marketing">
					<div class="tab-item-content-wrapper">
						<?= get_field('marketing'); ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="photoVideo">
					<div class="tab-item-content-wrapper">
						<?= get_field('photo_video'); ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="support">
					<div class="tab-item-content-wrapper">
						<?= get_field('support'); ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="training">
					<div class="tab-item-content-wrapper">
						<?= get_field('training'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- tab area ending tag -->

<!-- accordion section -->
<div class="collaps-section">
	<div class="container">
		
	</div>
</div> <!-- accordion section ending tag -->

<!-- apply area start -->
<div class="apply-area apply-area-padding overflow-hidden">
	<div class="container">
		<div class="apply-area-inner text-center">
			<span class="heading">Recruitment message can go here.</span>
			<span><a href="" class="cmn-btn apply-cmn-btn">Apply</a></span>
		</div>
	</div>
</div> <!-- apply area ending tag  -->
<?php get_footer(); ?>