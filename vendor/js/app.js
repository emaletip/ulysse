  $(function() {
    $( "#sortable1, #sortable2, #sortable3" ).sortable({
      connectWith: ".connectedSortable",
      cancel: ".ui-state-disabled"
    }).disableSelection();
    
    $( ".sortable li" ).disableSelection();
    
  });