"use strict"

const Cignadlte = function() {
  if (typeof $.fn.dataTable !== "undefined")
		$.fn.dataTable.Api.register("column().title()", function () {
			return $(this.header()).data("id")
		})
  
  return {
    init: () => {
			setTimeout(function () {
				if (window.___browserSync___ === undefined && Number(localStorage.getItem('Cignadlte:Demo:MessageShowed')) < Date.now()) {
					localStorage.setItem('Cignadlte:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
					
					Swal.fire("Welcome back Saleem.", "Admin Pannel to manage all your needs! <br><br><small></small>")
				}
			}, 1000)
    },
    onDOMContentLoaded:function(e){"loading"===document.readyState?document.addEventListener("DOMContentLoaded",e):e()}
  }
}()

$(document).ready(function() { 
  Cignadlte.init()
})