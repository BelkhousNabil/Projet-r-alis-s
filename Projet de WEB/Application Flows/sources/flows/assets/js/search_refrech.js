// autocomplet : this function will be executed every time we change the text
function autocomplet_mid() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#middleware').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxFlows_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#list_mid').show();
				$('#list_mid').html(data);
			}
		});
	} else {
		$('#list_mid').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_mid(item) {
	// change input value
	$('#middleware').val(item);
	// hide proposition list
	$('#list_mid').hide();
}


function autocomplet_comp() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#component').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxComp_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#list_comp').show();
				$('#list_comp').html(data);
			}
		});
	} else {
		$('#list_comp').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_comp(item) {
	// change input value
	$('#component').val(item);
	// hide proposition list
	$('#list_comp').hide();
}

function autocomplet_part1() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#source').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxSource_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#list_part1').show();
				$('#list_part1').html(data);
			}
		});
	} else {
		$('#list_part1').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_part1(item) {
	// change input value
	$('#source').val(item);
	// hide proposition list
	$('#list_part1').hide();
}

function autocomplet_part2() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#destination').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '../assets/js/ajaxDestination_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#list_part2').show();
				$('#list_part2').html(data);
			}
		});
	} else {
		$('#list_part2').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item_part2(item) {
	// change input value
	$('#destination').val(item);
	// hide proposition list
	$('#list_part2').hide();
}