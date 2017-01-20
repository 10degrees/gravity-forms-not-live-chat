jQuery(document).ready(function ($) {

  // Make it a click-to-call
  if ($(window).width() < 480) {

    $(".tend_nlc_chat").on('click', function () {
      $('a.tend_nlc_chat_content_call')[0].click();
    });

  // Otherwise show the form
  } else {

    $('.tend_nlc_chat_icon').click(function () {
      $(this).hide();
      $('.tend_nlc_chat_content').slideToggle("slow");
      $(".tend_nlc_chat").addClass('open');

    });

  }

  // Hide modal on close icon click
  $('.tend_nlc_chat_close').click(function () {
    $('.tend_nlc_chat_content').slideToggle("slow", function () {
      $('.tend_nlc_chat_icon').show();
    });
    $(".tend_nlc_chat").removeClass('open');
  });

  // Hide the modal if there's a click on another part of the page
  $(document).mouseup(function (e) {
		var container = $('.tend_nlc_chat');
		if (!container.is(e.target) && container.has(e.target).length === 0) // nor a descendant of the container
		{
			$('.tend_nlc_chat_content').slideToggle("slow", function () {
        $('.tend_nlc_chat_icon').show();
      });
      $(".tend_nlc_chat").removeClass('open');
		}
	});

});
