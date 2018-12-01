<?php
/**
 * Dashboard page template
 *
 * @package reimari
 */
get_header(); ?>

	<main class="container-fluid" id="main">
        <div class="container">
          <div class="row"">
            <div class="col-md-12">
            	<h2>Dashboard</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
            <div class="row dashboard__sort_buttons">
            <?php
              // Example array of button text (requires Font Awesome)
              $buttonArray = ["<i class='far fa-smile-beam'></i> Joy", "<i class='far fa-sad-tear'></i> Sad",
		"<i class='far fa-thumbs-up'></i> Like", "<i class='far fa-thumbs-down'></i> Dislike"];
              for ($i=0; $i<count($buttonArray); $i++) {
                ?>
                <button class="dashboard__sort_buttons__button" data-id="<?php echo $i+1 ?>">
			<?php echo $buttonArray[$i] ?>
		</button>
                <?php
              }
            ?>
            </div>
            <div id="dashboard">
              <?php
              $myImagesDir = get_bloginfo('url').'/wordpress/wp-content/themes/reimari/images/';
              $the_query = new WP_Query( array('posts_per_page' => 20, 'cat' => 5,
								'orderby' => 'date', 'order' => 'DESC' ) );
              $metaArray = [];
            while ($the_query -> have_posts()) : $the_query -> the_post();
            $post_id = get_the_ID();
            ?>
            <div class="row dashboard">
              <div class="dashboard__image">
                <?php
                  if (has_post_thumbnail()) {
                    the_post_thumbnail(array(200, 100));
                  } else {
                  ?>
                    <img src="<?php echo $myImagesDir ?>default.jpg" />
                  <?php
                  }
                  ?>
              </div>
              <div class="dashboard__content">
                <div class="dashboard__content__title">
                  <?php the_title(); ?>
                </div>
                <div class="dashboard__content__author">
                  <?php the_author(); echo " (post id: " . $post_id . ")" ?>
                </div>
                <div class="dashboard__content__ratings">
                  <?php
                    $metaArray_JSON = get_post_meta($post->ID, "emoteButton", true);
                    $metaArray = json_decode($metaArray_JSON, true);
                    createEmoteButtonBar($post_id, $metaArray, $buttonArray);
                  ?>

                </div>
              </div>
            </div>
            <?php
              endwhile;
            ?>
            </div>
            </div>
          </div>
        </div><!-- /.container -->
    </main>
    <?php get_footer(); ?>
