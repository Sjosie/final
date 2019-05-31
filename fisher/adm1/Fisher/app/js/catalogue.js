$(function() {

  /*
    - Кнопка вывода по цене
  */
  function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
  } 

  function sliderSettings(maxPrice) {
    return {
      range: true,
      min: 0,
      max: maxPrice,
      values: [ 1, maxPrice ],
      slide: function( event, ui ) {
        if (ui.values[ 0 ] == 0) {
          ui.values[ 0 ] = 1;
        }
        $('#slider-range').attr('data-left-limit', ui.values[ 0 ]).attr('data-right-limit', ui.values[ 1 ]);
        $( '#amount' ).val( 'Цена: ' + ui.values[ 0 ] + ' руб.' + ' - ' + ui.values[ 1 ] + ' руб.');
      }
    }
  }

  function ajaxItemsLoad(outputType, sort, countItems, page, leftLimit, rightLimit) {
    outputType = outputType || 'grid';
    countItems = countItems || '15';
    sort       = sort || 'product_name';
    page       = page || '1';
    // if ( !get('page') ) {
    //   page = 1;
    // } else {
    //   page = get('page');
    // }
    type = $('.content_wrapp > ul > li > a').text();
    type = type.toLowerCase();
    if ( type == 'прокат') {
      type = 'rent';
    } else {
      type = 'default'
    }

    $.ajax({
      type: 'POST',
      url: 'ajax/catalogue-show.php',
      data: {
        id_category: get('id'),
        output_type: outputType,
        count_items: countItems,
        sort: sort,
        type: type,
        page: page,
        id_brand: get('id_brand'),
        left_limit: leftLimit,
        right_limit: rightLimit
      },
      success: function (html) {
        $('.items-row').html(html);
      }
    });
  }

  $('.categories .additional-menu_link a').click(function (e) { 

    if ( $(this).parent('li').hasClass('additional-menu_link') ) {
      e.preventDefault();
      $(this).parent('.additional-menu_link').toggleClass('li_active');
      $(this).parent('.additional-menu_link').children('.wrapp').toggleClass('active');
    }

  });

  idCategory = get('id');
  $('.categories').find('a[href="catalogue.php?id='+ idCategory +'"]').parents('.additional-menu_link').addClass('li_active').children('.wrapp').addClass('active');

  //Price-range
  $('#slider-range').slider(sliderSettings( $('#slider-range').attr('data-right-limit') )); 
  
  $('#amount').val( 'Цена: ' + $( '#slider-range' ).slider( 'values', 0 ) + ' руб.' + ' - ' + $( '#slider-range' ).slider( 'values', 1 ) + ' руб.' );
  $('.price-range-button').click(function (e) { 
    e.preventDefault();
    var sort = $('#select_sort').val(); 
    var countItems = $('#select_show').val(); 
    var outputType = $('.icon_active').attr('data-type');
    var page = $('.pagination li.active button').attr('data-page');
    var leftLimit = $('#slider-range').attr('data-left-limit');
    var rightLimit = $('#slider-range').attr('data-right-limit');
    ajaxItemsLoad(outputType, sort, countItems, page, leftLimit, rightLimit);
  }); 

  //Обработка selections
  $('select').change(function (e) { 
    e.preventDefault();
    var sort = $('#select_sort').val(); 
    var countItems = $('#select_show').val(); 
    var outputType = $('.icon_active').attr('data-type');
    var page = $('.pagination li.active button').attr('data-page');
    var leftLimit = $('#slider-range').attr('data-left-limit');
    var rightLimit = $('#slider-range').attr('data-right-limit');
    ajaxItemsLoad(outputType, sort, countItems, page, leftLimit, rightLimit);
  });

  $('.conclusion .icon').click(function (e) { 
    e.preventDefault();
    if ( $(window).width() <= 768 ) {
      alert('На мобильных устройства возможен вывод только в режиме сетки.');
      return false;
    }
    $('.icon_active').removeClass('icon_active');
    $(this).addClass('icon_active');
    var sort = $('#select_sort').val(); 
    var countItems = $('#select_show').val(); 
    var outputType = $(this).attr('data-type');
    var page = $('.pagination li.active button').attr('data-page');
    var leftLimit = $('#slider-range').attr('data-left-limit');
    var rightLimit = $('#slider-range').attr('data-right-limit');
    ajaxItemsLoad(outputType, sort, countItems, page, leftLimit, rightLimit);    
  });

  $('.main-content').on('click', '.pagination li button', function (e) {
    e.preventDefault();
    var page = $(this).attr('data-page');
    if ( page == $('.pagination li.active button').attr('data-page') ) {
      return false;
    }
    var sort = $('#select_sort').val(); 
    var countItems = $('#select_show').val(); 
    var outputType = $('.icon_active').attr('data-type');
    var leftLimit = $('#slider-range').attr('data-left-limit');
    var rightLimit = $('#slider-range').attr('data-right-limit');
    ajaxItemsLoad(outputType, sort, countItems, page, leftLimit, rightLimit);    
  });

  ajaxItemsLoad();

  $('.filter-button').click(function (e) { 
    e.preventDefault();
    $('.filter').toggleClass('filter_active');
  });

  $('.button-close').click(function (e) { 
    e.preventDefault();
    $('.filter').toggleClass('filter_active');
  });

  });