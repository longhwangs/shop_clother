function updateQty(qty, rowId) {
	$.get(
		'cart/update',
		{qty:qty, rowId:rowId},
		function() {
			location.reload();
		}
	);
}