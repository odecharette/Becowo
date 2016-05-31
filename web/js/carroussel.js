/* ===========================================================
 * script.js v1.0
 * ===========================================================
 * Copyright 2015 Shivam Pandya - Tutorial Drive.
 * https://www.github.com/tutorialdrive
 *
 * Bootstrap Vertical Image Showcase v1.0
 * Create an Vertical Thumbnail Carousel For Twitter Bootstrap v3.0.3
 *
 * 
 * License: MIT License
 * http://opensource.org/licenses/MIT
 *
 * ========================================================== */

$(document).ready(function () {
  $('#myCarousel').carousel({
    interval: false
            //interval: 2000
  });
  $('.small-thumbnail img').click(function () {
    $('#DataDisplay').attr("src", $(this).attr("data-display"));
  });

});
