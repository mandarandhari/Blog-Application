$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function() {
  $(document).on('change', '#category-filter', function() {
    if ($(this).find('option:selected').val() !== '') {
      $('#category-filter-form').submit();
    }
  });

  $(document).on('click', '.delete-post-btn', function(e) {
    $('#delete-post-form').attr('action', $(this).attr('data-href'));
  });
});