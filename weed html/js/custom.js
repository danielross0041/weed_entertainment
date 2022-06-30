$('#y-tube-slider').owlCarousel({
  loop: false,
  margin: 10,
  nav: true,
  dots: true,
  // autoplay: true,
  // autoplaySpeed: 5000,
  // autoplayTimeout: 5000,
  autoplayHoverPause: true,
  dotsData: true,
  smartSpeed: 1000,
  margin: 0,
  navText: [
    '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
    '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>'
  ],
  responsiveClass: true,
  responsive: {
    0: {
      items: 1
    },
    575: {
      items: 1
    },
    767: {
      items: 1
    },
    991: {
      items: 1
    },
    1199: {
      items: 1
    },
    1399: {
      items: 1
    }
  }
});







$(document).ready(function(){

  $('.moreinfo').hide();
$('.more').click(function (ev) {
  var t = ev.target
  $('#info' + $(this).attr('target')).toggle(500, function () {
    console.log(ev.target)
    $(t).html($(this).is(':visible') ? 'show less' : 'show more')
  });
  return false;
});

});

// $('.reply').click(function(){
//   $(this).next('.user_reply').slideToggle(); 
  
  
// });

// $('.first-p').hide();  
// $(".reply").click(function(){
//   $(".user_reply").slideDown();
// });

$('.user_reply').hide(); 
$(document).ready(function(){
  $(".reply").click(function(){
    $(this).next(".user_reply").slideToggle(300);
  });
});


$('.all-replies').hide(); 
$(document).ready(function(){
  $(".reply-all-anchor").click(function(){
    $(this).next(".all-replies").slideToggle(300);
  });
});



