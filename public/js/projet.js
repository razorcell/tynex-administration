$(document).ready(
		function() {
			$('.prix_projet').spinner({ min: 0, max: 1000000, stepping: 100, decimals:2});
			var all_rows_selected = false;
			var status = $(".status").iphoneStyle({ // Custom Label With onChange
				// function
				checkedLabel : "Actif",
				uncheckedLabel : "Interrompu",
				labelWidth : '85px',
				onChange : function() {
					if(this.elem.is(':checked'))
						{//checked
							$('.status_hidden').attr('value','actif');
						}
					else{//not checked
						$('.status_hidden').attr('value','interrompu');
					}
					var chek = $(".status").attr('checked');
					if (chek) {
						$(".disabled_map").fadeOut();
					} else {
						$(".disabled_map").fadeIn();
					}
				}
			});
			$('.f_e_add').submit(function(e) {
				e.preventDefault();
			});
			$('.f_e_modify').submit(function(e) {
				e.preventDefault();
			});
			$('.edit').click(function(){
				$('.projet tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
						});
			});
			$('.selectall').click(function(){
				if(all_rows_selected == false)
					{
						$('.projet tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'false'){
									$(this).addClass('row_selected');
								}
								all_rows_selected = true;
							});
					}
				else{
					$('.projet tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'true'){
									$(this).removeClass('row_selected');
								}
								all_rows_selected = false;
							});
				}
			});
			$('.projet tr').live('click',function(){
				$(this).toggleClass('row_selected');
			});
		
			$('#reset').click(function() {
				$('input:not(.id_projet)').val('');
			//	$('input').val('');
				showError('formulaire vidé', 3000);
			});
			$('.delete_b').click(
					function() {
						
						$('.test').html('');
						var lines_to_delete = [];
						$('.projet tbody tr').each(
								function(i, row) {
									
									if($(this).hasClass('row_selected').toString() == 'true'){
										var id_projet_courant = $(this).find('.id_projet').html();
										lines_to_delete.push(id_projet_courant);
									}
								});
						
						 if(lines_to_delete.length > 0)
							 {
							 DeleteAll(lines_to_delete,'projet');
							 }
						 else
							 {
							 showWarning('Vous n\'avez rien selectionner',5000);
							 }
					});
			$('.display tr').click(function() {
			});
			$('.add_projet').click(function() {
				var form_data = $('.f_p_add').serializeArray();
				var i=0;
				//form validation
				var valide = true;
				if($('.prix').value < 0)
					{
						valide = false;
					}
				else if($('.date_debut').val().length == 0)
					{
						valide = false;
					}
				else if($('.date_fin').val().length == 0)
				{
					valide = false;
				}
				var commande = $('.commande').find('span').html();
				if(commande == 'Veuillez choisir une commande...')
					{
						valide =false;
					}
				var type_projet = $('.type_projet').find('span').html();
				if(type_projet == 'Veuillez choisir un type de projet...')
				{
					valide =false;
				}
				if(valide)
					{
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
					//add commande
					 json_to_send = json_to_send + ',"commande" : "'+commande+'"';
					 //add type projet
					//add commande
					 json_to_send = json_to_send + ',"type_projet" : "'+type_projet+'"';
					// add price
					var prix = $('.prix').attr('value');
				 json_to_send = json_to_send + ',"prix" : "'+prix+'"';
				i=0;
				json_to_send = json_to_send + ',"employes" : [';//open employes json
				$('ul.chzn-choices').find('li').each(function(){
						if($(this).find('span').length > 0){
								if(i==0){
										var employe = $(this).find('span').html();
										json_to_send = json_to_send + '{"name " : "'+employe+'"}';
									}
								else{
										var employe = $(this).find('span').html();
										json_to_send = json_to_send + ',{"name " : "'+employe+'"}';
									}
								i++;
							}
					});
					json_to_send = json_to_send + ']';//close occupations json
					json_to_send = json_to_send + '}';
					//$('.test').html(json_to_send);
					//json_to_send = $.parseJSON(json_to_send);
					$.ajax({ 
						type : "POST",
						url : "/project/submit",
						data : json_to_send,
						success : function(data) {
							//alert('success');
							//var json = $.parseJSON(data);
						
							if (data == 'success') {// maintenant on peut
								showSuccess('Employé ajouté', 3000);
								
							} else {
								showError(data, 3000);
							}
						}
					});
					}else{
						showError('Veuillez revoir le formulaire', 3000);
					}
			});
			$(".Delete").live('click',function() { 
				$('.projet tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
				});
				$('.test').html('');
				  var row=$(this).parents('tr');
				
				  var action_destination = '/project/delete';
				
				  var description = row.find('.nom').html();
				
				  var id_projet = row.find('.id_projet').html();
				
				  Delete(id_projet,description,row,0,action_destination);
			});
			$('.modify_projet').click(function() {
				var form_data = $('.f_e_modify').serializeArray();
				var poste = $('a.chzn-single').find('span').html();
				var i=0;
				//form validation
				var valide = true;
				if($('#lastname').val().length == 0)
					{
						valide = false;
					}
				else if($('#firstname').val().length == 0)
					{
						valide = false;
					}
				else if($('.email').val().length == 0)
				{
					valide = false;
				}
				else if($('#tel').val().length == 0)
				{
					valide = false;
				}
				else if($('#username').val().length == 0)
				{
					valide = false;
				}
				else if($('#password').val().length == 0)
				{
					valide = false;
				}
				else if($('#passwordCon').val().length == 0)
				{
					valide = false;
				}
				var pass = $('#password').attr("value");
				var passCon = $('#passwordCon').attr("value");
				if(pass != passCon || pass == '' || passCon == '')
					{
						valide = false;
					}
				var poste = $('.chzn-single').find('span').html();
				if(poste == 'Veuillez choisir un poste...')
					{
						valide =false;
						
					}
				if(valide)
					{
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
					//add id value
					var id = $('.id_projet').attr('value');
					 json_to_send = json_to_send + ',"id" : "'+id+'"';
					 //add 'poste' value
				 json_to_send = json_to_send + ',"poste" : "'+poste+'"';
				 //add gender !!!! i don't know why it doesn't get added automaticly it does for add projet
				 if($('label[for="radio-1"]').hasClass('checked')) {
					 json_to_send = json_to_send + ',"gender" : "0"';
					 }
				 else{
					 json_to_send = json_to_send + ',"gender" : "1"';
				 }
				 if($('ul.chzn-choices').find('li').length > 1){
					 	i=0;
						json_to_send = json_to_send + ',"occupations" : [';//open occupations json
						$('ul.chzn-choices').find('li').each(function(){
								if($(this).find('span').length > 0)//if span exists
									{
										if(i==0)
											{
												var occupation = $(this).find('span').html();
												json_to_send = json_to_send + '{"name " : "'+occupation+'"}';
											}
										else
											{
												var occupation = $(this).find('span').html();
												json_to_send = json_to_send + ',{"name " : "'+occupation+'"}';
											}
										i++;
									}
								
							});//la fin de l'ajout des occupations à la chaine de caractére qui va etre envoyer au serveur
							json_to_send = json_to_send + ']';//close occupations json
				 }
					json_to_send = json_to_send + '}';
					$('.test').html(json_to_send);
					//json_to_send = $.parseJSON(json_to_send);
					
					
					$.ajax({ 
						type : "POST",
						url : "/project/modify",
						data : json_to_send,
						success : function(data) {
							//var json = $.parseJSON(data);
						
							if (data == 'success') {// maintenant on peut
								showSuccess('Mise à jour avec succée', 3000);
								setTimeout("Refresh()", 500);
								
							} else {
								showError(data, 100000);
							}
						}
					
					});
					}else{
						showError('Veuillez revoir le formulaire', 3000);
					}
				
			});//end modify.click()
	
		});

