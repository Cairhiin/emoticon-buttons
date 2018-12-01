var $ = jQuery;
var templateUrl = emoteButton.templateUrl;

$(document).ready(function() {

function formatVotedEmoteButtons($buttons, buttonId) {
  $.each($buttons, function(index, button) {
    $(this).hover(function() {
      $(this).css('cursor','default');
    });
    $(this).unbind('click');
    if (index != buttonId - 1) {
      $(this).addClass('unvoted');
    }
   });
}

const $post = $('.emoteButtons');
$.each($post, function(index, button) {
  postId = $(this).attr('id');
  let $buttons = $(this).children().children();
  if (sessionStorage.getItem(postId) !== null) {
    let voteOption = sessionStorage.getItem(postId);
    // Make buttons unclickable and format their look
    formatVotedEmoteButtons($buttons, voteOption);
    let button = $buttons[voteOption-1];
    let $button = $(button);
    $button.addClass('voted');
  } else {
    for (let i=0; i<$(this).children().length; i++) {
      $($buttons[i]).click(function(){
      const buttonData = $(this).data('votes');
      const buttonId = $(this).data('id');
      postId = $(this).parent().parent().attr('id');
      const self = $(this);
      const $buttonGroup = $('button', self.parent().parent());

        $.ajax({
              url: emoteButton.templateUrl,
              data : { action: "emoteButton", post_id : postId, button_id : buttonId },
              success: function(res) {
                sessionStorage.setItem(postId, buttonId);
                $('button', $buttonGroup).unbind('click');
                self.children(":nth-child(2)").text(res.votes);
                self.data('votes', res.votes);
                self.addClass('voted');
                formatVotedEmoteButtons($buttonGroup, buttonId);
              },
          });
        });
      }
    }
  });
});
