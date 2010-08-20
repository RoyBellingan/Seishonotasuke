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

$(function() {
	$(".someClass").tipTip();
});

/*
 * 
 * $(function() { var text = "potrei inserire molte cose interessanti qui sai
 * ??"; $("#Pentateuco21").tipTip( { keepAlive : "true", content : text, delay :
 * "0", enter : ciao }); });
 */
var html_text = "ciao";
$(document).ready(function() {

	$("#full a").bind('mouseenter',function(){
		id=$(this).attr("id");

			$("#"+id).tipTip( {
				keepAlive : "true",
				content : html_text,
				delay : "50",
				ajax:"l2.php",
				attribute:"name"
			});
			$("#"+id).tipTip( {
				keepAlive : "true",
				content : html_text,
				delay : "50",
				ajax:"l2.php",
				attribute:"name"
			});

	});
});



/*

$("ul.topnav li").bind('mouseenter',
        function(){ //When trigger is clicked...
           //Following events are applied to the subnav itself (moving subnav up and down)
           var neu = $(this).find("ul.subnav")
           neu.slideDown('fast').show(); //Drop down the subnav on click
           $(this).hover(function(){
           },
           function(){
               var nao = $(this).find("ul.subnav")
              // nao.stop(true, true).slideUp(1);
               //When the mouse hovers out of the subnav, move it back up
           
           });
           */
           

function divover(id) {

	// alert (id)
	// var text = '<div id="tooltip_image0" class="tooltip_image" ><span><img
	// alt="" src="img/tooltip-trans.png"></span> <span>E se io inserissi del
	// testo qui ???</span></div>';
	// var parent = "#full";
	$.ajax( {
		// Store dei dati da leggere, relativo alla pagina in esame
		url : "l2.php", // saerebbe lo script che crea i numeri di versetti e
		// capitoli
		data : id,
		dataType : "html",
		type : "POST",
		cache : false,
		success : function(html) {
			// alert (html_text);
		html_text = html;
		// alert (html_text);
		// $(parent).append(text);
		// var text = "potrei inserire molte cose interessanti qui sai ??";
		// alert (html_text);
	}
	});

}