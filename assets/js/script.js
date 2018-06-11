// Code is poetry.

var doc = document;
var win = window;
var tgl = ".mtoggle";
var modal = ".login-box";
var login = "#nav-login";
var close = "#close-modal";
var type = ".typewriter";
var openModalCMD = "#login" // Used to open modal explicitly

function openLoginModal(){
    $("#op-filter").css({
        "opacity": ".9"
    });
    $(modal).css({
        "transform": "scale(1)"
    });
    $(type).hide(300);
}

function closeLoginModal(){
    $(modal).css({
        "transform": "scale(0)"
    });
    $("#op-filter").css({
        "opacity": ".7"
    });
    $(type).show(500);
}

$(doc).ready(function (){

	// View and hide modal
	$(login).click(function(){
		openLoginModal();
	});

	$(close).click(function (){
        closeLoginModal();

        // Remove class of active from login
        $("nav ul li").removeClass("nav-active");
        $("#nav-home").addClass("nav-active");
	});

	$(doc).click(function(event) {
		 var url = $(location).attr('hash');
		 if (!$(event.target).closest(".modal-wrapper, #nav-login, .mtoggle").length) {
			closeLoginModal();
		 }
	})
	// END MODAL CODE

	// Mobile NAV toggle
    $(tgl).click(function(){
       $('.desktop-nav').slideToggle(500);
       if ($(type).is(':visible')){
       		$(type).hide(500);
       }
       else {
       	$(type).show(500);
       }
    });

    // Auto click
	var url = $(location).attr('hash');
	switch (url){ 
		case openModalCMD :
			setTimeout(function (){
                openLoginModal();
			}, 300);
			break;
		case "#login-failed" :
            setTimeout(function (){
                openLoginModal();
            }, 300);
            break;
		default:
			break;
	}  

	// Add option to show/hide scroll top button
	$(win).scroll(function () {
        var scrollVal = $(this).scrollTop();
        if (scrollVal > 100){
            // Show scroll-top
        }
        else {
            // Hide scroll-top
        }
    });

	// Add active class to the menu item clicked.
    $("nav ul li").click(function () {
        $("ul li").removeClass("nav-active");
        $(this).addClass("nav-active");

        // close the nav if on mobile
        if ($(tgl).is(':visible')) {
            $('.desktop-nav').slideToggle(500);
        }
    });
});