
var app = angular.module("1HourLaundryApp",[]);


app.controller("registerCtrl", function ($scope) {
    console.log("register control called.")
    
});

app.controller("loginCtrl", function ($scope) {    
    $scope.loginSubmit = function () {
        console.log($scope.loginFrm);
        console.log("-----------------");
        console.log($scope.loginObj.userName);
    };
    
});

app.controller("bulkOrderCtrl", function ($scope) {    
    $scope.bulkOrderSubmit = function () {
        console.log($scope.bulkOrderFrm);
        console.log("-----------------");
        console.log($scope.bulkOrderObj.phone);
    };
    
});



$(document).ready(function () {

    // smooth scrolling to sections
    $(function() {
      $('a[href*="#"]:not([href="#myCarousel"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });

    // Event Countdown
     //$("#DateCountdown").TimeCircles();
     //$("#DateCountdown1").TimeCircles();
    // Event Countdown

    $('.carousel').carousel({
        interval: 10000
    });

    $('.carousel').carousel('cycle');

    function initialize() {       

        var myLatlng = new google.maps.LatLng(17.462550, 78.351962);
        var mapOptions = {
            zoom: 17,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '1 Hour Laundry'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    $(".navbar-nav li a").click(function (event) {
        // check if window is small enough so dropdown is created
        var toggle = $(".navbar-toggle").is(":visible");
        if (toggle) {
            $(".navbar-collapse").collapse('hide');
        }
    });

    $("#backToTop").hide();

    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#backToTop').fadeIn();
            } else {
                $('#backToTop').fadeOut();

                var toggle = $(".navbar-toggle").is(":visible");
                if (toggle) {
                    $(".navbar-collapse").collapse('hide');
                }
            }
        });

        // scroll body to 0px on click
        /*
        $('#backToTop a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        */
    });
});

