(function( $ ) {

		var modal = document.getElementById('WebdModalWidget-Modal');
		var span = document.getElementsByClassName("WebdModalWidget-close")[0];	

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
			localStorage.setItem('modal-shown','1');	
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
		
	
})( jQuery )	