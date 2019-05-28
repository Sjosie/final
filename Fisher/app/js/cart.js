$(function() {

  function recalculationCartTable() {
    $.ajax({
      type: 'POST',
      url: 'ajax/recalculation-cart-table.php',
      success: function (html) {
        $('.record .wrapp').html(html);
      }
    });  
  }

  $('.input_wrapp .button_wrapp button').click(function (e) { 
    e.preventDefault();
    var value = $(this).parents('.input_wrapp').children('input').val();
    var id = $(this).parents('tr').children('.td_products').children('.item-cart').attr('data-id');

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

    $.ajax({
      type: 'POST',
      url: 'ajax/cart-show.php',
      data: {
        id_item: id,
        count: value
      },
      success: function (price) {
        $('.item-cart[data-id="'+ id +'"]').parents('tr').find('.total-price').children('span.value').html(price);
        $('.item-cart[data-id="'+ id +'"]').parents('tr').find('.input_wrapp').children('input').attr('value', value);

        recalculationCartTable();
      }
    });
    
  });
  
  $('.input_wrapp input[type="number"]').change(function (e) { 
    e.preventDefault();
    var value = $(this).parents('.input_wrapp').children('input').val();
    var id = $(this).parents('tr').children('.td_products').children('.item-cart').attr('data-id');

    if ( value != 0 && value >= 0 ) {
      
      $.ajax({
        type: 'POST',
        url: 'ajax/cart-show.php',
        data: {
          id_item: id,
          count: value
        },
        success: function (price) {
          $('.item-cart[data-id="'+ id +'"]').parents('tr').find('.total-price').children('span.value').html(price);
          $('.item-cart[data-id="'+ id +'"]').parents('tr').find('.input_wrapp').children('input').attr('value', value);

          recalculationCartTable();
        }
      });

    }
    
  });

  $('.delete button').click(function (e) { 
    e.preventDefault();
    var id = $(this).attr('data-id');
    
    $.ajax({
      type: 'POST',
      url: 'ajax/cart-show.php',
      data: {
        id_item: id,
        type: $(this).attr('data-type'),
        delete: true
      },
      success: function () {

        if ( $('.item-cart[data-id="'+ id +'"]').parents('tbody').children().length == 1 ) {
          $('.item-cart[data-id="'+ id +'"]').parents('.container').remove();
        } else {
          $('.item-cart[data-id="'+ id +'"]').parents('tr').remove();
        }

        recalculationCartTable();

      }

    });
    
  });

  //Popup
  $('.popup-with-form').magnificPopup({
    type: 'inline',
    focus: '#form-popup'
  }); 

  $('.mail-to').click(function (e) { 
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'ajax/mail.php',
      data: {
        phone: $('#form-popup input#phone').val(),
        email: $('#form-popup input#email').val(),
        msg: $('#form-popup textarea#mg').val()
      },
      success: function (html) {
        $('#form-popup form').html(html);
      }
    });
  });

});