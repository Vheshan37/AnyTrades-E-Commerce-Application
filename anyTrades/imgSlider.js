window.onload = function () {

    autoSlideMove();

}



var slides = document.getElementById("slides");
var autoRunId;
function autoSlideMove() {

    autoRunId = setInterval(animation_auto_run, 8000);

    slideLineHover();

}

var slideMargin = 0;
function animation_auto_run() {

    slideMargin -= 100;

    if (slideMargin == -500) {
        slideMargin = 0;
    }

    slides.style.marginLeft = slideMargin + "vw";
    slides.style.transitionDuration = 0.7 + "s";

    slideLineHover();

}



var arrowNavigationId;
function arrowNavigation(e) {
    if (e == -1) {
        if (slideMargin < 0) {
            clearInterval(autoRunId);
            clearInterval(arrowNavigationId);
            slideMargin += 100;
            slides.style.marginLeft = slideMargin + "vw";
            slides.style.transitionDuration = 0.7 + "s";
            arrowNavigationId = setInterval(animation_auto_run, 8000);
        }

        slideLineHover();

    }
    if (e == 1) {
        if (slideMargin > -400) {
            clearInterval(autoRunId);
            clearInterval(arrowNavigationId);
            slideMargin -= 100;
            slides.style.marginLeft = slideMargin + "vw";
            slides.style.transitionDuration = 0.7 + "s";
            arrowNavigationId = setInterval(animation_auto_run, 8000);
        }

        slideLineHover();

    }
}



var slideLineAnimationId;
function slideLineAnimation(e) {

    for (var i = 0; i < 5; i++) {

        if (e == i) {

            clearInterval(arrowNavigationId);
            clearInterval(autoRunId);
            clearInterval(slideLineAnimationId);

            slideMargin = i * -100;

            slides.style.marginLeft = slideMargin + "vw";
            slides.style.transitionDuration = 0.7 + "s";

            slideLineAnimationId = setInterval(animation_auto_run, 8000);

            slideLineHover();

        }

    }

}




function slideLineHover() {

    if (slideMargin == 0) {
        document.getElementById("slide_line0").style.backgroundColor = "white";
    } else {
        document.getElementById("slide_line0").style.backgroundColor = "transparent";
    }
    if (slideMargin == -100) {
        document.getElementById("slide_line1").style.backgroundColor = "white";
    } else {
        document.getElementById("slide_line1").style.backgroundColor = "transparent";
    }
    if (slideMargin == -200) {
        document.getElementById("slide_line2").style.backgroundColor = "white";
    } else {
        document.getElementById("slide_line2").style.backgroundColor = "transparent";
    }
    if (slideMargin == -300) {
        document.getElementById("slide_line3").style.backgroundColor = "white";
    } else {
        document.getElementById("slide_line3").style.backgroundColor = "transparent";
    }
    if (slideMargin == -400) {
        document.getElementById("slide_line4").style.backgroundColor = "white";
    } else {
        document.getElementById("slide_line4").style.backgroundColor = "transparent";
    }

}