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

  function deleteToCart(idItem, type) {
    $.ajax({
      type: 'POST',
      url: 'ajax/add_to_cart.php',
      data: {
        id_item: idItem,
        type: type,
        delete: true,
      },
      success: function (html) {
        $('.mini-cart').html(html);
        // $('.cart-button').toggleClass('cart-button_active'); 
        // $('.mini-cart').toggleClass('mini-cart_active');
      }
    });
  }

  function search(request, type) {
    $.ajax({
      type: 'POST',
      url: 'ajax/search.php',
      data: {
        search: request,
        type: type
      },
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
      $('.header_wrapp').addClass('header_fixed');
    } else {
      $('.header_wrapp').removeClass('header_fixed');
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

  $('.sales-block').on('click', '.item .add-to-cart', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
    addToCart(id, type);
  });

  $('.main-content').on('click', '.item .add-to-cart', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
    addToCart(id, type);
  });

  $('.main-content').on('click', '.item-list .add-to-cart', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
    addToCart(id, type);
  });

  $('.containing-item').on('click', '.item .add-to-cart', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
    addToCart(id, type);
  });

  $('.mini-cart').on('click', '.delete button', function (event) {
    event.preventDefault();
    id = $(this).attr('data-id');
    type = $(this).attr('data-type');
    deleteToCart(id, type);
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
    search(value, typeSearch);
  });

  $('.search .choice .search-choice').click(function (e) { 
    e.preventDefault();
    window.typeSearch = $(this).attr('data-type');
    $(this).parents('.choice').remove();
  });

  //Мобильное меню
  $('.mobile-menu .additional-menu_link a').click(function (e) { 
    
    if ( $(this).parent('li').hasClass('additional-menu_link') ) {
      e.preventDefault();
      $(this).parent('.additional-menu_link').toggleClass('li_active');
      $(this).parent('.additional-menu_link').children('.wrapp').toggleClass('active');
    }

  });

  $('.menu-button').click(function (e) { 
    e.preventDefault();
    $(this).toggleClass('menu-button_active');
    $('.mobile-menu').toggleClass('mobile-menu_active');
  });
  
});