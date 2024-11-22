function buyNowModal(id) {

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            var res = req.responseText;
            document.getElementById("buyNowModal").innerHTML = res;
            document.getElementById("buyNowModal").classList.toggle("d-none");
        }
    };

    req.open("GET", "buyNowModalProcess.php?pid=" + id, true);
    req.send();

}


var slider_margin = 0;
var size_of_slider;
var img_number = 1;
function buyNowSlider(direction) {
    size_of_slider = document.getElementById("size_of_slider").innerHTML;

    if (direction == 1) {
        if (slider_margin > -((size_of_slider - 1) * 100)) {
            document.getElementById("buyNowImageNumber").innerHTML = img_number + 1;
            img_number += 1;
            slider_margin -= 100;
            document.getElementById("buyNowSliderImages").style.marginLeft = slider_margin + "%";
            document.getElementById("buyNowSliderImages").style.transitionDuration = 0.3 + 's';
        }
    } else {
        if (slider_margin < 0) {
            document.getElementById("buyNowImageNumber").innerHTML = img_number - 1;
            img_number -= 1;
            slider_margin += 100;
            document.getElementById("buyNowSliderImages").style.marginLeft = slider_margin + "%";
            document.getElementById("buyNowSliderImages").style.transitionDuration = 0.3 + 's';
        }
    }

    console.log(slider_margin);

}