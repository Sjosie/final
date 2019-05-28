$(function() {

  var coordinate = $('#map').attr('data-coordinate').split(',');

  ymaps.ready(init);    
  function init(){ 
    var myMap = new ymaps.Map("map", {
        center: coordinate,
        zoom: 16
    }); 

    var glyphIcon1 = new ymaps.Placemark(coordinate, {
      balloonContent: 'Text....',
      iconCaption: 'Text...'
    }, {         
      iconCaption: "Диаграмма",
      iconColor: '#00a7dd'
    });
    
    
    myMap.geoObjects
      .add(glyphIcon1)

    myMap.behaviors
      .disable('scrollZoom')
  }

  $('.feedback').submit(function (e) { 
    e.preventDefault();
    var name = $(this).find('input[name="name"]').val();
    var email = $(this).find('input[name="email"]').val();;
    var phone = $(this).find('input[name="phone"]').val();;
    var msg = $(this).find('textarea[name="massage"]').val();
    $.ajax({
      type: 'POST',
      url: 'ajax/mailto.php',
      data: {
        name: name,
        email: email,
        phone: phone,
        msg: msg
      },
      success: function (response) {
        $('.feedback').children('.row').animate({
          opacity: 0
        });
        $('.feedback').append('<div class="response">' + response + '</div>');
      }
    });
  });

});