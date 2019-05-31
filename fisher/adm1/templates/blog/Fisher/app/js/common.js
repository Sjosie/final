$(function() {

  function ajaxItems(idContainer, type) {
    type = type || 'default';

    if ( $(idContainer).children().length == 0 ) {
     
      $.ajax({
        type: 'POST',
        url: 'show.php',
        data: {
          id_category: $('a[href=' + '"' + idContainer + '"' + ']').attr('data-id'),
          type: type
        },
        beforeSend: ajaxLoad(idContainer),
        success: function(html){
          $(idContainer).append(html);
          ajaxStopLoad(idContainer);
        }
      });

    }
    
  }
   
  function ajaxLoad(idElement) {
    preloader = '<div class="preloader"><img src="img/preloader.gif" alt="Preloader"></div>';
    $(idElement).append(preloader);
  }

  function ajaxStopLoad(idElement) {
    $(idElement + ' .preloader').remove();
  }

  function createTabsElement(classParentElement) { 

    classParentElement = '.' + classParentElement + ' ';
    totalElements = $(classParentElement + 'ul.tabs').children('li').length;
    idElement = $(classParentElement + '.tab-container').attr('id');
    idElement = idElement.slice(0, -1);

    for (i = 2; i <= totalElements; i++) {
      tabElement = '<div class="tab-container row" id="' + idElement + i +'"></div>';
      $(classParentElement + '.tabs_wrapp').append(tabElement);      
    }

  }

	$('#home').slick({
		dots: true,
		infinite: true,
		autoplay: true,
		autoplaySpeed: 6000,
		pauseOnHover: false,
		speed: 600,
		slidesToShow: 1,
		adaptiveHeight: true,
		prevArrow: '<div class="prev"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 451.846 451.847" style="enable-background:new 0 0 451.846 451.847;" xml:space="preserve"><g><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744   L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284   c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"/></g></svg></div>',
		nextArrow: '<div class="next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 451.846 451.847" style="enable-background:new 0 0 451.846 451.847;" xml:space="preserve"><g><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744   L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284   c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"/></g></svg></div>',
    responsive: [{

      breakpoint: 992,
      settings: { 
        arrows: false
      }

    }]
  });

  //Простановка контейнеров для элементов табов
  createTabsElement('top-sales');
  createTabsElement('equipment-rental');
  //Загрузка товаров в первые табы
  ajaxItems('#tabs-ts-1');
  ajaxItems('#tabs-er-1', 'rent');

  //Загрузка товаров в табы по клику
  $('ul.tabs li a').click(function () { 
    id = $(this).attr('href');
    ajaxItems(id);
  });

  $('#equipment-rental-tabs').tabs();
  $('#top-sales-tabs').tabs();

  //Дата
  for (i = 0; i < $('.timer').length; i++) {

    id = $('.timer').eq(i).attr('id');
    date =  $('#' + id).attr('data-date');

    dataNow = new Date();
    data2   = new Date(date);
    result = data2 - dataNow;

    if ( result > 0 ) {
      $('#' + id).timeTo({
        timeTo: new Date(date),
        displayDays: 2,
        theme: "black",
        displayCaptions: true,
        fontSize: 20,
        captionSize: 12,
        lang: "ru"
      });
    }
    
  }

  $('#hot-deals-slider').slick({
    dots: true,
		infinite: true,
		//autoplay: true,
		autoplaySpeed: 3000,
		pauseOnHover: false,
		speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    centerMode: true,
    centerPadding: 0
  });

});