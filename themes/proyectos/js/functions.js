$(function(){





	var body = $('body'),
	files_tree = $('#files_tree'),
	content = $('.content'),
	menu = $('#menu');

	$('#listado tr').click(function() {

		$(".select").removeClass("select");
		$(this).addClass("select");

	});

	//Prevent page reload in empty href

	var menu_desplegado = false;
	var animacion_curso = false;
	var menu_original_height = menu.height();

	$(window).scroll(function(event) {

		var scroll_window = $(window).scrollTop();

		if( scroll_window > 180 ) {

			if( !menu_desplegado && !animacion_curso ) {
				animacion_curso = true;

				menu.css('position', 'fixed')
				.css('zIndex', 3)
				.css('top', -50);

				content.css( 'top', menu_original_height);

				menu.animate({ height: '62px', top: '-6px'},'fast', function() {


					animacion_curso = false;
					menu_desplegado = true;

				});

			} 

		} else {

			if( menu_desplegado && !animacion_curso) {

				animacion_curso = true;

				menu.animate({ height: menu_original_height, top: '0px'},'fast', function() {

					$(this).css('position', 'relative')
					.css('zIndex', 0);

					content.css( 'top', 0);

					animacion_curso = false;
					menu_desplegado = false;

				});

			}

		}


	});


	/* Top menu */

	body.on('click', '#options ul li', function(e){

		e.stopPropagation();
		e.preventDefault();


		var this_element = $(this),
		drop = this_element.find('.drop-top');

		drop.click(function(event){
			event.stopPropagation();
		});


		if(this_element.hasClass('active')){

			this_element.removeClass('active');

		} else{

			this_element.addClass('active');
		}

		drop.fadeToggle('fast');
	});

	/* Notificaciones */

	body.on('click', '#notifications-icon', function(){

		var globito = $(this).find('span');

		if(globito.length){
			globito.remove();

			// Update de notificaciones como leídas
		}
	});


	//Cerrar el cuadro de búsqueda cuando se haga click fuera ##########################
	body.click(function() {

		var options_li = $("#options ul li.active"),
		drop = options_li.find('.drop-top');

		options_li.removeClass("toggled");
		drop.fadeToggle('fast');
		options_li.removeClass('active');

	});



	/**
	 * TODO: PANEL LATERAL
	 */
	body.on('click', '.panel-trigger', function(e){
		if ($('#panel').css('display') == 'block') {
			$('#front').css('width', '96%');
			$('#panel').css('display', 'none');
		} else {
			$('#front').css('width', '64%');
			$('#panel').css('display', 'block');			
		}
	});


	//Close panel
	body.on('click', '#close-panel', function() {

		var panel = $('#panel'),
		searchInTable = $('#searchInTable');

		panel.animate({
			opacity: 0
		}, 200, function(){
			panel.remove();
			content.animate({
				width: '96%'
			}, 200, function(){

			});
		});

		searchInTable.animate({width: '400px'});
	});



	/* *****	TOOLTIPS EN DIFERENTES  	*****************************************************				*/
	/* #####	DIRECCIONES VISTAS			#####################################################				*/
	/* *****	SELCTOR DE CLASES 			*****************************************************				*/

	if($.fn.tipsy) {
		var gravity = ['n', 'ne', 'e', 'se', 's', 'sw', 'w', 'nw'];
		for(var i in gravity) {

			$(".mws-tooltip-"+gravity[i]).tipsy({gravity: gravity[i], live: true, delayIn: 300});

			$('input[class="mws-form-tooltip-'+gravity[i]+'"], select[class="mws-form-tooltip-'+gravity[i]+'"], textarea[class="mws-form-tooltip-'+gravity[i]+'"]').tipsy({gravity: gravity[i],trigger: 'focus',  live: true});
		}
	}


	/* *****	CARGA DE VISTAS,  				*****************************************************			*/
	/* #####	AÑADIR, REEMPLAZAR(ACTUALIZAR)	#####################################################			*/
	/* *****	Y BORRAR VÍA AJAX 				*****************************************************			*/



	var loading_ajax = false;

	body.on('click', '.ajax_action', function(event) {

		event.preventDefault();

		if( !loading_ajax ) {

			loading_ajax = true;
			ajax_action( $(this), 'button');
		}


	}); //End on click ajax action

	body.on('submit', '.ajax_action_submit', function(event) {

		event.preventDefault();

		if( !loading_ajax ) {

			loading_ajax = true;
			ajax_action( $(this), 'form');
		}


	}); //End on click ajax action


	function ajax_action(this_element, type, custom_data, callback) {

		var panel 			= $('#panel');
		var data_action		= this_element.attr('data-action');
		var data_view		= this_element.attr('data-view');
		var data_target		= this_element.attr('data-target');
		var data_post		= "ajaxRequest=" + encodeURIComponent('true');
		var close_panel		= this_element.attr('close-panel');
		var redirect_view	= this_element.attr('redirect-view');


		if( type == 'form' ) {
			var form_parent	= this_element.closest('form');
			data_view		= form_parent.attr('action');
			data_post		+= "&" + form_parent.serialize();
		}

		if( type == 'manual' ) {
			data_view		= custom_data.data_view;
			data_post		= data_post + "&" + custom_data.data_post;
			close_panel		= custom_data.close_panel;
		}

		if( data_view !== null ) {

			$.ajax({

				type: "POST",
				url: data_view,
				data: data_post,
				complete: function(xhr, ajaxOptions, thrownError) {

				},
				success: function(data) {

					loading_ajax = false;

					if( data != "0" ) {

						this_element.mouseout();

						if( data_target !== null ) {

							data_target = $(data_target);

							if( data_action !== null ) {

								switch(data_action) {

								case('crear'): 

									data_target.append(data);
								if( type == 'form' ) {
									form_parent[0].reset();
								}
								break;


								case('editar'): 
									data_target.replaceWith(data);	
								break;

								case('eliminar'): 
									data_target.remove();
								break;
								}


							}

						} //End if data target exist


					} //End if data != false


					if( close_panel != "false" ) {

						content.animate( { width: '96%' } , 'fast', function(){

							panel.remove();

						});

					}

					//Custom callback
					if( callback !== undefined ) {

						callback();
					}



					//Funciones para reinicializar plugins
					crear_slider_encuestas('.slider-resp');


					//Redirect if
					if(redirect_view !== undefined) {

						if(data == 0) {

							window.location = redirect_view;
						}

					}


				}, error: function(x, status, error) {

					//Custom callback
					if( callback !== null) {

						callback();
					}


					if (x.status == 403) {
						alert("Sorry, your session has expired. Please login again to continue");
					}
					else {
						alert("An error occurred: " + status + "nError: " + error);
					}

					loading_ajax = false;
				}


			}); //End ajax request

		}

	}





	/* *****			  				*****************************************************				*/
	/* #####	REPORTES				#####################################################				*/
	/* *****				 			*****************************************************				*/


	var contador_graficas = 0;

	function crearGrafica(data) {

		var datos			= JSON.parse(data);
		var grafica_data	= new Array();
		var ticks_data		= new Array();

		contador_graficas++;

		for (var i =0; i < datos.length; i++ ) {

			grafica_data.push({
				data: [[datos[i].value+1,i+1]],
				label: datos[i].name,
				color: "red"
			});

			// grafica_data.push([i+1, datos[i].value+1 ]);

			ticks_data.push( [ i+1, datos[i].name ] );
			// alert( JSON.stringify(grafica_data));
		}


		// if ( $("#mws-line-chart").length ) {

		$('.content .mws-panel').append("<div id='mws-line-chart_"+contador_graficas+"></div>");
		var grafica_nueva = $('#mws-line-chart_'+contador_graficas);
		$.plot( grafica_nueva, grafica_data,
				{ tooltip: true, 
			series: {
				bars: {
					show: true,
					lineWidth: 1,
					fill: true,
					barWidth: .5,
					align: "center",
					horizontal: true
				}
			},
			grid: {
				borderWidth: 0, 
				hoverable: true,
				clickable: true
			},
			legend: {
				show: true
			},
			yaxis: {
				ticks: ticks_data
			},
			xaxis:{
				tickDecimals: 0
			}
				});


		// }
	}// Crear grafica




	/* *****	ROLES	  				*****************************************************				*/
	/* #####	PERMISOS DE MODULOS		#####################################################				*/
	/* *****	Y PRODUCTOS	 			*****************************************************				*/



	body.on('change', '.producto_check input[type=checkbox]', function() {

		var this_element	= $(this);
		var check_hijos		= this_element.parent().parent().find('.permision_check input[type=checkbox]');

		check_hijos.each(function() {

			var this_check = $(this);

			if ( this_element.attr('checked') ) {

				this_check.attr('checked', true);

			} else {

				this_check.attr('checked', false);

			}

		});

	});




	/* Checkboxes */
	/* Meter esta funcionalidad y la de los checkboxes de permisos en una sola donde se agregue un atributo al
	checkbox padre de "Chekbox-child" o algo parecido con la clase de los checkboxes hijos que seran checkeados o
	des checkeados segun la acción del padre */

	var checker = $('input[id=select_all]'),
	checkboxes = $('input[class^=check-select_]');

	checker.on('change', function(){
		if($(this).is(':checked')){
			checkAll(true);
		}else{
			checkAll(false);
		}
	});

	checkboxes.on('change', function(){
		var checkedBoxes = 0;
		checkboxes.each(function(){
			if($(this).is(":checked")){
				checkedBoxes++;
			}
		});
		if(checkedBoxes < checkboxes.length){
			checker.prop("checked", false);
		}else if(checkedBoxes == checkboxes.length){
			checker.prop("checked", true);
		}
	});

	function checkAll(isOn){

		checkboxes.each(function(index){
			var $this = $(this);
			if(isOn){
				if(!$this.is(":checked")){
					$this.prop("checked", true);
				}
			}else{
				if($this.is(":checked")){
					$this.prop("checked", false);
				}
			}
		});
	}

	/* Actions for selected items */

	body.on('click', '.table-option', function(){

		var $this = $(this),
		anchor = $this.find('a'),
		option = anchor.data('option'),
		checkboxes = $('input[id^=check-select_]'),
		controlador = $('.content').attr('id');

		checkboxes.each(function(){
			var $this = $(this);

			if($this.is(':checked')){
				var id = $this.val(),
				action = controlador + '/' + option + '/' + id;

				$.post(action, function(){

				});

			}	
		});

		window.location.reload();

	});




	/* *****							*****************************************************				*/
	/* #####	TABLAS DE LISTADO		#####################################################				*/
	/* *****				 			*****************************************************				*/


	if( $('.mws-table').length ){

		$('.mws-table').dataTable({
			sPaginationType: "full_numbers"
		});

	}

	/* Altura de calendario */

	$(window).resize( function(event) {

		/*Altura de calendar */
		var mws_calendar = $('#mws-calendar');

		if (mws_calendar.length) {

			mws_calendar.fullCalendar('option', 'contentHeight', $('body > .content').height()-100);

		}

	});


	/* Table header */

	var dataTables_filter = $('.dataTables_filter'),
	controlador = content.attr('data-controlador'),
	add_action = content.attr('data-add');

	$('<a>', {
		class: 'redbtn panel-trigger',
		'data-view': add_action,
		text: 'Crear'
	})
	.prepend($('<span>', { class: 'add-icon' }))
	.appendTo(dataTables_filter);



	/* File browser */
	if ($('#elfinder').length){

		$("#elfinder").elfinder({
			url : 'archivos/load_elfinder', 
			lang : 'es',
			docked : true,
			height: 300
		});

	}


	$('.chosen').chosen();


	/* *****	ENCUESTAS	  				*****************************************************			*/
	/* #####	SLIDER, WIDGETS Y 			#####################################################			*/
	/* *****	ACTUALIZACIÓN POR AJAX 		*****************************************************			*/


	var slider_resp	= $('.slider-resp'),
	faces			= $('.faces li'),
	preg_abierta	= $('.preg-abierta textarea'),
	resp_select		= $('.resp select');


	if(slider_resp.length ) {

		crear_slider_encuestas();

	}

	function crear_slider_encuestas(selector) {

		var slider_resp	= $('.slider-resp');

		slider_resp.each(function() {


			var this_element = $(this);
			var slider_lenght = this_element.attr('data-lenght');	
			var inicial_value = this_element.attr('inicial-value');	

			if( inicial_value === undefined || inicial_value == ""){

				inicial_value = 1;
			}	else{
				inicial_value = parseInt(inicial_value);
			}

			if( !this_element.hasClass('ui-slider') ) {

				this_element.slider({
					range: "min",
					min: 1,
					max: slider_lenght,
					value: inicial_value,
					slide: function(event, ui) { 

						if(loading_ajax) {
							this_element.slider('disable');
						}

						$(this).find('.indicator').text(ui.value);

					},create: function( event, ui ) {

						$(this).find('.ui-slider-handle').append('<span class="indicator"></span>');

					}, start: function( event, ui) {

						$(this).find('.indicator').fadeIn('fast');

					},stop: function( event, ui) {

						$(this).find('.indicator').fadeOut('fast');

					},change: function(event, ui) {

						var custom_data = {
								data_view	: this_element.attr('data-view'),
								data_post	: "respuesta="+ui.value,
								close_panel	: "false"
						};


						loading_ajax = true;
						this_element.slider( "disable" );

						ajax_action(this_element, 'manual', custom_data, function() {

							this_element.slider( "enable" );
						});
					}


				});

			}

		});
	}


	body.on('click', '.faces li' ,function(e){

		var this_element = $(this);
		var ul_parent = this_element.parent();

		if(!this_element.hasClass('face_selected') && !ul_parent.hasClass('face_disabled')) {

			var anterior_selected = ul_parent.find('.face_selected');

			anterior_selected.removeClass('face_selected');
			this_element.addClass('face_selected');

			var custom_data = {
					data_view	: ul_parent.attr('data-view'),
					data_post	: "respuesta="+this_element.attr('data-value'),
					close_panel	: "false"
			};

			ul_parent.addClass('faces_disabled');
			loading_ajax = true;

			ajax_action(this_element, 'manual', custom_data, function() {

				ul_parent.removeClass('faces_disabled');
			});
		}

	});



	body.on('keyup blur', '.preg-abierta textarea', function(){

		var this_element = $(this);

		var custom_data = {
				data_view	: this_element.attr('data-view'),
				data_post	: "respuesta="+this_element.val(),
				close_panel	: "false"
		};

		// alert(JSON.stringify(custom_data));
		if(event.type == 'keyup') {

			if(!loading_ajax) {

				loading_ajax = true;

				ajax_action(this_element, 'manual', custom_data, function(){});
			} 

		} else{

			loading_ajax = true;

			ajax_action(this_element, 'manual', custom_data, function(){});
		}


	});


	body.on('change', '.resp select', function(){

		var this_element = $(this);

		var custom_data = {
				data_view	: this_element.attr('data-view'),
				data_post	: "respuesta="+this_element.val(),
				close_panel	: "false"
		};

		loading_ajax = true;

		ajax_action(this_element, 'manual', custom_data);

	});




	var inputs_respuestas_array;

	body.on('change', 'select[name=idtipo_reactivo]', function(e){


		var respuestas_reactivo_caritas		= $('#respuestas_reactivo_caritas');
		var respuestas_reactivo_opciones	= $('#respuestas_reactivo_opciones');
		var respuestas_reactivo_puntuacion	= $('#respuestas_reactivo_puntuacion');
		var respuestas_reactivo_button		= $('#respuesta_reactivo_button');

		switch($(this).val()) {

		case "1" :

			//Puntuacion

			//Activar el utilizado
			respuestas_reactivo_puntuacion.find('input').removeAttr('disabled');
			respuestas_reactivo_puntuacion.css("display","block");

			//Desactivar los no utilizados
			respuestas_reactivo_opciones.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_opciones.css("display", "none");
			respuestas_reactivo_button.css("display", "none");

			respuestas_reactivo_caritas.find('input').attr('disabled');
			respuestas_reactivo_caritas.css("display","none");

			break;

		case "2" :

			//Opciones
			//Activar el utilizado
			respuestas_reactivo_opciones.find('input').removeAttr('disabled');
			respuestas_reactivo_opciones.css("display","block");
			respuestas_reactivo_button.css("display","block");

			//Desactivar los no utilizados
			respuestas_reactivo_puntuacion.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_puntuacion.css("display","none");

			respuestas_reactivo_caritas.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_caritas.css("display","none");


			break;

		case "3" :

			//Caritas

			//Activar el utilizado
			respuestas_reactivo_caritas.find('input').removeAttr('disabled');
			respuestas_reactivo_caritas.css("display","block");

			//Desactivar los no utilizados
			respuestas_reactivo_opciones.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_opciones.css("display","none");
			respuestas_reactivo_button.css("display","none");


			respuestas_reactivo_puntuacion.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_puntuacion.css("display","none");

			break;

		case "4" :

			//Respuesta abierta

			//Desactivar los no utilizados
			respuestas_reactivo_opciones.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_opciones.css("display","none");
			respuestas_reactivo_button.css("display","none");

			respuestas_reactivo_caritas.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_caritas.css("display","none");

			respuestas_reactivo_puntuacion.find('input').attr('disabled', 'disabled');
			respuestas_reactivo_puntuacion.css("display","none");

			break;

		}

	});

	body.on('click', '.eliminar_reactivo_respuesta', function() {

		var this_element = $(this);
		this_element.mouseout().prev().remove();

	});


	/* *****	SETUP ENCUESTAS,  		*****************************************************				*/
	/* #####	REORDENAR ELEMENTOS		#####################################################				*/
	/* *****	Y GUARDAR VÍA AJAX 		*****************************************************				*/

	$( "#grupos" ).each(function() {

		var this_element = $(this);
		this_element.sortable({
			connectWith: "#grupos",
			handle: ".grupo_toogle",
			placeholder: 'portlet-placeholder',
			cursor: 'move',
			distance: 10,
			revert: 250,
			opacity: .7,
			scrollSpeed: 1,
			scrollSensitivity: 5,
			axis: "y",
			update: function(event, ui) {

				var data_view = this_element.attr('data-view');

				if(data_view !== null) {

					var nuevo_orden = this_element.sortable("toArray");
					var data_send = { orden_grupos: nuevo_orden };

					$.ajax({

						type: "POST",
						url: data_view,
						data: data_send,
						success: function(data) {

						}, error: function(x, status, error) {

							if (x.status == 403) {
								alert("Sorry, your session has expired. Please login again to continue");
							}
							else {
								alert("An error occurred: " + status + "nError: " + error);
							}
						}


					}); //End ajax request

				}


			},
			start: function(e, ui){
				ui.placeholder.height(ui.item.height());
			}

		});

	}); // Grupos reordenables


	$( ".reactivos" ).each(function(){

		var this_element = $(this);
		this_element.sortable({
			connectWith: ".reactivos",
			handle: ".reactivo_toggle",
			placeholder: 'reactivo-portlet-placeholder', 
			cursor: 'move',
			distance: 10,
			revert: 250,
			opacity: .7,
			axis: "y",
			update: function(event, ui) {

				var data_view = this_element.attr('data-view');

				if(data_view !== null) {

					var nuevo_orden;
					var grupo_actualizado;
					var data_send;

					if(ui.sender === null) {

						//Es el evento del grupo que se abandonó
						nuevo_orden = this_element.sortable("toArray");
						grupo_actualizado = this.id;

						data_send = { grupo: grupo_actualizado, orden_reactivos: nuevo_orden };

					} else {

						//Es el evento del grupo que recibe
						nuevo_orden = this_element.sortable("toArray");
						grupo_actualizado = this.id;

						data_send = { grupo: grupo_actualizado, orden_reactivos: nuevo_orden };

					}


					$.ajax({

						type: "POST",
						url: data_view,
						data: data_send,
						success: function(data) {

						}, error: function(x, status, error) {

							if (x.status == 403) {
								alert("Sorry, your session has expired. Please login again to continue");
							}
							else {
								alert("An error occurred: " + status + "nError: " + error);
							}
						}


					}); //End ajax request

				}


			},
			start: function(e, ui){
				ui.placeholder.height(ui.item.height());
			}

		});

	}); // Reactivos reordenables

	body.on('click', '.grupo_toogle', function(event) {

		var this_element = $(this);
		var container_parent = this_element.parents('.grupo');
		var reactivos_container = container_parent.find('.reactivos');

		var hijos_reactivos = reactivos_container.find('li');

		if( hijos_reactivos.length ) {

			if( container_parent.hasClass('grupo_closed') ) {

				reactivos_container.stop().slideDown('fast', function() {
					container_parent.removeClass('grupo_closed');
				});

			} else {

				reactivos_container.stop().slideUp('fast', function() {
					container_parent.addClass('grupo_closed');
				});

			}

		}

	});





});