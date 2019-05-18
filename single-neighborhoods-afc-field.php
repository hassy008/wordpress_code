<?php get_header('custom'); ?>
<div class="pt-92"></div>

<!-- Hero section start -->
 <div class="neighborhoods-common-hero overflow-hidden" style="background-image: url(<?= get_the_post_thumbnail_url($post->ID, 'full'); ?>);">
	<!-- <div class="neighborhoods-common-hero overflow-hidden" style="background-image: url(/wp-content/plugins/opcodespace/assets/images/neighborhoods_hero_img.jpg);"> -->
	<div class="container">
		<div class="common-hero-inner">
			<div class="common-hero-content-wrapper">
				<h1><?php the_title(); ?></h1>
<!-- 				<h1>THE GULCH</h1> -->
			</div>
		</div>
	</div>
</div> <!-- Hero section ending tag -->

<!-- content wrapper section -->
<div class="content-wrapper-section overflow-hidden">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				<div class="content-wrapper-content text-center">
					<!-- <h1>The Vibrant Gulch</h1> -->
					<h1><?= get_field('features_title'); ?></h1>
					<p><?= get_field('features_content'); ?></p>
					<!-- <p>The Gulch is a dynamic neighborhood located on the edge of Nashville's central business district. The neighborhood is a popular restaurant, shopping and entertainment  destination consisting of a unique mix of local and national retailers, authentic music venues, and a locally owned natural food market.</p>-->
				</div>
			</div>
		</div>
	</div>
</div><!-- content wrapper section ending tag -->

<!-- Vibrant Gulch Section start-->
<div class="vibrant-gulch-section overflow-hidden">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6 border-right">
				<div class="single-gulch-section ">
					<div class="circle-img text-center">
						<img src="<?= get_field('col_1_img'); ?>" alt="">
					</div>
					<div class="single-gulch-content">
						<h3><?= get_field('col_1_title'); ?></h3>
						<p><?= get_field('col_1_content'); ?></p>
						<?php if(get_field('col_1_point')): ?>
							<ul>
							<?php while(has_sub_field('col_1_point')): ?>
								<li><?php the_sub_field('col_1_repeter'); ?></li>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>

					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 border-right">
				<div class="single-gulch-section ">
					<div class="circle-img text-center">
						<img src="<?= get_field('col_2_img')['url']; ?>" alt="">
					</div>
					<div class="single-gulch-content">
						<h3><?= get_field('col_2_title'); ?></h3>
						<p><?= get_field('col_2_content'); ?></p>
						<?php if(get_field('col_2_point')): ?>
							<ul>
							<?php while(has_sub_field('col_2_point')): ?>
								<li><?php the_sub_field('col_2_repeter'); ?></li>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="single-gulch-section">
					<div class="circle-img text-center">
						<img src="<?= get_field('col_3_img')['url']; ?>" alt="">
					</div>
					<div class="single-gulch-content">
						<h3><?= get_field('col_3_title'); ?></h3>
						<p><?= get_field('col_3_content'); ?></p>

						<?php if(get_field('col_3_point')): ?>
							<ul>
							<?php while(has_sub_field('col_3_point')): ?>
								<li><?php the_sub_field('col_3_repeter'); ?></li>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- Vibrant Gulch Section ending tag -->

<!-- <div class="map overflow-hidden" style="background-image: url(<?= get_field('map')['url'];?>);"></div> -->

<?php if (!empty(get_field('map'))): ?>

<div class="">
	<iframe src="<?= get_field('map');?>" width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<?php endif ?>
<!-- black-bg section start -->
<div class="black-bg-wrapper overflow-hidden">
	<div class="content-wrapper-section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
					<div class="content-wrapper-content text-center">
						<h1><?= get_field('commute_title'); ?></h1>
						<p><?= get_field('commute_content'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="count-down-section">

			<?php if(get_field('times')): ?>
				<?php while(has_sub_field('times')): ?>
			<div class="single-count-down text-center">
				<div class="count-ttl"><?php the_sub_field('location'); ?></div>
				<div class="counter"><?php the_sub_field('minute'); ?></div>
				<div class="time">Minutes</div>
			</div>
			<?php endwhile; ?>
			<?php endif; ?>

		</div>
	</div>
</div><!-- Black bg ending tag -->

<!-- content wrapper section -->
<div class="content-wrapper-section overflow-hidden">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				<div class="content-wrapper-content text-center">
					<h1><?= get_field('neighborhood_title'); ?></h1>
					<p><?= get_field('neighborhood_content'); ?></p>
				</div>
			</div>
		</div>
	</div>
</div><!-- content wrapper section ending tag -->

<!-- Close neighborhoods section start -->
<div class="close-neighborhoods-section overflow-hidden">
	<div class="container">
		<div class="row">


			<div class="col-md-3 col-sm-6">
				<div class="single-neighborhood">
					<img src="<?php echo OP_ASSETSURL."images/long_img1.jpg"?>" alt="">
					<div class="neighborhood-ttl">
						<h3>Downtown <span>Trendy & Walkable</span></h3>
						<a href="" class="neighborhood-btn">Learn More</a>
					</div>
				</div>
			</div>


			<div class="col-md-3 col-sm-6">
				<div class="single-neighborhood">
					<img src="<?php echo OP_ASSETSURL."images/long_img2.jpg"?>" alt="">
					<div class="neighborhood-ttl">
						<h3>Edgehill & Music Row<span>Eccentric and Hip</span></h3>
						<a href="" class="neighborhood-btn">Learn More</a>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="single-neighborhood">
					<img src="<?php echo OP_ASSETSURL."images/long_img3.jpg"?>" alt="">
					<div class="neighborhood-ttl">
						<h3>Germantown<span>Trendy & Walkable</span></h3>
						<a href="" class="neighborhood-btn">Learn More</a>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="single-neighborhood">
					<img src="<?php echo OP_ASSETSURL."images/long_img4.jpg"?>" alt="">
					<div class="neighborhood-ttl">
						<h3>Green Hills <span>Eccentric and Hip</span></h3>
						<a href="" class="neighborhood-btn">Learn More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- Close neighborhoods section ending tag -->

<div class="neighborhoods-btn text-center overflow-hidden">
	<a href="/neighborhoods" class="cmn-btn">More Neighborhoods</a>
</div>

<?php get_footer('custom'); ?>
