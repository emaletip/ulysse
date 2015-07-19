function selectshow(obj) {
    var select = obj.value;
    if (select == "select") {
        document.getElementById("contenu-select").style.display = "block";
    } else {
        document.getElementById("contenu-select").style.display = "none";
    }
}

$(document).ready(function() {

	$('.editor').each(function(){	
		CKEDITOR.replace( $(this).attr('name') );
	});
	var options = {
		placeholderCss: {'background-color': '#ff8', 'border': '1px dashed #eee', 'background': '#f8f8f8'},
		hintCss: {'border': '1px dashed #eee', 'background-color': '#fff'},
		isAllowed: function(cEl, hint, target)
		{
			// Be carefull if you test some ul/ol elements here.
			// Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
			// Be careful also if the hint is not visible. It has only display none so it is at the previouse place where it was before(excluding first moves before showing).
			if(hint.parents('li').first().data('module') === 'c' && cEl.data('module') !== 'c')
			{
				hint.css({'background-color': '#fff'});
				return false;
			}
			else
			{
				hint.css({'background-color': '#fff' });
				return true;
			}
			
		},
		opener: {
			 active: true,
			 close: './imgs/Remove2.png',
			 open: './imgs/Add2.png',
			 openerCss: {
				 'display': 'inline-block',
				 'width': '18px',
				 'height': '18px',
				 'float': 'left',
				 'margin-left': '-35px',
				 'margin-right': '5px',
				 'background-position': 'center center',
				 'background-repeat': 'no-repeat'
			 },
			 openerClass: ''
		},
		ignoreClass: 'clickable',
		complete: function(e, el) {
			var position_compteur = 1;
			var data = {};
			var url = e.parents('.myList:first').data('update');
			
			var li = e;
			var parent_id = li.parents('.myList:first');

			if(e.parents('ul').length <= 2) {			
			
			e.parents('ul:first').find('li').each( function() {
				var li = $(this);
				var parent_id = $(this).parents('li.list:first').data('id');
				if(parent_id == undefined) {
					parent_id = 'NULL';
				}
				
				var id = $(this).data('id');
				var position = position_compteur++;
					data[position] = {id:id, parent_id:parent_id,position,position};
				});
				
				$.ajax({
					url : url, 
					type : 'POST', 
					data : {data:data},
					success: function(data) {
						li.find('div:first').append('<i class="fa fa-check pull-right green success-check"></i>')
						setTimeout(function(){
							$('.success-check').fadeOut();
						}, 2000);					
					}
			    });
	
			} else {
				/*msg erreur*/
				$('.principal .alert').fadeIn();
				setTimeout(function(){
					$('.principal .alert').fadeOut();
				}, 5000);					

				parent_id.append(li);
			}
		}
		
	};

	$('#myList1').sortableLists(options);
	$('#myList2').sortableLists(options);
	
	
	var oldContainer;
	$("#myList").sortable({
	  group: 'nested',
	  afterMove: function (placeholder, container) {
	    if(oldContainer != container){
	      if(oldContainer)
	        oldContainer.el.removeClass("active");
	      container.el.addClass("active");
	
	      oldContainer = container;
	    }
	  },
	  onDrop: function ($item, container, _super) {
	  }
	});
	
	$(".switch-container").on("click", ".switch", function  (e) {
	  var method = $(this).hasClass("active") ? "enable" : "disable";
	  $(e.delegateTarget).next().sortable(method);
	});
	
	
	$('.ullist').show();
	
	$('.edit-menu-item').unbind().bind('click',function(){
		var id = $(this).parents('li:first').data('id');
	});
	
	$('.delete-menu-item').unbind().bind('click',function(){
		var id = $(this).parents('li:first').data('id');
		var url = $(this).parents('li:first').data('delete');
		if(confirm('Êtes-vous sûre de vouloir supprimer cet élément ? ')) {
			window.location.href = url;
		}
	});	
});

$(function() {

	$( ".sortable" ).sortable({
		connectWith: ".connectedSortable",
		cancel: ".ui-state-disabled",
		stop:function(event,ui){
			var compteur = 1;
			var url = $('#action').val();
			var item_parent_id = ui.item.parents('ul:first').attr('data-id');

			ui.item.parents('ul:first').find('li').each(function(){
				var item_id = $(this).attr('data-id');
				var order = compteur++;
				var data = {id: item_id, emplacement_id: item_parent_id, is_active:1, position:order};	
				$.ajax({
			       url : url, // La ressource ciblée
			       type : 'POST', // Le type de la requête HTTP.
			       data : data,
			       success: function(data) {
			       }
			    });
			});	
			ui.item.css('width','calc(100% - 10px)');
		},
		start:function(e,ui) {
			ui.item.css('width','300px');
		}
	}).disableSelection();
    
    $('input[name*="nb_column"]').change(function(){
    	var column = $(this).parents('.columns:first');
    	var emplacement_id = $(this).parents('ul:first').attr('data-id');
    	var nb_column = $(this).val();
		var data = {id:emplacement_id, nb_column:nb_column };
		var url = $('#emplacement_action').val();
	    $.ajax({
	       url : url, // La ressource ciblée
	       type : 'POST', // Le type de la requête HTTP.
	       data : data,
	       success: function(data) {
	       		column.prepend('<i class="fa fa-check green" style="display:none;"></i>');	
	       		$('.fa-check').fadeIn(function(){
				    setTimeout(function(){
				        $('.fa-check').fadeOut(function(){
				            $('.fa-check').remove();
				        });
				    },2000);
				});
			    $('.nb-columns').hide();
	       }
	    });
    });
    
    $( ".sortable li" ).disableSelection();
    
/*
    $( "#sortable1, #sortable2, #sortable3, #sortable4" )
    .on('mouseup','li',function() {
	   	$(this).css('width','calc(100% - 10px)');
	})
    .on('mousedown','li',function () {
	   	$(this).css('width','300px');
    })
    ;
    
*/
  });