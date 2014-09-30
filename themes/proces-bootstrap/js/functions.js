$(function(){

	var body	= $('body'),
	content		= $('.content'),
	menu		= $('.menu-bar'),
	ajaxLoader = $('.ajax-loader');

    /* *****					  		*****************************************************				*/
    /* #####	MENU INTERACTIONS 	 	#####################################################				*/
    /* *****	 						*****************************************************				*/

	var menuFixed			= false;
	var menu_original_height	= menu.height();
	var panel;

	$(window).scroll(function(event) 
	{
		var scroll_window = $(window).scrollTop();
		
		if( scroll_window > 60 ) 
		{
			if( !menuFixed ) 
			{
				content.css( 'marginTop', 65);
				menu.addClass('navbar-fixed-top');

				menuFixed = true;

				updatePanelPosition();
				updatePanelHeight();
			}

		} else {
			if( menuFixed ) 
			{
				menu.removeClass('navbar-fixed-top');
				content.css( 'marginTop', '');

				menuFixed = false;

				updatePanelPosition();
				updatePanelHeight();
			}	
		}
	});


    /* *****					  		*****************************************************				*/
    /* #####	DROPDOWN LIST 	 		#####################################################				*/
    /* *****	 						*****************************************************				*/

	body.on('click', '.button_switch', function(e)
	{
		e.stopPropagation();
		e.preventDefault();

		var this_element	= $(this);
		var drop			= this_element.parent().find('.drop-list');

		if(this_element.hasClass('active'))
		{
			this_element.removeClass('active');
		} else{
			var anotherActive     = $('.button_switch.active');
			var dropAnotherActive = anotherActive.parent().find('.drop-list');

			if(anotherActive.length)
			{
				anotherActive.removeClass('active');
				dropAnotherActive.fadeToggle('fast');
			}

			this_element.addClass('active');
		}

		drop.fadeToggle('fast');
	});

	//Cerrar el cuadro de búsqueda cuando se haga click fuera

	body.click(function() 
	{
		var button_switch	= $(".button_switch.active"),
		drop				= button_switch.parent().find('.drop-list');

		button_switch.removeClass("toggled");
		drop.fadeToggle('fast');
		button_switch.removeClass('active');
	});

    /* *****					  		*****************************************************				*/
    /* #####	PANEL INTERACTIONS 	 	#####################################################				*/
    /* *****	 						*****************************************************				*/

	$(window).bind('resize', function(event) 
	{
		updatePanelHeight();
	});


	function updatePanelPosition(callback)
	{
		var panels = $('.proces-panel');

		if(panels.length) 
		{
			panels.each(function()
			{	
				var this_element = $(this);
				if($('.navbar-fixed-top').length)
				{
					this_element.css('position','fixed')
					.stop(false, true).animate({ top: '67px', height: '86%' },0);

				} else {
					this_element.stop(false, true).animate({top: '125px'}, 0, function(){
						this_element.css('position','');

						if(callback !== undefined)
						{
							callback();
						}
					});		
				}
			});
		}	

	}

	function updatePanelHeight(callback)
	{
		var panels = $('.proces-panel');

		if( panels.length)
		{
			panels.each(function()
			{
				var this_element = $(this);
				var topPosition = this_element.css('top');
				topPosition = topPosition.replace('px','');
				topPosition = topPosition.replace('-','');

				this_element.stop(false, true).animate({
					height: (($(window).height()-topPosition)-5)+'px'},
					400,
					function() { 

						if(callback !== undefined)
						{
							callback();
						}
			   	});
			});
		}
	}

    /* *****	PANEL DINAMICO,	  		*****************************************************				*/
    /* #####	CARGA DE VISTAS EN 		#####################################################				*/
    /* *****	PANEL VÍA AJAX	 		*****************************************************				*/

    var last_view;

	body.on('click', '.panel-trigger', function(e){

		e.preventDefault();

		openPanel($(this));

	});

	var panelAnimation = false;

	function openPanel(this_element, custom_view)
	{
		if(custom_view === undefined){
			var data_view = this_element.attr('data-view');

			if(data_view === undefined)
			{
				data_view = this_element.attr('href');
			}

		} else{
			var data_view	= custom_view;
		}
		
		var panel			= $('.active_panel');
		var sub_panel		= this_element.attr('data-subpanel');

		if (data_view !== undefined && !panelAnimation) {
				
				body.css('overflow-x','hidden');

				panelAnimation = true;
				var animate = 300;

				//Hidde all tooltips
				this_element.mouseout();
				//Hidde all choosens
				if($('.select2-offscreen').length)
				{
					$('.select2-offscreen').select2('close');
				}

				if($('.proces-panel').length)
				{
					if( sub_panel == 'true' && sub_panel !== undefined )
					{
						//If there are more than two panels, remove active
						if( $('.proces-panel').length >= 2 )
						{
							panel.remove();
							animate = 0;
						} else {
							panel.removeClass('active_panel');
						}
					} else {
						//Remove all if not subpanel
						$('.proces-panel').remove();
						animate = 0;
					}
				}

				// Set de last view after removing panels logic
				last_view = data_view;

				content.after($('<div>').addClass('proces-panel').addClass('active_panel'));

				updatePanelPosition(function(){ });				

				updatePanelHeight();

				$('.active_panel').css('right', '-35%')
								  .css('opacity', 0)
								  .animate({right: '2%', opacity: 1}, animate, function()
								  {
										panelAnimation = false;
										body.css('overflow-x','auto');
								   });

				$('.active_panel')
				.prepend('<div original-title="Cerrar" class="mws-tooltip-s close_panel fa fa-times-circle"></div>');
				
				$.ajax({
					url: data_view,
					type: 'POST',
					data: { ajaxRequest: true },
					dataType: 'html',
					success: function(data) 
					{
						$('.active_panel').append(data);

						createAjaxChoosen();
					},
					error: function(data) 
					{
						$('.active_panel').append(data);
						
					},
					complete: function() {
						
					}
				});
		}

	}

	body.on('click', '.close_panel, .proces-panel .cancel-button', function(event) 
	{
		event.preventDefault();

		closePanel( $(this) );
	});

	body.on('click', '.content .cancel-button', function(event) 
	{
		event.preventDefault();

		window.history.back();
	});

	$(document).keyup(function(e) 
	{
	  if (e.keyCode == 27) // Escape
	  { 
	  	closePanel();
	  }   
	});


     //Close panel
    function closePanel(this_element)
    {
		var current_panel;

		if( this_element === undefined )
		{
			current_panel = $('.active_panel');
		} else{
			current_panel = this_element.parents('.active_panel');
		}

		if(current_panel.length)
		{		
			if(!panelAnimation)
			{
				panelAnimation = true;

				if($('.tipsy'))
				{
					$('.tipsy').remove();
				}

				body.css('overflow-x', 'hidden');

				current_panel.animate({right: '-30%'}, {
				    duration: 300,
				    complete: function()
				    {
				    	body.css('overflow-x', 'auto');

						panelAnimation = false;

						$(this).remove();

						//Si no queda ningun panel abierto
						if( $('.proces-panel').length == 1 )
						{
							$('.proces-panel').addClass('active_panel');
						}

						if($('.tipsy').length)
						{
							$('.tipsy').remove();
						}
				    }
			    });
			}
		}
	}


	/* *****	TOOLTIPS EN DIFERENTES  	*****************************************************				*/
	/* #####	DIRECCIONES VISTAS			#####################################################				*/
	/* *****	SELCTOR DE CLASES 			*****************************************************				*/


	var someTooltip = $('[class*="mws-tooltip"]');

	if(someTooltip.length)
	{
		var gravity = ['n', 'ne', 'e', 'se', 's', 'sw', 'w', 'nw'];

		for(var i in gravity) 
		{
			$(".mws-tooltip-"+gravity[i]).tipsy({
				gravity: gravity[i], 
				live: true, 
				delayIn: 250, 
				offset: 7,
				fade: true,
				opacity: .8
			});
		}

		body.on('click', '.tipsy', function(event)
		{
			$(this).remove();
		});
	}

    /* *****							*****************************************************				*/
    /* #####	CHOOSEN 				#####################################################				*/
    /* *****				 			*****************************************************				*/

	function format(item, container) 
	{
	    if(item.id == 'create')
	    {
		    return '<a href="#" class="choosen_create panel-trigger" data-subpanel="true">'+item.text+'</a>';
		} else {
			return '<p class="choosen_item">'+item.text+'</p>';
		}
	}

	var selectsCount = 0;

	function createAjaxChoosen()
	{

		// Normal select choosen
		var selectChoosen = $('select');

		selectChoosen.each(function()
		{
			var this_element    = $(this);
			var data_new        = this_element.attr('data-new');
			var placeholder 	= this_element.attr('placeholder');

			var thisChoosenConfig = {
				allowClear         : true,
				formatResult       : format,
				formatSelection    : format,
				formatInputTooShort: 'Ingrese palabras clave...',
				formatLoadMore     : 'Cargando resultados...',
			};

			if(data_new)
			{
				var customData     = {};
				var optionsElement = this_element.find('option');

				optionsElement.each(function(index, el)
				{
					data[index] = {id: el.value, text: el.text};
				});

				thisChoosenConfig.data = customData;
			}

			if(placeholder !== undefined && thisChoosenConfig.allowClear)
			{
				this_element.prepend('<option></option>');

				if(!this_element.find('option[selected]').length)
				{
					this_element.prop("selectedIndex", 0);
				}	
			}

			this_element.select2(thisChoosenConfig);
		});
	}

	createAjaxChoosen();


	body.on('submit', '.ajax-submit', function(event)
	{ 
		event.preventDefault();
		var thisForm = $(this);
		var panel    = thisForm.parents('.proces-panel');
		var dataForm = 'ajaxRequest=true&'+thisForm.serialize();

		$.ajax({
			url    : thisForm.attr('action'),
			data   : dataForm,
			type   : 'POST',
			success: function(data)
			{
				panel.find('.panel-content, .panel-options').remove();
				panel.append(data);

				var gridView = $('.grid-view');

				if(gridView.length)
				{
					gridView.yiiGridView('update');
				}
			}
		});
	});

	body.on('click', '.ajax-delete, .confirm-action', function(event)
	{ 
		event.preventDefault();

		if(confirm("Esta acción no se puede deshacer ¿Está seguro de continuar?"))
		{
			var this_element = $(this);

			if(this_element.hasClass('ajax-delete'))
			{
				var thisLink    = $(this);
				var thisLinkUrl = thisLink.attr('href');

				$.ajax({
					url    : thisLinkUrl,
					data   : {},
					type   : 'POST',
					success: function(data)
					{
						closePanel();

						var gridView = $('.grid-view');

						if(gridView.length)
						{
							gridView.yiiGridView('update');
						}
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(xhr.responseText);
					}
				});
			} else {
				window.location.href = this_element.attr('href');
			}
		}
	});

});
