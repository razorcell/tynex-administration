$(document)
		.ready(
				function() {
					// initialize
					// id_commande input
					// value
					var all_rows_selected = false;
					$('form#add_projet').validationEngine();
					$('form#add_service').validationEngine();

					$(".type").iphoneStyle({ // Custom Label With onChange
						// function
						checkedLabel : "Service",
						uncheckedLabel : "Projet",
						labelWidth : '85px',
						onChange : function() {
							if (this.elem.is(':checked')) {// add service
								$('#add_projet').removeClass('visible');
								$('#add_service').addClass('visible');
								$('#add_projet').validationEngine('hideAll');
								$('#add_service').fadeIn();
								$('#add_projet').fadeOut();
								// $('.request_type').attr('value', 'service');
							} else {// add project
								$('#add_service').removeClass('visible');
								$('#add_projet').addClass('visible');
								$('#add_service').validationEngine('hideAll');
								$('#add_service').fadeOut();
								$('#add_projet').fadeIn();
								// $('.request_type').attr('value', 'projet');
							}
							$('#validation').validationEngine('hideAll');

							var chek = $(".type").attr('checked');
							if (chek) {
								$(".disabled_map").fadeOut();
							} else {
								$(".disabled_map").fadeIn();
							}
							// $("#show_service").click(function () {
							// $(".formEl_b").slideToggle("slow");
							// });
						}
					});

					$('.f_c_e_add').submit(function(e) {

						e.preventDefault();
					});
					$('.f_c_p_add').submit(function(e) {

						e.preventDefault();
					});
					$('.f_c_e_modify').submit(function(e) {

						e.preventDefault();
					});
					$('.f_c_p_modify').submit(function(e) {

						e.preventDefault();
					});

					$('.edit').click(function() {
						$('.commande tbody tr').each(function(i, row) {
							$(this).removeClass('row_selected');
						});
					});

					$('.selectall')
							.click(
									function() {
										if (all_rows_selected == false) {
											$('.commande tbody tr')
													.each(
															function(i, row) {
																if ($(this)
																		.hasClass(
																				'row_selected')
																		.toString() == 'false') {
																	$(this)
																			.addClass(
																					'row_selected');
																}
																all_rows_selected = true;
															});
										} else {
											$('.commande tbody tr')
													.each(
															function(i, row) {
																if ($(this)
																		.hasClass(
																				'row_selected')
																		.toString() == 'true') {
																	$(this)
																			.removeClass(
																					'row_selected');
																}
																all_rows_selected = false;
															});
										}
									});

					$('.commande tr').live('click', function() {
						$(this).toggleClass('row_selected');
					});

					$('#reset_p').click(function() {
						$('input:not(.id_commande_p)').val('');// ne pas
						// supprimer
						// id_commande

						// $('input').val('');
						showError('formulaire vidé', 3000);
					});
					$('#reset_e').click(function() {
						$('input:not(.id_commande_e)').val('');

						// $('input').val('');
						showError('formulaire vidé', 3000);
					});

					$('.delete_b')
							.click(
									function() {

										$('.test').html('');
										var lines_to_delete = [];
										$('.commande tbody tr')
												.each(
														function(i, row) {

															if ($(this)
																	.hasClass(
																			'row_selected')
																	.toString() == 'true') {
																var id_commande_courant = $(
																		this)
																		.find(
																				'.id_commande')
																		.html();
																lines_to_delete
																		.push(id_commande_courant);
															}

														});

										if (lines_to_delete.length > 0) {
											DeleteAll(lines_to_delete,
													'commande');
										} else {
											showWarning(
													'Vous n\'avez rien selectionner',
													5000);
										}

									});
					$('.display tr').click(function() {

					});
					$('.test_alert').click(function(){
						alert($('.id_commande').find('input#id_commande').attr('value'));
					});
					$('.add_commande_projet')
							.click(
									function() {
										var id_commande = null;
										var form_data = $('.f_p_add')
												.serializeArray();
										var i = 0;
										// form validation
										var valide = true;
										if ($('.prix_projet').value == 0) {
											valide = false;
										} else if ($('.date_debut').val().length == 0) {
											valide = false;
										} else if ($('.date_fin').val().length == 0) {
											valide = false;
										}
										var type_projet = $('.type_projet')
												.find('span').html();
										if (type_projet == 'Veuillez choisir un type de projet...') {
											valide = false;
										}
										var client = $('.client')// add
										// client
										.find('span').html();
										if (type_projet == 'Veuillez choisir un type de projet...') {
											valide = false;
										}
										if (valide) {
											var json_to_send = '{';

											for (i = 0; i < form_data.length; i++) {
												if (i == 0) {
													json_to_send = json_to_send
															+ '"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												} else {
													if (form_data[i].name == 'prix_projet') {
														var price = form_data[i].value
																.replace(',',
																		'');
														json_to_send = json_to_send
																+ ',"'
																+ form_data[i].name
																+ '" : "'
																+ price + '"';
													} else {
														json_to_send = json_to_send
																+ ',"'
																+ form_data[i].name
																+ '" : "'
																+ form_data[i].value
																+ '"';
													}
												}
											}
											// add request_type

											json_to_send = json_to_send
													+ ',"request_type" : "'
													+ 'projet' + '"';
											// add client
											json_to_send = json_to_send
													+ ',"client" : "' + client
													+ '"';
											// add commande
											if ($('.id_commande').find('input#id_commande').attr('value') > 0) {
												id_commande = $('.id_commande').find('input#id_commande')
												.attr('value');
												json_to_send = json_to_send
														+ ',"id_commande" : "'
														+ id_commande
														+ '"';
											}

											// add type projet

											json_to_send = json_to_send
													+ ',"type_projet" : "'
													+ type_projet + '"';
											// add progression
											var progression = $('.progression')
													.attr('value');
											json_to_send = json_to_send
													+ ',"progression" : "'
													+ progression + '"';
											var description_commande = $(
													'.description_commande')
													.val();
											json_to_send = json_to_send
													+ ',"description_commande" : "'
													+ description_commande
													+ '"';
											i = 0;
											json_to_send = json_to_send
													+ ',"employes" : [';// open
											// employe
											// json
											$('ul.chzn-choices')
													.find('li')
													.each(
															function() {
																if ($(this)
																		.find(
																				'span').length > 0) {
																	if (i == 0) {
																		var employe = $(
																				this)
																				.find(
																						'span')
																				.html();
																		json_to_send = json_to_send
																				+ '{"name " : "'
																				+ employe
																				+ '"}';
																	} else {
																		var employe = $(
																				this)
																				.find(
																						'span')
																				.html();
																		json_to_send = json_to_send
																				+ ',{"name " : "'
																				+ employe
																				+ '"}';
																	}
																	i++;
																}
															});
											json_to_send = json_to_send + ']';// close
											// employe
											// json
											json_to_send = json_to_send + '}';
											// $('.test').html(json_to_send);
											// json_to_send =
											// $.parseJSON(json_to_send);
											$
													.ajax({
														type : "POST",
														url : "/commande/submit",
														data : json_to_send,
														success : function(data) {
															// alert('success');
															var json = $
																	.parseJSON(data);

															if (json.message == 'success') {// COMMANDE
																// PROJET
																// SI
																// id_commande
																// exists
																$('div.client').hide();
																$('.commande_description').hide();
																if(json.commande_exists == 'non'){//si commande nouvelle
																	$(
																			'.id_commande')
																			.find(
																					'input#id_commande')
																			.attr(
																					'value',
																					json.id_commande);
																	$(
																			'.id_commande')
																			.css(
																					{
																						'display' : ''
																					});
																	showSuccess(
																			'Commande et Projet ajoutés',
																			3000);
															}else{
																//si commande existe deja
														showSuccess(
																'Projet ajoutés',
																3000);
															}
															} else {// SI ERROR
																showError(
																		json.reponse,
																		3000);
															}
														}
													});
										} else {
											showError(
													'Veuillez revoir le formulaire',
													3000);
										}

									});

					$('.add_commande_service')
							.click(
									function() {
										var form_data = $('.f_s_add')
												.serializeArray();
										var i = 0;
										var pack = null;
										// get pack

										// form validation
										var valide = true;
										if ($('.prix').value == 0) {
											valide = false;
										} else if ($('.date_debut').val().length == 0) {
											valide = false;
										} else if ($('.date_fin').val().length == 0) {
											valide = false;
										}

										var type_service = $('.type_service')
												.find('span').html();
										if (type_service == 'Veuillez choisir un type de service...') {
											valide = false;
										} else {// si type de service choisi
											if ($('div.pack').hasClass(
													'visible')) {
												if ($('.list_packs').find(
														'li.ui-selected').length > 0) {
													pack = $('.list_packs')
															.find(
																	'li.ui-selected')
															.html();
												} else {// il y a des pack mais
													// auccun choisi
													valide = false;
												}
											} else {// ca marche il n'existe
												// aucun pack
												pack = 'aucun';
											}
										}
										if (valide) {
											var json_to_send = '{';

											for (i = 0; i < form_data.length; i++) {
												if (i == 0) {
													json_to_send = json_to_send
															+ '"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												} else {
													if (form_data[i].name == 'prix') {
														var price = form_data[i].value
																.replace(',',
																		'');
														json_to_send = json_to_send
																+ ',"'
																+ form_data[i].name
																+ '" : "'
																+ price + '"';
													} else {
														json_to_send = json_to_send
																+ ',"'
																+ form_data[i].name
																+ '" : "'
																+ form_data[i].value
																+ '"';
													}
												}
											}
											// add request_type

											json_to_send = json_to_send
													+ ',"request_type" : "'
													+ 'service' + '"';
											// add client
											json_to_send = json_to_send
													+ ',"client" : "' + client
													+ '"';
											// add commande
											if ($('.id_commande').find('input#id_commande').attr('value').length > 0) {
												json_to_send = json_to_send
														+ ',"id_commande" : "'
														+ $('.id_commande')
																.attr('value')
														+ '"';
											}// add description_commande
											var description_commande = $(
													'.description_commande')
													.val();
											json_to_send = json_to_send
													+ ',"description_commande" : "'
													+ description_commande
													+ '"';
											// add type service
											json_to_send = json_to_send
													+ ',"type_service" : "'
													+ type_service + '"';
											// add price
											json_to_send = json_to_send
													+ ',"pack" : "' + pack
													+ '"';
											i = 0;
											json_to_send = json_to_send + '}';
											// $('.test').html(json_to_send);
											// json_to_send =
											// $.parseJSON(json_to_send);
											$
													.ajax({
														type : "POST",
														url : "/service/submit",
														data : json_to_send,
														success : function(data) {
															// alert('success');
															var json = $
																	.parseJSON(data);
															if (json.message == 'success') {// COMMANDE
																// PROJET
																// SI
																// id_commande
																// exists
																if (json.id_commande.length > 0) {// SI
																	// NOUVELLE
																	// COMMANDE
																	$(
																			'.id_commande')
																			.find(
																					'input#id_commande')
																			.attr(
																					'value',
																					json.id_commande);
																	$(
																			'.id_commande')
																			.css(
																					{
																						'display' : ''
																					});
																	showSuccess(
																			'Commande et Service ajoutés',
																			3000);
																} else {// SI
																	// COMMANDE
																	// EXISTSTE
																	// DEJA
																	showSuccess(
																			'Service ajouté',
																			3000);
																}
															} else {// SI ERROR
																showError(
																		json.reponse,
																		3000);
															}
														}
													});
										} else {
											showError(
													'Veuillez revoir le formulaire',
													3000);
										}

									});

					$(".Delete").live(
							'click',
							function() {
								$('.commande tbody tr').each(function(i, row) {
									$(this).removeClass('row_selected');
								});
								$('.test').html('');
								var row = $(this).parents('tr');

								var action_destination = '/commande/delete';

								var description = row.find('.nom').html();

								var id_commande = row.find('.id_commande')
										.html();

								Delete(id_commande, description, row, 0,
										action_destination);
							});
					$('.modify_commande_entreprise')
							.click(
									function() {
										var form_data;
										var json_to_send = '{';
										var i = 0;
										var valide = true;

										// $('.test').html('entreprise');
										// commande est une entreprise

										form_data = $('.f_c_e_modify')
												.serializeArray();
										if ($('.nom_e').val().length == 0) {
											valide = false;
										} else if ($('.email_e').val().length == 0) {
											valide = false;
										} else if ($('.tel_e').val().length == 0) {
											valide = false;
										} else if ($('.nom_r').val().length == 0) {
											valide = false;
										}
										if (valide) {
											for (i = 0; i < form_data.length; i++) {
												if (i == 0) {
													json_to_send = json_to_send
															+ '"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												} else {
													json_to_send = json_to_send
															+ ',"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												}
											}
											// add id value
											var id = $('.id_commande').attr(
													'value');
											json_to_send = json_to_send
													+ ',"id" : "' + id + '"';
											// gender
											if ($('label[for="radio-1"]')
													.hasClass('checked')) {
												json_to_send = json_to_send
														+ ',"gender_r" : "0"';
											} else {
												json_to_send = json_to_send
														+ ',"gender_r" : "1"';
											}

											json_to_send = json_to_send
													+ ',"type":"entreprise"';
											json_to_send = json_to_send + '}';
											$
													.ajax({
														type : "POST",
														url : "/commande/modify",
														data : json_to_send,
														success : function(data) {
															// var json =
															// $.parseJSON(data);

															if (data == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'Modification de l\'entreprise réussie',
																		3000);
															} else {
																showError(data,
																		3000);
															}
														}
													});
										} else {
											showError(
													'Veuillez revoir le formulaire de l\'entreprise',
													3000);
										}

									});// end
					// modify_commande_entreprise.click()
					$('.modify_commande_particulier')
							.click(
									function() {
										var form_data;
										var json_to_send = '{';
										var i = 0;
										var valide = true;
										// $('.test').html('particulier');
										form_data = $('.f_c_p_modify')
												.serializeArray();

										if ($('.nom_p').val().length == 0) {
											valide = false;
										}
										if ($('.email_p').val().length == 0) {
											if ($('.tel_p').val().length == 0) {
												valide = false;
											}
										}
										if (valide) {
											for (i = 0; i < form_data.length; i++) {
												if (i == 0) {
													json_to_send = json_to_send
															+ '"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												} else {
													json_to_send = json_to_send
															+ ',"'
															+ form_data[i].name
															+ '" : "'
															+ form_data[i].value
															+ '"';
												}
											}
											// add id value
											var id = $('.id_commande').find('input#id_commande').attr(
													'value');
											json_to_send = json_to_send
													+ ',"id" : "' + id + '"';
											// gender
											if ($('label[for="radio-1"]')
													.hasClass('checked')) {
												json_to_send = json_to_send
														+ ',"gender_p" : "0"';
											} else {
												json_to_send = json_to_send
														+ ',"gender_p" : "1"';
											}

											json_to_send = json_to_send
													+ ',"type":"particulier"';
											json_to_send = json_to_send + '}';
											$
													.ajax({
														type : "POST",
														url : "/commande/modify",
														data : json_to_send,
														success : function(data) {
															// var json =
															// $.parseJSON(data);

															if (data == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'Modification réussie',
																		3000);
															} else {
																showError(data,
																		3000);
															}
														}
													});
										} else {
											showError(
													'Veuillez revoir le formulaire de particulier',
													3000);
										}
									});// end modify commande particulier
					$('#id_commande').attr('value','');//clear id after page refresh
				});
