function ciao() {
	var dati = "name=John&location=Boston";
	$.ajax( {
		url : "prove/test.php",
		data : dati,
		dataType : "html",
		type : "POST",
		cache : false,
		success : function(html) {
			$("#results").html(html);
		},
		error : function(id1, id2, id3) {
			$("#results").html("kek");
		}
	});
}


$(document).ready(function() {

	$('.jtip').cluetip({
		  cluetipClass: 'jtip', 
		  arrows: true, 
		  showTitle: false,
		  positionBy: 'bottomTop',
		  topOffset: 8,       
		 // dropShadow: false,
		  hoverIntent: false,
		  sticky: true,
		  mouseOutClose: true,
		 // closePosition: 'title',
		  closeText: ''
		});

})