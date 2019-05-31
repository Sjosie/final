$(function() {

  function addToCart(idItem, countItem, type) {
    type = type || 'default';
    $.ajax({
      type: 'POST',
      url: 'ajax/add_to_cart.php',
      data: 'id_item=' + idItem,
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

  function deleteToCart(idItem) {
    $.ajax({
      type: 'POST',
      url: 'ajax/add_to_cart.php',
      data: {
        id_item: idItem,
        delete: true,
      },
      success: function (html) {
        $('.mini-cart').html(html);
        // $('.cart-button').toggleClass('cart-button_active'); 
        // $('.mini-cart').toggleClass('mini-cart_active');
      }
    });
  }
  
  function search(request) {
    $.ajax({
      type: 'POST',
      url: 'ajax/search.php',
      data: {search: request},
      success: function (html) {
        $('.search').html(html);
      }
    });
  }

  function getBanner(idCategory) {
    $.ajax({
      type: 'POST',
      url: 'ajax/show_menu_banners.php',
      data: {id_category_banners: idCategory},
      success: function (banner) {

        if (banner) {
          $('.menu_ul .wrapp[data-id="' + idCategory + '"]').addClass('has_banner').append(banner);
        }

      }
    });
  }

  $(window).scroll(function () { 

    if ( $(this).scrollTop() > 150 ) {
      $('.header').addClass('header_fixed');
    } else {
      $('.header').removeClass('header_fixed');
    }

    if ( $('.mobile-menu').hasClass('mobile-menu_active') ) {
      return false
    }
    
  });


  //Загрузка баннеров в меню
  for ( k = 0; k < $('.menu_ul > .additional-menu_link').length; k++) {
    idCategory = $('.menu_ul > .additional-menu_link').eq(k).children('.wrapp').attr('data-id');
    getBanner(idCategory);
  }

  //Мобильное меню
  $('.mobile-menu .additional-menu_link a').click(function (e) { 
    e.preventDefault();
    $(this).parent('.additional-menu_link').toggleClass('li_active')
    $(this).parent('.additional-menu_link').children('.wrapp').toggleClass('active');
  });
  $('.menu-button').click(function (e) { 
    e.preventDefault();
    $(this).toggleClass('menu-button_active');
    $('.mobile-menu').toggleClass('mobile-menu_active');
  });

  //Cart
  $('.cart-button').click(function () { 
    $(this).toggleClass('cart-button_active');    
    $('.mini-cart').toggleClass('mini-cart_active');
  });
  $('.mini-cart').hover(function () {

    }, function () {
      $('.cart-button').toggleClass('cart-button_active'); 
      $('.mini-cart').toggleClass('mini-cart_active');
    }
  );

  $('.mini-cart').on('click', '.delete button', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    deleteToCart(id);
  });

  $('.add-to-cart').click(function (e) { 
    e.preventDefault();
    idItem = $(this).attr('href');
    var countItem = $('.main-info .wrapp .links .input_wrapp input').val();
    countItem = parseInt(countItem);
    var type = $('.info .type a').attr('data-type');
    alert(type);
    addToCart(idItem, countItem, type);
  });
  //Search
  $('.search-button').click(function () { 
    $(this).toggleClass('search-button_active');    
    $('.search').toggleClass('search_active');
  });
  $('.search').hover(function () {

    }, function () {
      $('.search-button').toggleClass('search-button_active'); 
      $('.search').toggleClass('search_active');
    }
  );

  $('.search').on('click', '.search-form-button', function (event) {
    event.preventDefault();
    value = $('.search form input').val();
    search(value);
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