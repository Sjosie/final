$(function() {

  function addToCart(idItem, type, countItem) {
    type = type || 'default';
    countItem = countItem || 1;
    $.ajax({
      type: 'POST',
      url: 'ajax/add_to_cart.php',
      data: {
        id_item: idItem,
        type: type,
        count: countItem
      },
      success: function (html) {       
        $('.mini-cart').html(html);
      }
    });
  }

  $('.add-to-cart-wish-count').click(function (e) { 
    e.preventDefault();
    idItem = $(this).attr('href');
    var countItem = $('.main-info .wrapp .links .input_wrapp input').val();
    countItem = parseInt(countItem);
    var type = $('.info .type a').attr('data-type');
    addToCart(idItem, type, countItem);
  });

  $('.input_wrapp .button_wrapp button').click(function (e) { 
    e.preventDefault();
    var value = $(this).parents('.input_wrapp').children('input').val();

    if ( !value ) {
      
      value = 1;

    } else {

      value = +value;

      if ( $(this).hasClass('plus') ) {
        value++;
      } else if ( $(this).hasClass('minus') ) {
        if ( value > 1) {
          value--;
        }
      }

    }

    $(this).parents('.input_wrapp').children('input').attr('value', value);

  });

  var height = $('.main-info .wrapp').height();
  $('.main-info .img_wrapp img').css('max-height', height);

  //Tabs
  $('#item-tabs').tabs();

});