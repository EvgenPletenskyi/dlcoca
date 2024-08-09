<?php
/* Template Name: Home Template */
?>
<?php get_header(); ?>

<?php
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_button = get_field('hero_button');
$hero_speech_bubbles = get_field('hero_speech_bubbles');
$hero_dedcoca = get_field('hero_dedcoca');

$presents_section_background_image = get_field('presents_section_background_image');
$presents_section_title = get_field('presents_section_title');
$presents_section_subtitle = get_field('presents_section_subtitle');


$form_section_background_image = get_field('form_section_background_image');
$form_section_title = get_field('form_section_title');
$form_shortcode = get_field('form_shortcode');


$snowflake = get_field('snowflake', 'options');
?>

	<div class="swiper-container">
		<div class="swiper-wrapper">

			<!-- START HERO SECTION -->
			<section class="hero swiper-slide">
				<div class="container hero-text-block">
					<div class="hero__tite">
                        <?php if ($hero_title): ?>
							<h2><?php echo $hero_title ?></h2>
                        <?php endif; ?>
					</div>
					<div class="hero__description">
                        <?php if ($hero_subtitle) : ?>
							<p><?php echo $hero_subtitle; ?></p>
                        <?php endif; ?>
					</div>
                    <?php if ($hero_button) : ?>
						<div class="hero__button-container">
							<a href="<?php echo $hero_button['url'] ?>" target="<?php echo $hero_button['target'] ?>">
								<button class="button"><?php echo $hero_button['title'] ?></button>
							</a>
						</div>
                    <?php endif; ?>
				</div>
                <?php if ($hero_speech_bubbles || $hero_dedcoca) : ?>
					<div class="hero__dedcoca-container">
                        <?php if ($hero_speech_bubbles): ?>
							<div class="speech-bubbles hide-for-small-screen">
								<p>How how how !!! <br>
								   Like it? <br>
								   Scroll down for more !
								</p>
							</div>
                        <?php endif; ?>
                        <?php if ($hero_dedcoca):
                            $hero_dedcoca_alt = get_post_meta($hero_dedcoca, '_wp_attachment_image_alt', true);
                            ?>
                            <?php echo wp_get_attachment_image($hero_dedcoca, 'full', false, array('class' => 'dedcoca', 'alt' => '<?php echo $hero_dedcoca_alt?>')); ?>
                        <?php endif; ?>
					</div>
                <?php endif; ?>
			</section>
			<!-- END HERO SECTION -->

			<!-- START PRESENT SECTION -->
			<section class="present swiper-slide" style="background-image: url('<?php echo $presents_section_background_image; ?>')">
				<div class="container">
					<div class="present-wrapper ">
						<div class="present-text-block">
                            <?php if ($presents_section_title): ?>
								<h3 class="present__tite">
                                    <?php echo $presents_section_title; ?>
								</h3>
                            <?php endif; ?>
							<div class="present__description">
                                <?php if ($presents_section_subtitle): ?>
									<p class="present__description"><?php echo $presents_section_subtitle; ?></p>
                                <?php endif; ?>
							</div>
							<div class="present__choices">
								<?php
                                if( have_rows('presents') ):
									$counter = 0;
                                    while( have_rows('presents') ) : the_row();
									$counter++;
                                        $present_image = get_sub_field('present_image');
                                        $present_title = get_sub_field('present_title');
                                        $present_description = get_sub_field('present_description');
                                       ?>
										<div class="item <?php echo ($counter == 1 ) ? 'active' : null ?>" data-title="<?php echo $present_title; ?>" data-description="<?php echo $present_description;?>" data-image="<?php echo $present_image;?>">
											<img src="<?php echo $present_image?>">
										</div>
									<?php
                                    endwhile;
                                endif;
								?>
							</div>
						</div>
						<div class="present__full-info">
							<img id="present-image" src="">
							<div>
								<h4 id="present-title">
								</h4>
								<p id="present-description">
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- END PRESENT SECTION -->

			<!-- START FORM SECTION -->
			<section class="form swiper-slide" style="background-image: url('<?php echo $form_section_background_image; ?>')">
				<div class="container">
                    <?php if ($form_section_title): ?>
						<h3 class="form__title">
                            <?php echo $form_section_title; ?>
						</h3>
                    <?php endif; ?>
                    <?php echo $form_shortcode;?>
				</div>
			</section>
			<!-- END FORM SECTION -->
		</div>
		<div class="pixi-canvas"></div>
		<!-- START SNOWFLAKE -->
        <?php if ($snowflake): ?>
			<div class="snowflake-container" data-swiper-parallax-y="-600">
				<div class="snowflake" style="background-image: url('<?php echo $snowflake; ?>');"></div>
			</div>
        <?php endif; ?>
		<!-- END SNOWFLAKE -->
	</div>
<?php get_footer(); ?>