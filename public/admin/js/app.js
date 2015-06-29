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