function confirmation() {

    if(!confirm("Realmente desea eliminar?")) return false;

}


$(function() {

  $(window).scroll(function() {
    var x = $(window).scrollTop();
      if (x <= 2) {
        document.getElementById("mnav").classList.remove("transparencia");
        document.getElementById("arruw-up").style.display = "none";
      } else {
        document.getElementById("arruw-up").style.display = "block";
        document.getElementById("mnav").classList.add("transparencia");
      }

  });

});
