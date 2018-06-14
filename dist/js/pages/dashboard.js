var activeitem;
function comparePassword(){
    const pwd = $('#new-password').val();
    const rep = $('#re-password').val();

    if (pwd !== rep){
        $('#update-password').prop('disabled', true);
        $('input#re-password').addClass('input-red-error');
        $('input#new-password').addClass('input-red-error');
    }
    else {
        $('#update-password').prop('disabled', false);
        $('input#re-password').removeClass('input-red-error');
        $('input#new-password').removeClass('input-red-error');
    }
}

function validateEmail(input){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test($(input).val());
}

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  // Add date picker to calendar using jquery UI
  $('#calendar').datepicker();
});

// Add scroll to top functionality
$(document).ready(function() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('#scrolltop').fadeIn();
        }
        else {
            $('#scrolltop').fadeOut();
        }
    });

    $('#scrolltop').on('click', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 600);
    });

    // Chnage preview image on click
    $('#profile-image').on('change', function () {
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
        else {
            $('#profile-img').attr('src', 'dist/img/avatar.png');
        }
    });

    $('input#re-password').keyup(function () {
        comparePassword();
    });

    $('input#new-password').keyup(function () {
        comparePassword();
    });

    $('#inputEmail').keyup(function () {
        if (!validateEmail(this)){
          $('#update-profile').prop('disabled', true);
          $(this).addClass('input-red-error');
        }
        else {
            $('#update-profile').prop('disabled', false);
            $(this).removeClass('input-red-error');
        }

        if ($(this).val() === ''){
            $('#update-profile').prop('disabled', false);
            $(this).removeClass('input-red-error');
        }
    });

    $('img#profile-img').on('click', function () {
        $('label.custom-file-upload').click();
    })
});
