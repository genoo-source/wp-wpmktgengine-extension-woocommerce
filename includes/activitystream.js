jQuery(document).ready(function(){

   jQuery(document).on("click", ".clickoption", function () {
    var ajaxwoocommerceurl = jQuery(".admininsertvalue").val();
    jQuery.ajax({
    url: ajaxwoocommerceurl,
    type: "POST",
    cache: false,
    data: {
    action: "woocommerce_activity_stream_types",
    },
    success: function () {
    jQuery.ajax({
    url: ajaxwoocommerceurl,
    type: "POST",
    cache: false,
     data: {
         action: "woocommerce_delete_plugin_options",
     },
     success: function (data) {
      location.reload();
     },
     error: function (errorThrown) {
         console.log(errorThrown);
     },
     });
     },
     error: function (errorThrown) {
         console.log(errorThrown);
     },
     });
      });
 
jQuery(".selectall").click(function () {
    jQuery('input:checkbox').not(this).prop('checked', this.checked);
 });

jQuery(document).on("click",".pushalltogenoo",function()
{
        var objectvalue = jQuery(this).closest('.form-table');
        var checkboxes = [];
        var activity_streamtypes = [];
        var streamtype_val = [];
        var parentDiv=jQuery(objectvalue);
        parentDiv.find(".checkbox:checked").each(function(){
        var data_value  = {};
        data_value.label= jQuery(this).attr("id");
        data_value.labelvalue = jQuery(this).attr("name");
        data_value.label_sub_id = jQuery(this).attr("datasubid");
        streamtype_val[[ jQuery(this).attr("id")]] = data_value;
        checkboxes.push(data_value);
  
        }); 

    jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            cache: false,
            data: {
                action: "push_data_into_genoo",
                order_id:checkboxes
            },
    success: function (data) {
        if(data!=null)
        {
              jQuery.ajax({
            url: ajaxurl,
                    type: "POST",
                    cache: false,
                    data: {
                        action: "order_status_update",
                        status:'1',
                        order_id:checkboxes
                    },
            success: function () {
              location.reload(); 
            },

    error: function (errorThrown) {
                console.log(errorThrown);
            },
            });
        }
        else
        {
             location.reload(); 
        }
    
        },
        error: function (errorThrown) {
                console.log(errorThrown);
        },
    });
        

});

 
jQuery(document).on("click", ".adminpushalltogenoo", function () {
    var objectvalue = jQuery(this).closest('.adminoptionpush');
    var parentDiv=jQuery(objectvalue);
  let searchParams = new URLSearchParams(window.location.search)
  searchParams.has('post') // true
  let param = searchParams.get('post')
  jQuery('.adminpushalltogenoo').css('display','none');
  var no_smart_rule_value = parentDiv.find('.no_smart_rule_ind').is(":checked");
    if(no_smart_rule_value==true)
    {
        var no_smart_rule_value_id = 'Y';
    }
    else
    {
    var no_smart_rule_value_id = 'N';
   }
     jQuery('.no_smart_rule_ind').css('display','none');
     jQuery('.no_smart_rule_label').css('display','none');
   jQuery(".loading").show();
   jQuery.ajax({
   url: ajaxurl,
   type: "POST",
   cache: false,
   data: {
   action: "mv_save_wc_order_other_fields",
   'post_id': param,
   'no_smart_rule_value_id':no_smart_rule_value_id
   },
   success: function () {
   jQuery('.adminpushalltogenoo').css('display','none');
   jQuery(".loading").hide();

  location.reload();
    },
    error: function (errorThrown) {
        console.log(errorThrown);
    },
    });
 });


});