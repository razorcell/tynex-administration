$(document).ready(function() {
	var all_rows_selected = false;
	$('.f_p_add').submit(function(e) {

		e.preventDefault();
	});
	$('.f_p_modify').submit(function(e) {

		e.preventDefault();
	});

	$('.edit').click(function() {
		$('.pack tbody tr').each(function(i, row) {
			$(this).removeClass('row_selected');
		});
	});

	$('.selectall').click(function() {
		if (all_rows_selected == false) {
			$('.pack tbody tr').each(function(i, row) {
				if ($(this).hasClass('row_selected').toString() == 'false') {
					$(this).addClass('row_selected');
				}
				all_rows_selected = true;
			});
		} else {
			$('.pack tbody tr').each(function(i, row) {
				if ($(this).hasClass('row_selected').toString() == 'true') {
					$(this).removeClass('row_selected');
				}
				all_rows_selected = false;
			});
		}
	});

	$('.pack tr').live('click', function() {
		$(this).toggleClass('row_selected');
	});

	$('#reset').click(function() {
		$('input').val('');
		showError('formulaire vidé', 3000);
	});
	$('.delete_b').click(function() {

		$('.test').html('');
		var lines_to_delete = [];
		$('.pack tbody tr').each(function(i, row) {

			if ($(this).hasClass('row_selected').toString() == 'true') {
				var id_pack_courant = $(this).find('.id_pack').html();
				lines_to_delete.push(id_pack_courant);
			}

		});

		if (lines_to_delete.length > 0) {
			DeleteAll(lines_to_delete, 'pack');
		} else {
			showWarning('Vous n\'avez rien selectionner', 5000);
		}

	});
	$('.display tr').click(function() {

	});
	$('.add_pack').click(function() {
		var data = $('.f_p_add').serializeArray();// convertir les

		$.ajax({
			type : "POST",
			url : "/pack/submit",

			data : data,
			success : function(data) {
				var json = $.parseJSON(data);

				if (json.message == 'erreur') {// maintenant on peut

					showError(json.message, 3000);
				} else {
					showSuccess(json.message, 3000);
				}
				;
			}
		});
	});

	$(".Delete").live('click', function() {
		$('.pack tbody tr').each(function(i, row) {
			$(this).removeClass('row_selected');
		});
		$('.test').html('');
		var row = $(this).parents('tr');

		var action_destination = '/pack/delete';

		var description = row.find('.libelle_pack').html();

		var id_pack = row.find('.id_pack').html();

		Delete(id_pack, description, row, 0, action_destination);
	});
	$('.modify_pack').click(function() {
		var data = $('.f_p_modify').serializeArray();
		$.ajax({
			type : "POST",
			url : "/pack/modify",

			data : data,
			success : function(data) {
				var json = $.parseJSON(data);

				if (json.message == 'erreur') {

					showError(json.message, 3000);
				} else {
					showSuccess(json.message, 3000);
				}
				;
			}
		});
	});

});
