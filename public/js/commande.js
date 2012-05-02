$(document)
		.ready(
				function() {

					var all_rows_selected = false;
					$('form#add_projet').validationEngine();
					$('form#add_service').validationEngine();

					$(".type").iphoneStyle({ // Custom Label With onChange
						// function
						checkedLabel : "Service",
						uncheckedLabel : "Projet",
						labelWidth : '85px',
						onChange : function() {
							if (this.elem.is(':checked')) {// particulier
								$('#add_projet').removeClass('visible');
								$('#add_service').addClass('visible');
								$('#add_projet').validationEngine('hideAll');
								$('#add_service').fadeIn();
								$('#add_projet').fadeOut();
							} else {// entreprise
								$('#add_service').removeClass('visible');
								$('#add_projet').addClass('visible');
								$('#add_service').validationEngine('hideAll');
								$('#add_service').fadeOut();
								$('#add_projet').fadeIn();
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
					$('.add_commande_projet')
							.click(
									function() {

										var form_data = $('.f_p_add')
												.serializeArray();
										var i = 0;
										// form validation
										var valide = true;
										if ($('.prix').value == 0) {
											valide = false;
										} else if ($('.date_debut').val().length == 0) {
											valide = false;
										} else if ($('.date_fin').val().length == 0) {
											valide = false;
										}
										var commande = $('.commande').find(
												'span').html();
										if (commande == 'Veuillez choisir une commande...') {
											valide = false;
										}
										var type_projet = $('.type_projet')
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
											// add commande
											json_to_send = json_to_send
													+ ',"commande" : "'
													+ commande + '"';
											// add type projet
											// add commande
											json_to_send = json_to_send
													+ ',"type_projet" : "'
													+ type_projet + '"';

											var progression = $('.progression')
													.attr('value');
											json_to_send = json_to_send
													+ ',"progression" : "'
													+ progression + '"';
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
																		var projet = $(
																				this)
																				.find(
																						'span')
																				.html();
																		json_to_send = json_to_send
																				+ '{"name " : "'
																				+ projet
																				+ '"}';
																	} else {
																		var projet = $(
																				this)
																				.find(
																						'span')
																				.html();
																		json_to_send = json_to_send
																				+ ',{"name " : "'
																				+ projet
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

															if (json.reponse == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'Projet ajouté',
																		3000);

															} else {
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
										var form_data;
										var json_to_send = '{';
										var i = 0;
										var valide = true;
										// $('.test').html('particulier');
										form_data = $('.f_c_p_add')
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
											json_to_send = json_to_send
													+ ',"type":"particulier"';
											json_to_send = json_to_send + '}';
											$
													.ajax({
														type : "POST",
														url : "/commande/submit",
														data : json_to_send,
														success : function(data) {
															// var json =
															// $.parseJSON(data);

															if (data == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'commande particulier ajouté',
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
											var id = $('.id_commande').attr(
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
				});
