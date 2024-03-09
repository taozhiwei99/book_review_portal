// ------------tab navigation--------------
function openSegment(segmentName) {
  var i, tabcontent;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  document.getElementById(segmentName).style.display = "block";
  sessionStorage.setItem("lastActive", segmentName);
}

// ---------horizontal-navbar-menu-----------
var tabsNewAnim = $('#navbar-animmenu');
var selectorNewAnim = $('#navbar-animmenu').find('li').length;
var activeItemNewAnim = tabsNewAnim.find('.active');
var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
var itemPosNewAnimLeft = activeItemNewAnim.position();
// ----------left and right merge------------
$(".hori-selector").css({
  "left":itemPosNewAnimLeft.left + "px",
  "width": activeWidthNewAnimWidth + "px"
});
// -----------highlight selection-------------
$("#navbar-animmenu").on("click","li",function(e){
  $('#navbar-animmenu ul li').removeClass("active");
  $(this).addClass('active');
  var activeWidthNewAnimWidth = $(this).innerWidth();
  var itemPosNewAnimLeft = $(this).position();
  $(".hori-selector").css({
    "left":itemPosNewAnimLeft.left + "px",
    "width": activeWidthNewAnimWidth + "px"
  });
});

console.log("javascript loaded");

$(document).ready(function () {
  if (sessionStorage.getItem("lastActive") != null) {
    openSegment(sessionStorage.getItem("lastActive"));
    tab = sessionStorage.getItem("lastActive") + "Tab";
    document.getElementById(tab).click();
  }
});
