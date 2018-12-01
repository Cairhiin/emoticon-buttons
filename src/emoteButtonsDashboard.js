var $ = jQuery;

function sortColumn(id, data, el) {
  // sort the data by emoteButton id and reappend it to it's parent
  data.sort(function(a, b) {
    const $elementToSort = $(this);
    const votesB = $(`[data-id=${id}] > span`, b).text();
    const votesA = $(`[data-id=${id}] > span`, a).text();
    return votesB-votesA;
  });
  data.detach().appendTo(el);
}

$(document).ready(function() {
  $('.dashboard__sort_buttons__button').click(function(){
    $(this).addClass('sorted_by');
    $(this).siblings().removeClass('sorted_by');
    const id = $(this).data('id');
    const $dataToSort = $('.row.dashboard');
    const $dashboard = $('#dashboard');
    sortColumn(id, $dataToSort, $dashboard);
  });
});
