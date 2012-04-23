$(document).ready(
		function() {
			var all_rows_selected = false;
			$('form#entreprise').validationEngine();		
			$('form#particulier').validationEngine();	
			
			$(".type").iphoneStyle({ //  Custom Label  With  onChange function
				  checkedLabel: "Particulier",
				  uncheckedLabel: "Entreprise",
				  labelWidth:'85px',
				  onChange: function() {
					 $('#validation').validationEngine('hideAll');
					  
					  	if($('#particulier').hasClass('visible')){
					  		$('#particulier').removeClass('visible');
					  		$('#entreprise').addClass('visible');
					  		$('#particulier').validationEngine('hideAll');
					  	}else{
					  		$('#entreprise').removeClass('visible');
					  		$('#particulier').addClass('visible');
					  		$('#entreprise').validationEngine('hideAll');
					  	}
						var chek=$(".type").attr('checked');
							  if(chek){
								  $(".disabled_map").fadeOut();
							  }else{
								 $(".disabled_map").fadeIn();
							  }
						//$("#show_service").click(function () {
		      					$(".f_c_add").slideToggle("slow");
		    				//});
				}
			});
			
			
			$('.f_c_add').submit(function(e) {
			
				e.preventDefault();
			});
			$('.f_c_modify').submit(function(e) {
			
				e.preventDefault();
			});
			
			$('.edit').click(function(){
				$('.client tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
						});
			});

			$('.selectall').click(function(){
				if(all_rows_selected == false)
					{
						$('.client tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'false'){
									$(this).addClass('row_selected');
								}
								all_rows_selected = true;
							});
					}
				else{
					$('.client tbody tr').each(
							function(i, row) {
								if($(this).hasClass('row_selected').toString() == 'true'){
									$(this).removeClass('row_selected');
								}
								all_rows_selected = false;
							});
				}
			});
			
			$('.client tr').live('click',function(){
				$(this).toggleClass('row_selected');
			});
		
			$('#reset').click(function() {
				$('input:not(.id_client)').val('');

			//	$('input').val('');
				showError('formulaire vidé', 3000);
			});
			$('.delete_b').click(
					function() {
						
						$('.test').html('');
						var lines_to_delete = [];
						$('.client tbody tr').each(
								function(i, row) {
									
									if($(this).hasClass('row_selected').toString() == 'true'){
										var id_client_courant = $(this).find('.id_client').html();
										lines_to_delete.push(id_client_courant);
									}
								
								});
						
						 if(lines_to_delete.length > 0)
							 {
							 DeleteAll(lines_to_delete,'client');
							 }
						 else
							 {
							 showWarning('Vous n\'avez rien selectionner',5000);
							 }
				 
				
						
					});
			$('.display tr').click(function() {
				
			});
			$('.add_client').click(function() {
				var form_data = $('.f_c_add').serializeArray();
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
				 json_to_send = json_to_send + ',"poste" : "'+poste+'"';
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
						
					});
					json_to_send = json_to_send + ']';//close occupations json
					json_to_send = json_to_send + '}';
					//$('.test').html(json_to_send);
					//json_to_send = $.parseJSON(json_to_send);
					
					
					$.ajax({ 
						type : "POST",
						url : "/client/submit",
						data : json_to_send,
						success : function(data) {
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
				
				
			});
		
			$(".Delete").live('click',function() { 
				$('.client tbody tr').each(
						function(i, row) {				
								$(this).removeClass('row_selected');
				});
				$('.test').html('');
				  var row=$(this).parents('tr');
				
				  var action_destination = '/client/delete';
				
				  var description = row.find('.nom').html();
				
				  var id_client = row.find('.id_client').html();
				
				  Delete(id_client,description,row,0,action_destination);
			});
			$('.modify_client').click(function() {
				var form_data = $('.f_c_modify').serializeArray();
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
					var id = $('.id_client').attr('value');
					 json_to_send = json_to_send + ',"id" : "'+id+'"';
					 //add 'poste' value
				 json_to_send = json_to_send + ',"poste" : "'+poste+'"';
				 //add gender !!!! i don't know why it doesn't get added automaticly it does for add client
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
						url : "/client/modify",
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

