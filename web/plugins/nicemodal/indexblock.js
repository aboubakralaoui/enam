$(document).ready(function() {
  $('.toggleModal').on('click', function(e) {
    $('body').toggleClass('prevent');
    $('.modalblock').toggleClass('active');
  });
});