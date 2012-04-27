$(document)
		.ready(
				function() {
					
					var all_rows_selected = false;
					$('form#entreprise').validationEngine();
					$('form#particulier').validationEngine();

					$(".status").iphoneStyle({ // Custom Label With onChange
						// function
						checkedLabel : "Actif",
						uncheckedLabel : "Interrompu",
						labelWidth : '85px',
						onChange : function() {
							if(this.elem.is(':checked'))
								{//particulier
								
								}
							else{//entreprise
								
							}
							var chek = $(".status").attr('checked');
							if (chek) {
								$(".disabled_map").fadeOut();
							} else {
								$(".disabled_map").fadeIn();
							}
							// $("#show_service").click(function () {
							//$(".formEl_b").slideToggle("slow");
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
						$('.projet tbody tr').each(function(i, row) {
							$(this).removeClass('row_selected');
						});
					});

					$('.selectall')
							.click(
									function() {
										if (all_rows_selected == false) {
											$('.projet tbody tr')
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
											$('.projet tbody tr')
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

					$('.projet tr').live('click', function() {
						$(this).toggleClass('row_selected');
					});

					$('#reset_p').click(function() {
						$('input:not(.id_projet_p)').val('');//ne pas supprimer id_projet

						// $('input').val('');
						showError('formulaire vidé', 3000);
					});
					$('#reset_e').click(function() {
						$('input:not(.id_projet_e)').val('');

						// $('input').val('');
						showError('formulaire vidé', 3000);
					});

					
					$('.delete_b')
							.click(
									function() {

										$('.test').html('');
										var lines_to_delete = [];
										$('.projet tbody tr')
												.each(
														function(i, row) {

															if ($(this)
																	.hasClass(
																			'row_selected')
																	.toString() == 'true') {
																var id_projet_courant = $(
																		this)
																		.find(
																				'.id_projet')
																		.html();
																lines_to_delete
																		.push(id_projet_courant);
															}

														});

										if (lines_to_delete.length > 0) {
											DeleteAll(lines_to_delete, 'projet');
										} else {
											showWarning(
													'Vous n\'avez rien selectionner',
													5000);
										}

									});
					$('.display tr').click(function() {

					});
					$('.add_projet_entreprise').click(function() {
						
										var form_data;
										var json_to_send = '{';
										var i = 0;
										var valide = true;

										//$('.test').html('entreprise');
										// projet est une entreprise
										
										form_data = $('.f_c_e_add')
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
											json_to_send = json_to_send
													+ ',"type":"entreprise"';
											json_to_send = json_to_send + '}';
											$
													.ajax({
														type : "POST",
														url : "/projet/submit",
														data : json_to_send,
														success : function(data) {
															// var json =
															// $.parseJSON(data);

															if (data == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'Entreprise projete ajoutée',
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

									});

					$('.add_projet_particulier')
							.click(
									function() {
										var form_data;
										var json_to_send = '{';
										var i = 0;
										var valide = true;
										//$('.test').html('particulier');
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
														url : "/projet/submit",
														data : json_to_send,
														success : function(data) {
															// var json =
															// $.parseJSON(data);

															if (data == 'success') {// maintenant
																// on
																// peut
																showSuccess(
																		'projet particulier ajouté',
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
								$('.projet tbody tr').each(function(i, row) {
									$(this).removeClass('row_selected');
								});
								$('.test').html('');
								var row = $(this).parents('tr');

								var action_destination = '/projet/delete';

								var description = row.find('.nom').html();

								var id_projet = row.find('.id_projet').html();

								Delete(id_projet, description, row, 0,
										action_destination);
							});
					$('.modify_projet_entreprise').click(function() {
						var form_data;
						var json_to_send = '{';
						var i = 0;
						var valide = true;

						//$('.test').html('entreprise');
						// projet est une entreprise
						
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
							//add id value
							var id = $('.id_projet').attr('value');
							 json_to_send = json_to_send + ',"id" : "'+id+'"';
							 //gender
							 if($('label[for="radio-1"]').hasClass('checked')) {
								 json_to_send = json_to_send + ',"gender_r" : "0"';
								 }
							 else{
								 json_to_send = json_to_send + ',"gender_r" : "1"';
							 }
							 
							json_to_send = json_to_send
									+ ',"type":"entreprise"';
							json_to_send = json_to_send + '}';
							$
									.ajax({
										type : "POST",
										url : "/projet/modify",
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

					});// end modify_projet_entreprise.click()
					$('.modify_projet_particulier')
					.click(
							function() {
								var form_data;
								var json_to_send = '{';
								var i = 0;
								var valide = true;
								//$('.test').html('particulier');
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
									//add id value
									var id = $('.id_projet').attr('value');
									 json_to_send = json_to_send + ',"id" : "'+id+'"';
									 //gender
									 if($('label[for="radio-1"]').hasClass('checked')) {
										 json_to_send = json_to_send + ',"gender_p" : "0"';
										 }
									 else{
										 json_to_send = json_to_send + ',"gender_p" : "1"';
									 }
									 
									json_to_send = json_to_send
											+ ',"type":"particulier"';
									json_to_send = json_to_send + '}';
									$
											.ajax({
												type : "POST",
												url : "/projet/modify",
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
							});//end modify projet particulier
				});
