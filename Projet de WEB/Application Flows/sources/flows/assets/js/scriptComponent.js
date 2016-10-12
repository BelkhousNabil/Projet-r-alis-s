// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#mid_name').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxComponent_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id').show();
				$('#mid_list_id').html(data);
			}
		});
	} else {
		$('#mid_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#mid_name').val(item);
	// hide proposition list
	$('#mid_list_id').hide();
}