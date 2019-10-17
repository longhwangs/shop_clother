function updateQty(qty, rowId) {
	$.get(
		'cart/update',
		{qty:qty, rowId:rowId},
		function() {
			location.reload();
		}
	);
}

$(document).ready(function() {
	$('#cate_parent').change(function() {
		var cate_parent = $(this).val();
		$.get("admin/product/create/"+cate_parent, function(data) {
			$("#category_id").html(data);
		});
	});
});
