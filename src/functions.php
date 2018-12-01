<?php
function emoteButton_scripts() {
    wp_enqueue_script(
        'emoteButton',
        get_template_directory_uri() . "/js/emoteButton.js",
        array('jquery'),
        '1.0',
        true
    );
    $translation_array = array('templateUrl' => admin_url('admin-ajax.php'));
    wp_localize_script( 'emoteButton', 'emoteButton', $translation_array );
}
add_action( 'wp_enqueue_scripts', 'emoteButton_scripts' );
add_action( 'wp_enqueue_scripts', 'start_scripts' );
add_action( 'wp_ajax_emoteButton', 'emoteButton_handleAjax' );
add_action( 'wp_ajax_nopriv_emoteButton', 'emoteButton_handleAjax' );

function emoteButton_handleAjax() {
    /** set for 4 example buttons (these are used to update the metapost data in WP database)
     *  this can be replaced by sending the buttons as GET data but would make database
     *  entries ugly - if number of buttons change - this needs to change to reflect that!!!
     */
    $buttons = ["Joy", "Sad", "Like", "Dislike"];
    $new_num_upvotes = array();
    $post_id = intval($_GET['post_id']);
    $id = intval($_GET['button_id']);
    $num_upvotes_JSON = get_post_meta( $post_id, "emoteButton", true );
    $num_upvotes = json_decode($num_upvotes_JSON, true);
    for ($i=0; $i<count($buttons); $i++) {
        if (!isset($num_upvotes[$buttons[$i]])) {
            $num_upvotes[$buttons[$i]] = "0";
        }
    }
    $num_upvotes[$buttons[$id-1]] = (string)(intval( $num_upvotes[$buttons[$id-1]] ) + 1);
    $num_upvotes_JSON = json_encode($num_upvotes);
    $success = update_post_meta( $post_id, "emoteButton", $num_upvotes_JSON );
    if ( $success ) {
    $response = array(
      'result' => 'successful',
      'votes' => $num_upvotes[$buttons[$id-1]]
    );
  } else {
    $response = array(
      'result' => 'successful',
      'votes' => $num_upvotes[$buttons[$id-1]]-1
    );
  }
  wp_send_json( $response );
}

/**
 * Function to create custom emoteBUtton bars
 */
function createEmoteButtonBar($post_id, $metaArray, $buttonArray) {
  ?>
    <div class="emoteButtons" data-postid="<?php echo $post_id ?>" id="<?php echo $post_id ?>">
  <?php
    for ($i=0; $i<count($buttonArray); $i++) {
        $pieces = explode("/i> ", $buttonArray[$i]);
        ?>
        <div class="emoteButtons__buttonContainer">
            <button data-votes="<?php echo $metaArray[$pieces[1]]; ?>" data-id="<?php echo $i+1 ?>"><?php echo $buttonArray[$i] ?>
            <span><?php if($metaArray[$pieces[1]]) { echo $metaArray[$pieces[1]]; } else echo "0" ?></span></button>
        </div>
  <?php } ?>
    </div>
  <?php
}
?>
