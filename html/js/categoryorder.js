$().ready(function() {
	getMax();
	$('#Category_parent_id').on('change', function(){getMax();});
});

function getMax() {
	$.ajax({
		url: '/control/categories/getMaxOrder',
		data: 'parent_id='+ $('#Category_parent_id').val() + '&new=' + newRec + '&curr=' + curOrd,
		success: function(data, status) {
			$('#Category_menu_order').html(data);
		},
	});
}
