// autocomplet : this function will be executed every time we change the text
function autocomplet_mid() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#m1').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxMidd_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id_mid').show();
				$('#mid_list_id_mid').html(data);
			}
		});
	} else {
		$('#mid_list_id_mid').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_mid(item) {
	// change input value
	$('#m1').val(item);
	// hide proposition list
	$('#mid_list_id_mid').hide();
}


function autocomplet_comp() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#c1').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxComp_Rest_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id_comp').show();
				$('#mid_list_id_comp').html(data);
			}
		});
	} else {
		$('#mid_list_id_comp').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_comp(item) {
	// change input value
	$('#c1').val(item);
	// hide proposition list
	$('#mid_list_id_comp').hide();
}

function autocomplet_comp1() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#ct1').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxComp1_Rest_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id_comp1').show();
				$('#mid_list_id_comp1').html(data);
			}
		});
	} else {
		$('#mid_list_id_comp1').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_comp1(item) {
	// change input value
	$('#ct1').val(item);
	// hide proposition list
	$('#mid_list_id_comp1').hide();
}

function autocomplet_part1() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#s1').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxSource_Rest_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id_part1').show();
				$('#mid_list_id_part1').html(data);
			}
		});
	} else {
		$('#mid_list_id_part1').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_part1(item) {
	// change input value
	$('#s1').val(item);
	// hide proposition list
	$('#mid_list_id_part1').hide();
}

function autocomplet_part2() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#d1').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxDestination_Rest_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#mid_list_id_part2').show();
				$('#mid_list_id_part2').html(data);
			}
		});
	} else {
		$('#mid_list_id_part2').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_part2(item) {
	// change input value
	$('#d1').val(item);
	// hide proposition list
	$('#mid_list_id_part2').hide();
}