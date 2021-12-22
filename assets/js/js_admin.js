(function ($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    }
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function () {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    }
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function (e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });


  // select option
  $(function () {
    var closeSelectTimeout;

    function hideMaterialList(parent) {
      parent.css({
        'overflow': 'hidden'
      }).removeClass('isOpen');
      clearTimeout(closeSelectTimeout);
      closeSelectTimeout = setTimeout(function () {
        parent.parent().css({
          'z-index': 0
        });
      }, 200);
    }
    $(document.body).on('mousedown', '.materialBtn, .select li', function (event) {
      if (parseFloat($(this).css('opacity')) > 0 && $(document).width() >= 1008) {
        var maxWidthHeight = Math.max($(this).width(), $(this).height());
        if ($(this).find("b.drop").length == 0 || $(this).find("b.drop").css('opacity') != 1) {
          // .drop opacity is 1 when it's hidden...css animations
          drop = $('<b class="drop" style="width:' + maxWidthHeight + 'px;height:' + maxWidthHeight + 'px;"></b>').prependTo(this);
        }
        else {
          $(this).find("b.drop").each(function () {
            if ($(this).css('opacity') == 1) {
              drop = $(this).removeClass("animate");
              return;
            }
          });
        }
        x = event.pageX - drop.width() / 2 - $(this).offset().left;
        y = event.pageY - drop.height() / 2 - $(this).offset().top;
        drop.css({
          top: y,
          left: x
        }).addClass("animate");
      }
    });
    $(document.body).on('dragstart', '.materialBtn, .select li', function (e) {
      e.preventDefault();
    });

    var selectTimeout;
    $(document.body).on('click', '.select li', function () {
      var parent = $(this).parent();
      parent.children('li').removeAttr('data-selected');
      $(this).attr('data-selected', 'true');
      clearTimeout(selectTimeout);
      if (parent.hasClass('isOpen')) {
        if (parent.parent().hasClass('required')) {
          if (parent.children('[data-selected]').attr('data-value')) {
            parent.parents('.materialSelect').removeClass('error empty');
          }
          else {
            parent.parents('.materialSelect').addClass('error empty');
          }
        }
        hideMaterialList($('.select'));
      }
      else {
        var pos = Math.max(($('li[data-selected]', parent).index() - 2) * 48, 0);
        parent.addClass('isOpen');
        parent.parent().css('z-index', '999');
        if ($(document).width() >= 1008) {
          var i = 1;
          selectTimeout = setInterval(function () {
            i++;
            parent.scrollTo(pos, 50);
            if (i == 2) {
              parent.css('overflow', 'auto');
            }
            if (i >= 4) {
              clearTimeout(selectTimeout);
            }
          }, 100);
        }
        else {
          parent.css('overflow', 'auto').scrollTo(pos, 0);
        }
      }
    });

    $('.materialInput input').on('change input verify', function () {
      if ($(this).attr('required') == 'true') {
        if ($(this).val().trim().length) {
          $(this).parent().removeClass('error empty');
        }
        else {
          $(this).parent().addClass('error empty');
          $(this).val('');
        }
      }
      else {
        if ($(this).val().trim().length) {
          $(this).parent().removeClass('empty');
        }
        else {
          $(this).parent().addClass('empty');
        }
      }
    });

    $(document.body).on('click', function (e) {
      var clicked;
      if ($(e.target).hasClass('materialSelect')) {
        clicked = $(e.target).find('.select').first();
      }
      else if ($(e.target).hasClass('select')) {
        clicked = $(e.target);
      }
      else if ($(e.target).parent().hasClass('select')) {
        clicked = $(e.target).parent();
      }

      if ($(e.target).hasClass('materialSelect') || $(e.target).hasClass('select') || $(e.target).parent().hasClass('select')) {
        hideMaterialList($('.select').not(clicked));
      }
      else {
        if ($('.select').hasClass('isOpen')) {
          hideMaterialList($('.select'));
        }
      }
    });
    hideMaterialList($('.select'));
  });


  $(document).on('change', '.btn-file :file', function () {
    var input = $(this),
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
  });

  $('.btn-file :file').on('fileselect', function (event, label) {

    var input = $(this).parents('.input-group').find(':text'),
      log = label;

    if (input.length) {
      input.val(log);
    } else {
      if (log) alert(log);
    }

  });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#img-upload').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".imgInp").change(function () {
    readURL(this);
  });

})(jQuery); // End of use strict


// searche
jQuery(document).ready(function ($) {
  $('.live-search-list .search').each(function () {
    $(this).attr('data-search-term', $(this).text().toLowerCase());
  });

  $('.live-search').on('keyup', function () {

    var searchTerm = $(this).val().toLowerCase();

    $('.live-search-list .search').each(function () {

      if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
        $(this).show();
        $('.search-empty').removeClass('d-block').addClass('d-none');
      } else {
        $(this).hide();

        if ($('.search:visible').length == 0) {
          $('.search-empty').addClass('d-block');
          $('#data-search').html(searchTerm);
        }

      }

    });

  });

});

/* 
Character counter
*/
function limiting(oEvent) {
  if(isNaN(this.maxLength) == false){ 
    let oDiv =  document.getElementById(this.name+"Error");
    if(oDiv){
      let oCnt = oDiv.children[0],
          iLongueur = this.value.length,
          iLimit = this.maxLength;
      if(iLimit - iLongueur < 0) {
        oCnt.classList.add("warning");
      }else{
        oCnt.classList.remove("warning");
      }
      oCnt.textContent = iLongueur;
    }
  }
}

function limitingData(oEvent) {
  if(isNaN(this.dataset.maxlength) == false){ 
    let oDiv =  document.getElementById(this.name+"Error");
    if(oDiv){
      let oCnt =  oDiv.children[0], 
          iLongueur = this.value.length,
          iLimit = parseInt(this.dataset.maxlength);  
      if(iLimit - iLongueur < 0) {
        oCnt.classList.add("warning");
        oCnt.textContent = iLimit - iLongueur ;
      }else{
        oCnt.classList.remove("warning");
        oCnt.textContent = iLongueur ;
      }
    }
  }
}


document.addEventListener('DOMContentLoaded',function(){
  let aTextarea = document.getElementsByTagName('input');
  for(let oTextarea of aTextarea){
    if(oTextarea.maxLength != -1 && oTextarea.dataset.maxlength == null){
      //Avec un attribut maxlength
      oTextarea.addEventListener('input',limiting);
    }else if(oTextarea.maxLength == -1 && oTextarea.dataset.maxlength != null){
      //Sans limite bloquante
      oTextarea.addEventListener('input',limitingData); 
    }
  }
});
