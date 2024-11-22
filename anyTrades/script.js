function changeView() {
  var signIn = document.getElementById("sign_in");
  var signUp = document.getElementById("sign_up");

  signIn.classList.toggle("d-none");
  signUp.classList.toggle("d-none");

  document.getElementById("signup_msg_container").className = "d-none";
  document.getElementById("signin_msg_container").className = "d-none";
}

function signup() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var mobile = document.getElementById("mobile");
  var gender = document.getElementById("gender");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("email", email.value);
  form.append("password", password.value);
  form.append("mobile", mobile.value);
  form.append("gender", gender.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;

      if (res == "Success") {
        document.getElementById("signup_msg_container").className =
          "col-12 alert alert-success";
        document.getElementById("form-msg").innerHTML = res;

        fname.value = "";
        lname.value = "";
        email.value = "";
        password.value = "";
        mobile.value = "";

        window.location.reload();

      } else {
        document.getElementById("signup_msg_container").className =
          "col-12 alert alert-danger";
        document.getElementById("form-msg").innerHTML = res;
      }
    }
  };

  req.open("POST", "signUpProcess.php", true);
  req.send(form);
}

function signIn() {
  var email = document.getElementById("email2");
  var password = document.getElementById("password2");
  var rememberme = document.getElementById("rememberme");

  var form = new FormData();
  form.append("email", email.value);
  form.append("password", password.value);
  form.append("rememberme", rememberme.checked);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "true") {
        document.getElementById("signin_msg_container").className =
          "col-12 alert alert-success";
        document.getElementById("signin_msg").innerHTML = "Login Success";

        email.value = "";
        password.value = "";

        window.location = "home.php";
      } else if (res == "1") {
        document.getElementById("suspendMode").classList.toggle("d-none");
      } else {
        document.getElementById("signin_msg_container").className =
          "col-12 alert alert-danger";
        document.getElementById("signin_msg").innerHTML = res;
      }
    }
  };

  req.open("POST", "signInProcess.php", true);
  req.send(form);
}

function viewMessage(message) {
  return new Promise((resolve) => {
    document.getElementById("txtMessage").innerHTML = message;
    document.getElementById("alertBox").style.display = "block";

    document.getElementById("alertCloseBtn").addEventListener("click", () => {
      closeMessage();
      resolve(true);
    }, { once: true });
  });
}

function closeMessage() {
  document.getElementById("alertBox").style.display = "none";
}

function sellerRegistration() {
  var email = document.getElementById("s_email");
  var password = document.getElementById("s_password");
  var mobile = document.getElementById("s_mobile");
  var nic = document.getElementById("nic");

  var form = new FormData();
  form.append("email", email.value);
  form.append("password", password.value);
  form.append("mobile", mobile.value);
  form.append("nic", nic.value);

  var req = new XMLHttpRequest();


  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "success") {

        viewMessage("Seller Registration Completed.").then((result) => {
          if (result) {
            window.location = "home.php";
          }
        });


      } else if (res == "login") {
        var conf = confirm("Login to your user account");
        if (conf) {
          window.location = "index.php";
        }
      } else {
        alert(res);
      }
    }
  };

  req.open("POST", "sellerRegistrationProcess.php", true);
  req.send(form);
}

function sellerFormView() {
  var login = document.getElementById("seller_reg");
  var reg = document.getElementById("seller_login");

  login.classList.toggle("d-none");
  reg.classList.toggle("d-none");
}

function mobileNavBar() {
  var menu = document.getElementById("mobile-nav-bar");
  var menuMargin = parseInt(getComputedStyle(menu).marginLeft);

  if (menuMargin == 0) {
    menu.style.marginLeft = -100 + "%";
    menu.style.transitionDuration = 0.5 + "s";
    // document.getElementById("home").style.overflow = "auto";
  } else {
    menu.style.marginLeft = 0 + "%";
    menu.style.transitionDuration = 0.5 + "s";
    // document.getElementById("home").style.overflow = "hidden";
  }
}

function sellerSignIn() {
  var email = document.getElementById("s_s_email");
  var nic = document.getElementById("s_s_nic");

  var form = new FormData();
  form.append("email", email.value);
  form.append("nic", nic.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "success") {
        viewMessage("Login Success").then((result) => {
          if (result) {
            window.location = "home.php";
          }
        });
      } else if (res == "login") {
        var con = confirm("Login to your user account");
        if (con) {
          window.location = "index.php";
        }
      } else if (res == "1") {
        viewMessage("User account & Seller account doesn't match").then((result) => {
          if (result) {
            window.location = "index.php";
          }
        });
      } else {
        alert(res);
      }
    }
  };

  req.open("POST", "sellerSignInProcess.php", true);
  req.send(form);
}

function signOutBox() {
  var signOutBox = document.getElementById("signOutBox");
  signOutBox.style.display = "block";

  var logOut = document.getElementById("logOut");
  logOut.onclick = function () {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        var res = req.responseText;
        if (res == "1") {
          viewMessage("Sign Out Success").then((result) => {
            if (result) {
              window.location = "home.php";
            }
          });

        } else {
          alert(res);
        }
      }
    };

    req.open("GET", "signOutProcess.php", true);
    req.send();
  };

  var stay = document.getElementById("stay");
  stay.onclick = function () {
    signOutBox.style.display = "none";
  };
}

function sellerLogout() {
  var sellerOutBox = document.getElementById("sellerOutBox");
  sellerOutBox.style.display = "block";

  var logOut = document.getElementById("logOut");
  logOut.onclick = function () {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        var res = req.responseText;
        if (res == "1") {
          viewMessage("Seller Sign Out Success").then((result) => {
            if (result) {
              window.location = "home.php";
            }
          });
        } else {
          alert(res);
        }
      }
    };

    req.open("GET", "sellerLogoutProcess.php", true);
    req.send();
  };

  var stay = document.getElementById("stay");
  stay.onclick = function () {
    sellerOutBox.style.display = "none";
  };
}

function editUserProfile() {
  window.location = "userProfileEdit.php";
}

function profileBackground() {
  var profile_background_uploader = document.getElementById(
    "profile_background_uploader"
  );
  var background_image = document.getElementById("background_image");

  profile_background_uploader.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    background_image.src = url;
  };
}

function profileimage() {
  var profile_img_uploader = document.getElementById("profile_img_uploader");
  var profile_image = document.getElementById("profile_image");

  profile_img_uploader.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    profile_image.src = url;
  };
}

function loadDistrict() {
  var pid = document.getElementById("province");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("district").innerHTML = res;
    }
  };

  req.open("GET", "loadDistrict.php?pid=" + pid.value, true);
  req.send();

  loadCity();
}

function loadCity() {
  var did = document.getElementById("district");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("city").innerHTML = res;
    }
  };

  req.open("GET", "loadCity.php?did=" + did.value, true);
  req.send();
}

function editProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var dob = document.getElementById("dob");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var line3 = document.getElementById("line3");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var bio = document.getElementById("bio");
  var pCode = document.getElementById("pCode");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("mobile", mobile.value);
  form.append("dob", dob.value);
  form.append("line1", line1.value);
  form.append("line2", line2.value);
  form.append("line3", line3.value);
  form.append("province", province.value);
  form.append("district", district.value);
  form.append("city", city.value);
  form.append("bio", bio.value);
  form.append("pCode", pCode.value);

  var profile_img_uploader = document.getElementById("profile_img_uploader");
  var profile_background_uploader = document.getElementById(
    "profile_background_uploader"
  );

  var imageLenght = profile_img_uploader.files.length;
  var backgroundLenght = profile_background_uploader.files.length;

  if (imageLenght == 1) {
    form.append("img", profile_img_uploader.files[0]);
  }

  if (backgroundLenght == 1) {
    form.append("background", profile_background_uploader.files[0]);
  }

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;

      if (res == "Success") {
        viewMessage("Profile Update Successful").then((result) => {
          if (result) {
            window.location = "userProfile.php";
          }
        });
      } else {
        alert(res);
      }
    }
  };

  req.open("POST", "editProfileProcess.php", true);
  req.send(form);
}

function viewEditSellerProfile() {
  window.location = "sellerProfileEdit.php";
}

function sellerName() {
  document.getElementById("fname").value = "";
  document.getElementById("lname").value = "";
}

function sellerBackground() {
  var seller_background_uploader = document.getElementById(
    "seller_background_uploader"
  );
  var seller_background_image = document.getElementById(
    "seller_background_image"
  );

  seller_background_uploader.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    seller_background_image.src = url;
  };
}

function sellerImage() {
  var seller_img_uploader = document.getElementById("seller_img_uploader");
  var seller_image = document.getElementById("seller_image");

  seller_img_uploader.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    seller_image.src = url;
  };
}

function editSellerProfile() {
  var sname = document.getElementById("sname");
  var line1 = document.getElementById("line1");
  var line2 = document.getElementById("line2");
  var line3 = document.getElementById("line3");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var pCode = document.getElementById("pCode");
  var bio = document.getElementById("bio");
  var whatsapp = document.getElementById("whatsapp");
  var youtube = document.getElementById("youtube");
  var facebook = document.getElementById("facebook");
  var twitter = document.getElementById("twitter");
  var linkedin = document.getElementById("linkedin");

  var form = new FormData();
  form.append("sname", sname.value);
  form.append("line1", line1.value);
  form.append("line2", line2.value);
  form.append("line3", line3.value);
  form.append("province", province.value);
  form.append("district", district.value);
  form.append("city", city.value);
  form.append("pCode", pCode.value);
  form.append("bio", bio.value);
  form.append("whatsapp", whatsapp.value);
  form.append("youtube", youtube.value);
  form.append("facebook", facebook.value);
  form.append("twitter", twitter.value);
  form.append("linkedin", linkedin.value);

  var seller_background_uploader = document.getElementById(
    "seller_background_uploader"
  );
  var seller_img_uploader = document.getElementById("seller_img_uploader");

  var imageLenght = seller_img_uploader.files.length;
  var backgroundLenght = seller_background_uploader.files.length;

  if (imageLenght == 1) {
    form.append("img", seller_img_uploader.files[0]);
  }

  if (backgroundLenght == 1) {
    form.append("background", seller_background_uploader.files[0]);
  }

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "success") {
        viewMessage("Seller profile Updated").then((result) => {
          if (result) {
            window.location.reload();
          }
        });
      } else {
        alert(res);
      }
    }
  };

  req.open("POST", "editSellerProcess.php", true);
  req.send(form);
}

function filterPanelMove() {
  var filterPanel = document.getElementById("filterPanel");

  var filterheight = parseInt(getComputedStyle(filterPanel).height);

  if (filterheight == 0) {
    filterPanel.style.height = "fit-content";
    filterPanel.className =
      "col-12 pt-3 border-bottom border-1 pb-3 filterPanel shadow";
    filterPanel.style.transitionDuration = 0.3 + "s";
  } else {
    filterPanel.style.height = 0 + "px";
    filterPanel.className = "col-12 filterPanel";
    filterPanel.style.transitionDuration = 0.3 + "s";
  }
}

var categoryId = 0;
function cListChange(no) {
  var cListItem = document.getElementById("c-list-item-" + no);
  var cListView = document.getElementById("c-list-view");

  cListView.innerHTML = cListItem.innerHTML;

  categoryId = no;

  document.getElementById("category_name").innerHTML = cListItem.innerHTML;
}

var timeId;
function ProductRegistration() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;

      if (res == "1") {
        window.location.reload();
      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "categorySelectProcess.php?c=" + categoryId, true);
  req.send();
}

var addProductSlidesMargin = 0;
function addProductSlider(no) {
  var addProductSlides = document.getElementById("addProductSlides");

  // 0 -> left
  // 1 -> right
  if (no == 0) {
    if (addProductSlidesMargin < 0) {
      addProductSlidesMargin += 150;
      addProductSlides.style.marginLeft = addProductSlidesMargin + "px";
      addProductSlides.style.transitionDuration = 0.2 + "s";
    }
  }

  if (no == 1) {
    if (addProductSlidesMargin > -300) {
      addProductSlidesMargin -= 150;
      addProductSlides.style.marginLeft = addProductSlidesMargin + "px";
      addProductSlides.style.transitionDuration = 0.2 + "s";
    }
  }
}

function changeProductImg() {
  var productImg = document.getElementById("productImg");

  productImg.onchange = function () {
    var fileLength = productImg.files.length;

    if (fileLength <= 5) {
      for (var x = 0; x < fileLength; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);
        document.getElementById("product_img_" + x).src = url;
      }
    } else {
      viewMessage("You can only select up to 5 images");
    }
  };
}

function DOCModalActive() {
  document.getElementById("DOCModal").classList.toggle("d-none");
}

function deleteselectedCategory() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {
        window.location.reload();
      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "deleteSelectedCategoryProcess.php", true);
  req.send();
}

function modelSelector() {
  var brand = document.getElementById("brand");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("model").innerHTML = res;
    }
  };

  req.open("GET", "modelSelectorProcess.php?id=" + brand.value, true);
  req.send();
}

function addNewProductImagePreview(no) {
  var url = document.getElementById("product_img_" + no).src;
  document.getElementById("addNewProductImage").src = url;
  var add = document.getElementById("add");
  add.style.color = "white";
}

function newProductRegistration() {
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var title = document.getElementById("title");
  var color = document.getElementById("color");
  var condition = document.getElementById("condition");
  var quantity = document.getElementById("quantity");
  var size = document.getElementById("size");
  var price = document.getElementById("price");
  var dip = document.getElementById("DIP");
  var dop = document.getElementById("DOP");
  var desc = document.getElementById("product_desc");
  var images = document.getElementById("productImg");

  var form = new FormData();
  form.append("brand", brand.value);
  form.append("model", model.value);
  form.append("title", title.value);
  form.append("color", color.value);
  form.append("condition", condition.value);
  form.append("quantity", quantity.value);
  form.append("size", size.value);
  form.append("price", price.value);
  form.append("dip", dip.value);
  form.append("dop", dop.value);
  form.append("desc", desc.value);

  if (images.files.length > 0) {
    var file_length = images.files.length;

    for (var x = 0; x < file_length; x++) {
      form.append("img" + x, images.files[x]);
    }

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        var res = req.responseText;
        if (res == "success") {
          viewMessage("Product Registration is Complete").then((result) => {
            if (result) {
              window.location.reload();
            }
          });
        } else {
          alert(res);
        }
      }
    };

    req.open("POST", "addNewProductProcess.php", true);
    req.send(form);
  } else {
    var confirm_alert = confirm("You must upload at least one product image");
    if (confirm_alert) {
      viewMessage("Select Product Images");
    } else {
      viewMessage("You cannot add a product");
    }
  }
}

function categoryGridMove() {
  var category_grid = document.getElementById("category_grid");

  var style = parseInt(getComputedStyle(category_grid).height);

  if (style != 0) {
    category_grid.style.height = 0 + "px";
    category_grid.style.overflow = "hidden";
    document.getElementById("categoryMoveArrow").className =
      "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";
  } else {
    category_grid.style.height = "auto";
    category_grid.style.overflow = "hidden";
    document.getElementById("categoryMoveArrow").className =
      "icon-up-arrow-svgrepo-com fs-4 fw-bold";
  }
}

function advanceSearchMove() {
  var advanceSearchPanel = document.getElementById("advanceSearchPanel");

  var style = parseInt(getComputedStyle(advanceSearchPanel).height);

  if (style != 0) {
    advanceSearchPanel.style.height = 0 + "px";
    advanceSearchPanel.style.overflow = "hidden";
    advanceSearchPanel.style.transitionDuration = 0.3 + "s";
    document.getElementById("advanceSearchArrow").className =
      "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";
  } else {
    advanceSearchPanel.style.height = "auto";
    advanceSearchPanel.style.overflow = "hidden";
    advanceSearchPanel.style.transitionDuration = 0.3 + "s";
    document.getElementById("advanceSearchArrow").className =
      "icon-up-arrow-svgrepo-com fs-4 fw-bold";
  }
}

function basicSearch(pg) {
  document.getElementById("search_suggestion").style.display = "none";
  var basicSearchInput = document.getElementById("basicSearchInput");

  var req = new XMLHttpRequest();

  var form = new FormData();
  form.append("txt", basicSearchInput.value);
  form.append("page_no", pg);

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("BasicSearchResult").innerHTML = res;
    }
  };

  req.open("POST", "basicSearchProcess.php", true);
  req.send(form);
}

var singleProductViewSliderSize;
var singleProductImageCount;
function setSliderSize(size) {
  singleProductViewSliderSize = parseInt((size - 1) * 100);
  singleProductImageCount = size;
}

var singleSliderMargin = 0;

function singleSlider(id) {
  var singleSlider = document.getElementById("singleSlider");

  if (id == "+") {
    if (singleSliderMargin > -singleProductViewSliderSize) {
      singleSliderMargin -= 100;
      singleSlider.style.marginLeft = singleSliderMargin + "%";
      singleSlider.style.transitionDuration = 0.5 + "s";
    }
  } else if (id == "-") {
    if (singleSliderMargin < 0) {
      singleSliderMargin += 100;
      singleSlider.style.marginLeft = singleSliderMargin + "%";
      singleSlider.style.transitionDuration = 0.5 + "s";
    }
  } else {
    singleSliderMargin = id * -100;
    singleSlider.style.marginLeft = singleSliderMargin + "%";
    singleSlider.style.transitionDuration = 0.5 + "s";
  }

  if (singleSliderMargin == 0) {
    document.getElementById("singleSliderIndicator_0").style.backgroundColor =
      "#979797";
    document.getElementById("singleImgNumber").innerHTML = "1";
  } else {
    document.getElementById("singleSliderIndicator_0").style.backgroundColor =
      "#c7c7c7";
  }

  if (singleSliderMargin == -100) {
    document.getElementById("singleSliderIndicator_1").style.backgroundColor =
      "#979797";
    document.getElementById("singleImgNumber").innerHTML = "2";
  } else {
    document.getElementById("singleSliderIndicator_1").style.backgroundColor =
      "#c7c7c7";
  }

  if (singleSliderMargin == -200) {
    document.getElementById("singleSliderIndicator_2").style.backgroundColor =
      "#979797";
    document.getElementById("singleImgNumber").innerHTML = "3";
  } else {
    document.getElementById("singleSliderIndicator_2").style.backgroundColor =
      "#c7c7c7";
  }

  if (singleSliderMargin == -300) {
    document.getElementById("singleSliderIndicator_3").style.backgroundColor =
      "#979797";
    document.getElementById("singleImgNumber").innerHTML = "4";
  } else {
    document.getElementById("singleSliderIndicator_3").style.backgroundColor =
      "#c7c7c7";
  }

  if (singleSliderMargin == -400) {
    document.getElementById("singleSliderIndicator_4").style.backgroundColor =
      "#979797";
    document.getElementById("singleImgNumber").innerHTML = "5";
  } else {
    document.getElementById("singleSliderIndicator_4").style.backgroundColor =
      "#c7c7c7";
  }
}

function viewSeller(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {
        window.location = "sellerView.php?id=" + id;
      } else if (res == "2") {
        viewMessage("Seller no longer exists");
      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "verifySeller.php?id=" + id, true);
  req.send();
}

function singleProductView(id) {
  window.location = "singleProductView.php?p=" + id;
}

function addToCart(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {

        viewMessage("Product Added to Cart").then((result) => {
          if (result) {
            window.location.reload();
          }
        });

      } else if (res == "2") {
        viewMessage("You have to sign in first").then((result) => {
          if (result) {
            window.location = "index.php";
          }
        });
      } else if (res == "3") {
        viewMessage("Increased the Quantity of the Cart").then((result) => {
          if (result) {
            window.location.reload();
          }
        });
      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "addToCartProcess.php?p=" + id, true);
  req.send();
}

function removeFromCart(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {

        viewMessage("Product Removed").then((result) => {
          if (result) {
            window.location.reload();
          }
        });

      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "removeFromCartProcess.php?p=" + id, true);
  req.send();
}

function addToWatchlist(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {

        viewMessage("Product Added Succussfully").then((result) => {
          if (result) {
            window.location.reload();
          }
        });

      } else if (res == "2") {

        viewMessage("You have to sign in first").then((result) => {
          if (result) {
            window.location = "index.php";
          }
        });

      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "addToWatchlistProcess.php?p=" + id, true);
  req.send();
}

function goToWatchlist() {
  window.location = "watchlist.php";
}

function goToCart() {

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "2") {
        viewMessage("Your profile is incomplete. Please complete your profile").then((result) => {
          if (result) {
            window.location = "userProfileEdit.php";
          }
        });

      } else {
        window.location = "cart.php";
      }
    }
  };

  req.open("GET", "checkUserAddress.php", true);
  req.send();

}

document.getElementById("summery_close").onclick = function () {
  document.getElementById("cart_summery").style.display = "none";
};

document.getElementById("summery_open").onclick = function () {
  document.getElementById("cart_summery").style.display = "block";
};

function setQuantity(no, qty) {
  var input = document.getElementById("setQty");
  var value = parseInt(input.value);

  if (no == 0) {
    if (value > 0) {
      value = value - 1;
      input.value = value;
    }
  } else if (no == 1) {
    if (qty > value) {
      value = value + 1;
      input.value = value;
    }
  }

  if (value == 0) {
    input.value = 1;
  }
}

function basicSearchResultFinder() {
  var basicSearchInput = document.getElementById("basicSearchInput");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("search_suggestion").style.display = "block";
      document.getElementById("search_suggestion").innerHTML = res;
    }
  };

  req.open(
    "GET",
    "basicSearchResultFinder.php?txt=" + basicSearchInput.value,
    true
  );
  req.send();
}

function removeFromWatchlist(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {

        viewMessage("Product Removed From Watchlist").then((result) => {
          if (result) {
            window.location.reload();
          }
        });

      } else {
        alert(res);
      }
    }
  };

  req.open("GET", "removeFromWatchlistProcess.php?p=" + id, true);
  req.send();
}

var overflowMessagePage = 1;
function inboxLoader(from) {
  if (window.innerWidth < 992) {
    var inboxPanel = document.getElementById("inboxPanel");
    inboxPanel.classList.toggle("d-none");

    if (overflowMessagePage == 1) {
      document.getElementById("messagePage").style.overflow = "auto";
      overflowMessagePage = 2;
    } else {
      document.getElementById("messagePage").style.overflow = "hidden";
      overflowMessagePage = 1;
    }
  }

  inboxMessageLoader(from);
}

var msgDirection;
var clickedEmail;
function inboxMessageLoader(from) {
  var direction = msgDirection;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("message_box").innerHTML = res;

      var msg_box = document.getElementById("msg_box");
      msg_box.scrollTo(0, msg_box.scrollHeight);
    }
  };

  req.open(
    "GET",
    "inboxMessageLoadingProcess.php?e=" + from + "&direction=" + direction,
    true
  );
  req.send();

  clickedEmail = from;
  setInterval(refreshMessageLoader, 500);
}

function sendMessage(from) {
  var direction = msgDirection;
  var text = document.getElementById("sendMessageText").value;
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {
        document.getElementById("sendMessageText").value = "";

        var msg_box = document.getElementById("msg_box");
        msg_box.scrollTo(0, msg_box.scrollHeight);
        scrollID = 0;
      } else {
        alert(res);
      }
    }
  };

  req.open(
    "GET",
    "saveSendMessageProcess.php?from=" +
    from +
    "&text=" +
    text +
    "&direction=" +
    direction,
    true
  );
  req.send();
}

var scrollID = 0;
function refreshMessageLoader() {
  var direction = msgDirection;

  from = clickedEmail;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("msg_box").innerHTML = res;

      if (scrollID == 0) {
        var msg_box = document.getElementById("msg_box");
        msg_box.scrollTo(0, msg_box.scrollHeight);
        scrollID = 1;
      }
    }
  };

  req.open(
    "GET",
    "refreshMessageLoadingProcess.php?from=" + from + "&direction=" + direction,
    true
  );
  req.send();
}

function contactListRefresher(direction) {
  msgDirection = direction;
  setInterval(function () {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        var res = req.responseText;
        document.getElementById("contact_list").innerHTML = res;
      }
    };

    req.open(
      "GET",
      "contactListRefreshProcess.php?direction=" + direction,
      true
    );
    req.send();
  }, 500);
}

var seller_view_id = 0;
function openSellerMessageModal(seller_email) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {

        viewMessage("You cannot message with your seller account");

      } else {
        document.getElementById("sellerMsgModal").innerHTML = res;
        document.getElementById("sellerMsgModal").classList.toggle("d-none");

        var sellerMsgArea = document.getElementById("sellerMsgArea");
        sellerMsgArea.scrollTo(0, sellerMsgArea.scrollHeight);
      }
    }
  };

  req.open(
    "GET",
    "openSellerMessageModalVerification.php?email=" +
    seller_email +
    "&direction=2",
    true
  );
  req.send();
}

function sendByMsgModal(seller) {
  var txt = document.getElementById("modalTxt").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("sellerMsgArea").innerHTML = res;
      var sellerMsgArea = document.getElementById("sellerMsgArea");
      sellerMsgArea.scrollTo(0, sellerMsgArea.scrollHeight);
      document.getElementById("modalTxt").value = "";
    }
  };

  req.open(
    "GET",
    "sendByMsgModalProcess.php?txt=" + txt + "&seller=" + seller,
    true
  );
  req.send();
}

function categoryView(cat_id) {
  window.location = "singleCategory.php?cat_id=" + cat_id;
}

var filter_height;
function moveCategoryFilter() {
  var filter = document.getElementById("category_filter");
  filter_height = parseInt(getComputedStyle(filter).height);
  if (filter_height == 0) {
    filter.style.height = filter.scrollHeight + "px";
  } else {
    filter.style.height = 0 + "px";
  }
  filter.style.transitionDuration = 0.5 + "s";
}

function advanceSearch(pg) {
  var txt = document.getElementById("advSearchTxt").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;

      // Category List
      var category_grid = document.getElementById("category_grid");
      category_grid.style.height = 0 + "px";
      category_grid.style.overflow = "hidden";
      document.getElementById("categoryMoveArrow").className =
        "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";

      // Advance Search Panel
      var advanceSearchPanel = document.getElementById("advanceSearchPanel");
      advanceSearchPanel.style.height = 0 + "px";
      advanceSearchPanel.style.overflow = "hidden";
      document.getElementById("advanceSearchArrow").className =
        "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";

      document.getElementById("advanceSearchResult").innerHTML = res;
    }
  };

  req.open(
    "GET",
    "advanceSearchProcess.php?txt=" + txt + "&page_no=" + pg,
    true
  );
  req.send();
}

function brandListLoader() {
  var ctgr = document.getElementById("categoryList").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("brandList").innerHTML = res;
    }
  };

  req.open("GET", "brandListLoaderProcess.php?ctgr=" + ctgr, true);
  req.send();
}

function modalListLoader() {
  var brand = document.getElementById("brandList").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      document.getElementById("modalList").innerHTML = res;
    }
  };

  req.open("GET", "modalListLoaderProcess.php?brand=" + brand, true);
  req.send();
}

function advanceFullSearch(pg) {
  var txt = document.getElementById("advSearchTxt").value;
  var ctgr = document.getElementById("categoryList").value;
  var brand = document.getElementById("brandList").value;
  var model = document.getElementById("modalList").value;
  var condition = document.getElementById("condition").value;
  var color = document.getElementById("color").value;
  var rating = document.getElementById("rating").value;
  var year = document.getElementById("year").value;
  var month = document.getElementById("month").value;
  var p_from = document.getElementById("p_from").value;
  var p_to = document.getElementById("p_to").value;

  var form = new FormData();
  form.append("txt", txt);
  form.append("ctgr", ctgr);
  form.append("brand", brand);
  form.append("model", model);
  form.append("condition", condition);
  form.append("color", color);
  form.append("rating", rating);
  form.append("year", year);
  form.append("month", month);
  form.append("p_from", p_from);
  form.append("p_to", p_to);
  form.append("page_no", pg);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;

      // Category List
      var category_grid = document.getElementById("category_grid");
      category_grid.style.height = 0 + "px";
      category_grid.style.overflow = "hidden";
      document.getElementById("categoryMoveArrow").className =
        "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";

      // Advance Search Panel
      var advanceSearchPanel = document.getElementById("advanceSearchPanel");
      advanceSearchPanel.style.height = 0 + "px";
      advanceSearchPanel.style.overflow = "hidden";
      document.getElementById("advanceSearchArrow").className =
        "icon-down-arrow-svgrepo-com-1 fs-4 fw-bold";

      document.getElementById("advanceSearchResult").innerHTML = res;
    }
  };

  req.open("POST", "advanceFullSearchProcess.php", true);
  req.send(form);
}

function newUpdate() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
    }
  };

  req.open("GET", "newUpdateProcess.php", true);
  req.send();
}

function setNotification() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
    }
  };

  req.open("GET", "setNotificationProcess.php", true);
  req.send();
}

function adminSideBarMove() {
  var adminSideBar = document.getElementById("adminSideBar");
  var position = parseInt(getComputedStyle(adminSideBar).left);

  if (position < 0) {
    adminSideBar.style.left = 0;
    adminSideBar.style.transitionDuration = 0.4 + "s";
  } else {
    adminSideBar.style.left = "-" + 100 + "%";
    adminSideBar.style.transitionDuration = 0.4 + "s";
  }
}

function viewAdminInbox() {
  document.getElementById("adminChat").classList.toggle("d-none");
}

function searchUsersKey(key) {
  if (key.which == 13) {
    searchUsers();
  }
}

function searchUsers() {
  var user = document.getElementById("search_user").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      document.getElementById("search_user_content").innerHTML =
        req.responseText;
    }
  };

  req.open("GET", "searchUsersProcess.php?txt=" + user, true);
  req.send();
}

function viewProductMenu() {
  var productMenu = document.getElementById("productMenu");
  var menuHeight = parseInt(getComputedStyle(productMenu).height);

  if (menuHeight == 0) {
    productMenu.style.height = productMenu.scrollHeight + "px";
    productMenu.style.transitionDuration = 0.5 + "s";
  } else {
    productMenu.style.height = 0 + "px";
    productMenu.style.transitionDuration = 0.5 + "s";
  }
}

function filterCategory() {
  var item = document.getElementById("CategoryFilterOption").value;
  window.location = "?category=" + item;
}

function searchProductKey(key) {
  if (key.which == 13) {
    searchProduct();
  }
}

function searchProduct() {
  var txt = document.getElementById("product_name").value;
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      document.getElementById("searchProductContent").innerHTML =
        req.responseText;
    }
  };

  req.open("GET", "searchProductProcess.php?txt=" + txt, true);
  req.send();
}

function singleBuyNow(id) {
  var req = new XMLHttpRequest();

  var form = new FormData();
  form.append("id", id);

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      if (req.responseText == "1") {

        viewMessage("Sign in first").then((result) => {
          if (result) {
            window.location = "index.php";
          }
        });

      } else if (req.responseText == "2") {

        viewMessage("Complete your user profile").then((result) => {
          if (result) {
            window.location = "userProfileEdit.php";
          }
        });

      } else {
        var json_obj = req.responseText;
        var obj = JSON.parse(json_obj);

        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);
          // Note: validate the payment and show success or failure page to the customer

          saveSingleInvoice(obj["order_id"], obj["amount"], obj["email"], id);
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: "1221196", // Replace your Merchant ID
          return_url: "http://localhost/anyTrades/home.php", // Important
          cancel_url: "http://localhost/anyTrades/home.php", // Important
          notify_url: "http://sample.com/notify",
          order_id: obj["order_id"],
          items: obj["item"],
          amount: obj["amount"] + ".00",
          currency: obj["currency"],
          hash: obj["hash"], // *Replace with generated hash retrieved from backend
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: obj["email"],
          phone: obj["email"],
          address: obj["address"],
          city: obj["city"],
          country: obj["country"],
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: obj["country"],
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        document.getElementById("payhere-payment").onclick = function (e) {
          payhere.startPayment(payment);
        };
      }
    }
  };

  req.open("POST", "singleBuyNowProcess.php", true);
  req.send(form);
}

function saveSingleInvoice(oid, amount, email, pid) {
  var form = new FormData();
  form.append("oid", oid);
  form.append("amount", amount);
  form.append("email", email);
  form.append("pid", pid);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == 1) {
        window.location = "invoice.php?id=" + oid;
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "saveSingleInvoiceProcess.php", true);
  req.send(form);
}

function chatAdminOnload() {
  chat_admin_box();
}

function chat_admin_box() {
  var chatBox = document.getElementById("chat_admin_box");
  chatBox.scrollTo(0, chatBox.scrollHeight);
}

function chartLoad() {
  setInterval(chartShow, 1000);
}

function chartShow() {
  var obj, category, product, products = "0";

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      obj = JSON.parse(req.responseText);
      category = obj.category;
      product = obj.product;
      products = obj.products;

      var category_array = [];
      for (var c = 0; c < category.length; c++) {
        category_array[c] = category[c];
      }

      console.log(category);
      console.log(product);

      var product_array = [];
      for (var p = 0; p < product.length; p++) {
        product_array[p] = product[p];
      }

      const ctx = document.getElementById("myChart");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: category_array,
          datasets: [
            {
              label: products + " of Votes",
              data: product_array,
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });

      Chart.defaults.backgroundColor = "#9BD0F5";
      Chart.defaults.borderColor = "#36A2EB";
      Chart.defaults.color = "#000";
    }
  };

  req.open("GET", "chartLoadProcess.php", true);
  req.send();
}

function buyCart(total) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {

        viewMessage("Complete your user profile").then((result) => {
          if (result) {
            window.location = "userProfileEdit.php";
          }
        });

      } else {
        var json_obj = req.responseText;
        var obj = JSON.parse(json_obj);

        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);
          // Note: validate the payment and show success or failure page to the customer

          // saveSingleInvoice(obj["order_id"], obj["amount"], obj["email"], id);
          saveCartInvoice();
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: "1221196", // Replace your Merchant ID
          return_url: "http://localhost/anyTrades/home.php", // Important
          cancel_url: "http://localhost/anyTrades/home.php", // Important
          notify_url: "http://sample.com/notify",
          order_id: obj["order_id"],
          items: obj["item"],
          amount: obj["amount"] + ".00",
          currency: obj["currency"],
          hash: obj["hash"], // *Replace with generated hash retrieved from backend
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: obj["email"],
          phone: obj["email"],
          address: obj["address"],
          city: obj["city"],
          country: obj["country"],
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: obj["country"],
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        document.getElementById("payhere-payment").onclick = function (e) {
          payhere.startPayment(payment);
        };
      }
    }
  };

  req.open("GET", "buyCartProcess.php?total=" + total, true);
  req.send();
}

function saveCartInvoice() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var responseText = req.responseText;
      if (responseText.startsWith("'") && responseText.endsWith("'")) {
        responseText = req.responseText.slice(1, -1);
      }
      window.location = `checkout.php?inv_no=${responseText}`;
      alert(req.responseText);
    }
  };

  req.open("GET", "saveCartInvoiceProcess.php", true);
  req.send();
}

function placeHolderMove(name) {
  if (name == "e") {
    var emailHolder = document.getElementById("emailHolder");
    emailHolder.style.zIndex = 1;
    emailHolder.style.bottom = 75 + "%";
    emailHolder.style.transitionDuration = 1 + "s";
  } else if (name == "p") {
    var passwordHolder = document.getElementById("passwordHolder");
    passwordHolder.style.zIndex = 1;
    passwordHolder.style.bottom = 75 + "%";
    passwordHolder.style.transitionDuration = 1 + "s";
  }
}

function viewPassword() {
  document
    .getElementById("viewIcon")
    .classList.toggle("icon-visibility_black_24dp");
  document
    .getElementById("viewIcon")
    .classList.toggle("icon-visibility_off_black_24dp");
  if (document.getElementById("pswInput").type == "text") {
    document.getElementById("pswInput").type = "password";
  } else {
    document.getElementById("pswInput").type = "text";
  }
}

function signInModalViewer(name) {
  if (name == "o") {
    var email = document.getElementById("emailInput").value;
    var password = document.getElementById("pswInput").value;

    var jsObj = {
      eml: email,
      psw: password,
    };

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        if (req.responseText == "1") {
          document.getElementById("emailInput").style.borderColor = "red";
          document.getElementById("pswInput").style.borderColor = "red";
          viewMessage("Fill the form before you click the verify button");
        } else if (req.responseText == "2") {
          document.getElementById("emailInput").style.borderColor = "red";
          document.getElementById("pswInput").style.borderColor = "white";
          viewMessage("Enter you email");
        } else if (req.responseText == "3") {
          document.getElementById("emailInput").style.borderColor = "red";
          document.getElementById("pswInput").style.borderColor = "white";
          viewMessage("Invalid email");
        } else if (req.responseText == "4") {
          document.getElementById("emailInput").style.borderColor = "white";
          document.getElementById("pswInput").style.borderColor = "red";
          viewMessage("Enter you password");
        } else if (req.responseText == "5") {
          document.getElementById("emailInput").style.borderColor = "white";
          document.getElementById("pswInput").style.borderColor = "red";
          viewMessage("Password must be between 8 - 20 characters");
        } else if (req.responseText == "6") {
          document.getElementById("emailInput").style.borderColor = "white";
          document.getElementById("pswInput").style.borderColor = "white";
          document.getElementById("verifyEmail").value = email;
          document.getElementById("signInModal").classList.toggle("d-none");
        } else if (req.responseText == "7") {
          document.getElementById("emailInput").style.borderColor = "red";
          document.getElementById("pswInput").style.borderColor = "red";
          viewMessage("Invalid Email or Password");
        } else if (req.responseText == "8") {

          viewMessage("Email sending failed").then((result) => {
            if (result) {
              window.location.reload();
            }
          });

        }
      }
    };

    req.open("POST", "signInModalViewerProcess.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("json=" + JSON.stringify(jsObj));
  } else if (name == "c") {
    document.getElementById("signInModal").classList.toggle("d-none");
  }
}

function adminLogin() {
  var verifyCode = document.getElementById("verifyCode").value;
  var email = document.getElementById("emailInput").value;
  var psw = document.getElementById("pswInput").value;

  var jsonObj = {
    code: verifyCode,
    eml: email,
    psw: psw,
  };

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        viewMessage("Something went wrong? Please try again later");
      } else if (req.responseText == "2") {
        viewMessage("Invalid verification code. please check it again");
      } else if (req.responseText == "3") {
        document.getElementById("verifyCode").value = "";
        document.getElementById("emailInput").value = "";
        document.getElementById("pswInput").value = "";
        window.location = "adminPanel.php";
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open(
    "GET",
    "adminLoginProcess.php?json=" + JSON.stringify(jsonObj),
    true
  );
  req.send();
}

function catImage() {
  var img = document.getElementById("cat_img");

  var file1 = img.files[0];
  var url = window.URL.createObjectURL(file1);

  document.getElementById("cat_img_viewer").style.backgroundImage =
    "url(" + url + ")";
}

function newCategoryModal() {
  document.getElementById("categoryModal").classList.toggle("d-none");
  productMenu.style.height = 0 + "px";
  productMenu.style.transitionDuration = 0.5 + "s";
}

function newBrandModal() {
  document.getElementById("brandModal").classList.toggle("d-none");
  productMenu.style.height = 0 + "px";
  productMenu.style.transitionDuration = 0.5 + "s";

  document.getElementById("brandRegBtn").onclick = function () {
    var category = document.getElementById("categorySelector").value;
    var brand = document.getElementById("brand").value;
    var email = document.getElementById("brandEmail").value;

    var obj = {
      category: category,
      brand: brand,
      email: email,
    };

    var jsonObj = JSON.stringify(obj);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4 && req.status == 200) {
        if (req.responseText == "1") {

          viewMessage("Brand added successfuly").then((result) => {
            if (result) {
              window.location.reload();
            }
          });

        } else {
          alert(req.responseText);
        }
      }
    };

    req.open("POST", "newBrandModalProcess.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("json=" + jsonObj);
  };
}

function newModelModal() {
  document.getElementById("modelModal").classList.toggle("d-none");
  productMenu.style.height = 0 + "px";
  productMenu.style.transitionDuration = 0.5 + "s";

  document.getElementById("modelRegBtn").onclick = function () {
    var category = document.getElementById("modalCategory").value;
    var brand = document.getElementById("modalBrands").value;
    var modal = document.getElementById("modal").value;
    var email = document.getElementById("modalEmail").value;

    var obj = {
      category: category,
      brand: brand,
      modal: modal,
      email: email,
    };

    var jsonObj = JSON.stringify(obj);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4 && req.status == 200) {
        if (req.responseText == "1") {
          viewMessage("Model added successfuly").then((result) => {
            if (result) {
              window.location.reload();
            }
          });
        } else {
          alert(req.responseText);
        }
      }
    };

    req.open("POST", "newModelModalProcess.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("json=" + jsonObj);
  };
}

function registerCategory() {
  var img = document.getElementById("cat_img");
  var category = document.getElementById("category_name").value;
  var email = document.getElementById("admin_email").value;

  var form = new FormData();
  form.append("category", category);
  form.append("email", email);
  form.append("img", img.files[0]);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {

        viewMessage("Category added successfuly").then((result) => {
          if (result) {
            window.location.reload();
          }
        });

      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "newCategoryModalProcess.php", true);
  req.send(form);
}

function loadBrand() {
  var id = document.getElementById("modalCategory").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      document.getElementById("modalBrands").innerHTML = req.responseText;
    }
  };

  req.open("GET", "loadBrandProcess.php?id=" + id, true);
  req.send();
}

function searchOrderKey(key, pg) {
  // if (key.which == 13) {
  searchOrder(pg);
  // }
}

function searchOrder(pg) {
  console.log(pg);

  var txt = document.getElementById("searchOrderInput").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      } else {
        document.getElementById("searchOrderContainer").innerHTML =
          req.responseText;
      }
    }
  };

  req.open("GET", "searchOrderProcess.php?txt=" + txt + "&page_no=" + pg, true);
  req.send();
}

function changeOrderStatus(status, id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      }
    }
  };

  req.open(
    "GET",
    "changeOrderStatusProcess.php?status=" + status + "&id=" + id,
    true
  );
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  req.send();
}

function deleteOrder() {
  var psw = document.getElementById("admin_psw").value;
  var order_id = document.getElementById("order_id").value;

  var data_obj = {
    psw: psw,
    o_id: order_id,
  };

  var json_obj = JSON.stringify(data_obj);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "deleteOrderProcess.php", true);
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  req.send("json=" + json_obj);
}

function orderDeleteViewer(id) {
  document.getElementById("orderDeleteModal").classList.toggle("d-none");
  document.getElementById("order_id").value = "Order_" + id;
}

function changeUserStatus(status, mail) {
  var form = new FormData();
  form.append("status", status);
  form.append("mail", mail);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "changeUserStatusProcess.php", true);
  req.send(form);
}

function deletepurchaseItem(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("GET", "deletepurchaseItemProcess.php?id=" + id, true);
  req.send();
}

function deleteAllOrders() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "1") {
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("GET", "deleteAllOrdersProcess.php", true);
  req.send();
}


function removeMyProductToggle(pid, action) {
  if (action == "close") {
    document.getElementById("removeItemModel").style.display = "none";
  } else {
    document.getElementById("removeItemModel").style.display = "block";
  }
};

function cartQty(action, id, stock) {
  var qtyDisplay = document.getElementById("cartQty" + id);
  var currentQty = parseInt(qtyDisplay.value);
  if (action == '+') {
    if (stock > currentQty) {
      qtyDisplay.value = currentQty + 1;
    }
  } else {
    if (currentQty > 1) {
      qtyDisplay.value = currentQty - 1;
    }
  }
}

function viewCustomerAddress(action, customerEmail) {
  if (action == true) {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        document.getElementById("customerAddressDisplay").innerHTML = req.responseText;
        document.getElementById("customerAddress").classList.remove("d-none");
        document.getElementById("customerAddress").classList.add("d-block");
      }
    };

    req.open("GET", "getCustomerAddress.php?email=" + customerEmail, true);
    req.send();
  } else {
    document.getElementById("customerAddress").classList.remove("d-block");
    document.getElementById("customerAddress").classList.add("d-none");
  }
}

function requestWithdrawal() {

}

function openForgotPasswordModel() {
  document.getElementById("forgotPasswordModel").classList.remove("d-none");
}

function closeForgotPasswordModel() {
  document.getElementById("forgotPasswordModel").classList.add("d-none");
}

function sendResetPasswordOTP() {
  var email = document.getElementById("forgotEmail").value;
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {
        viewMessage("Please enter your email");
      } else if (res == "2") {
        viewMessage("Invalid email");
      } else if (res == "3") {
        viewMessage("Email is not registered bofore");
      } else if (res == "4") {
        viewMessage("Email is send. Check your inbox");
        document.getElementById("resetBtn").disabled = false;
      } else if (res == "5") {
        viewMessage("Email sending failed");
      } else {
        viewMessage("Something went wront. Please try again later");
      }
    }
  };
  req.open("POST", "sendForgotOTP.php", true);
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  req.send("email=" + encodeURIComponent(email));
}

function resetUserPassword() {
  var email = document.getElementById("forgotEmail").value;
  var otp = document.getElementById("forgotOTP").value;
  var password = document.getElementById("newPassword").value;

  var form = new FormData();
  form.append("email", email);
  form.append("otp", otp);
  form.append("password", password);

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var res = req.responseText;
      if (res == "1") {
        viewMessage("Invalid input details");
      } else if (res == "2") {
        viewMessage("Your password was cahanged.").then((result) => {
          if (result) {
            window.location.reload();
          }
        });
      } else {
        viewMessage("Something went wrong. Please try again later");
      }
    }
  };
  req.open("POST", "resetUserPasswordProcess.php", true);
  req.send(form);
}

function updateProduct(productID) {
  var title = document.getElementById("title");
  var quantity = document.getElementById("quantity");
  var dip = document.getElementById("DIP");
  var dop = document.getElementById("DOP");
  var desc = document.getElementById("product_desc");
  var images = document.getElementById("productImg");

  var form = new FormData();
  form.append("title", title.value);
  form.append("quantity", quantity.value);
  form.append("dip", dip.value);
  form.append("dop", dop.value);
  form.append("desc", desc.value);
  form.append("pid", productID);

  if (images.files.length > 0) {
    var file_length = images.files.length;

    for (var x = 0; x < file_length; x++) {
      form.append("img" + x, images.files[x]);
    }

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        var res = req.responseText;
        if (res == "success") {
          viewMessage("Product Updated").then((result) => {
            if (result) {
              window.location = "myProduct.php";
            }
          });
        } else {
          alert(res);
        }
      }
    };

    req.open("POST", "updateProcess.php", true);
    req.send(form);
  } else {
    var confirm_alert = confirm("You must upload at least one product image");
    if (confirm_alert) {
      viewMessage("Select Product Images");
    } else {
      viewMessage("You cannot add a product");
    }
  }
}