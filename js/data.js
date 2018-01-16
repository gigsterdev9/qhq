/**
 * JAVASCRIPT FILES FOR OBJECTS FOUND IN THE VIEW
 * PJ Villarta
 **/

/** DATA SEARCH **/

//match finder for when adding new entries in scholarships and services
function match_find_ajax(form_tag) {
	$("#notice").text("Processing...");
	$.ajax({
        "type" : "POST",
        "url": "/beneficiaries/match_find",
        "data" : $(form_tag).serialize(), // serializes the form's elements.
        "success" : function(data){
			console.log(data); // show response from the php script.
			$("#notice").fadeIn("fast");
			$("#notice").text("Processing...");
			$("#notice").fadeOut("fast");
			$("#search_results").html("<h2>Search Results</h2>"+data);
		},
		"error": function(jqXHR, status, error) {
			console.log("status:", status, "error:", error);
			//$("#warning").text("Unable to process at this time.");
			$("#warning").text(status);
		}
    });
}

//form trigger
$("#match_find_submit").click(function( event ) {
	event.preventDefault();
	//execute ajax post
	match_find_ajax("#match_find");

});



/** GENERAL DATA UPDATES **/
//this is for data updating functions

function update_ajax(form_tag) {
	$("#notice").text("Processing...");
	$.ajax({
        "type" : "POST",
        "url": "/pcr-mims/admin_update.php",
        "data" : $(form_tag).serialize(), // serializes the form's elements.
        "success" : function(data){
			console.log(data); // show response from the php script via console.
			$("#notice").fadeIn("fast");
			$("#notice").text("Update successful.");
			$("#notice").fadeOut(3000);
		},
		"error": function(jqXHR, status, error) {
			console.log("status:", status, "error:", error);
			$("#warning").text("Update failed.");
		}
    });
}

//this is for the pending list section (activation method)
$( "#pending_list" ).on('click', '#update_pending_list', function( event ) {
	event.preventDefault();
	//execute ajax post
	update_ajax("#form_pending_list");
	setTimeout(function(){
		window.location.reload(true);
	}, 3000); //the delay is essential to allow for server-side processes to finish
});

//this is for the active list section (deactivation method)
$( "#accounts_list" ).on('click', '#update_active_list', function( event ) {
	event.preventDefault();
	//execute ajax post
	update_ajax("#form_active_list");
	setTimeout(function(){
		window.location.reload(true);
	}, 3000); //the delay is essential to allow for server-side processes to finish
});
