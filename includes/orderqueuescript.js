  jQuery(document).ready(function(){
  jQuery('#failedorderstable').dataTable({
        "Processing": true,
        "ServerSide": true,
         "ajax": ajax_url,
         'aoColumnDefs': [{
      'bSortable': false,
        'aTargets': [-1] /* 1st one, start by the right */
    }],
         });
  });