$(document).ready(
		function() {
			var all_rows_selected = false;
			$('.f_e_add').submit(function(e) {
			
				e.preventDefault();
			});
			$('.f_e_modify').submit(function(e) {
			
				e.preventDefault();
			});
			
			$('.edit').click(function(){
				$('.employe tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
						});
			});

			$('.selectall').click(function(){
				if(all_rows_selected == false)
					{
						$('.employe tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'false'){
									$(this).addClass('row_selected');
								}
								all_rows_selected = true;
							});
					}
				else{
					$('.employe tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'true'){
									$(this).removeClass('row_selected');
								}
								all_rows_selected = false;
							});
				}
			});
			
			$('.employe tr').live('click',function(){
				$(this).toggleClass('row_selected');
			});
		
			

			$('#reset').click(function() {
				$('input').val('');
				showError('formulaire vidé', 3000);
			});
			$('.delete_b').click(
					function() {
						
						$('.test').html('');
						var lines_to_delete = [];
						$('.employe tbody tr').each(
								function(i, row) {
									
									if($(this).hasClass('row_selected').toString() == 'true'){
										var id_employe_courant = $(this).find('.id_employe').html();
										lines_to_delete.push(id_employe_courant);
									}
								
								});
						
						 if(lines_to_delete.length > 0)
							 {
							 DeleteAll(lines_to_delete,'employe');
							 }
						 else
							 {
							 showWarning('Vous n\'avez rien selectionner',5000);
							 }
				 
				
						
					});
			$('.display tr').click(function() {
				
			});
			$('.add_employe').click(function() {
				var form_data = $('.f_e_add').serializeArray();
				var poste = $('a.chzn-single').find('span').html();
				var i=0;
				/*json = {};
				for(i in form_data)
					{
						json[form_data[i].name] = form_data[i].value;
					}*/
				/*var selected_occupations = [];
				$('ul.chzn-choices').find('li').each(function(){
					if($(this).find('span').length > 0)
						{
							selected_occupations.push($(this).find('span').html());
						}
				});*/
				
				var json_to_send = '{';
				
				for(i=0;i<form_data.length;i++)
					{
						if(i==0){
								json_to_send = json_to_send + '"'+form_data[i].name+'" : "'+form_data[i].value+'"';
							}
						else{
							json_to_send = json_to_send + ',"'+form_data[i].name+'" : "'+form_data[i].value+'"';

						}
					}
			 json_to_send = json_to_send + ',"poste" : "'+poste+'"';
			i=0;
			$('ul.chzn-choices').find('li').each(function(){
					if($(this).find('span').length > 0)//if span exists
						{
							var occupation = $(this).find('span').html();
							json_to_send = json_to_send + ',"occupation'+i+'" : "'+occupation+'"';
							i++;
						}
					
				});
				json_to_send = json_to_send + '}';
				//$('.test').html(json_to_send);
				json_to_send = $.parseJSON(json_to_send);
				$.ajax({ 
					type : "POST",
					url : "/employe/submit",
					data : json_to_send,
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
		
			$(".Delete").live('click',function() { 
				$('.employe tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
				});
				$('.test').html('');
				  var row=$(this).parents('tr');
				
				  var action_destination = '/employe/delete';
				
				  var description = row.find('.nom').html();
				
				  var id_employe = row.find('.id_employe').html();
				
				  Delete(id_employe,description,row,0,action_destination);
			});
			$('.modify_employe').click(function() {
				var data = $('.f_e_modify').serializeArray();
			
				
				$.ajax({ 
					type : "POST",
					url : "/employe/modify",
					
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
