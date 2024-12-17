<?php
//cron for remove leadtype after subscripton expired.
function my_cron_schedules($schedules)
{
$corn_settings = get_option('WPME_ECOMMERCE');  

$corn_settings_setup = $corn_settings['cronsetup'];

    if(!isset($schedules["pertime"])){
      
   $schedules["pertime"] = [
        "interval" => $corn_settings_setup * 60,
        "display" => __("Once every 1 minutes"),
      ];
  }
      
     
      return $schedules;
     
}

add_filter("cron_schedules", "my_cron_schedules");

if (!wp_next_scheduled("send_queue_record")) {
    
  wp_schedule_event(time(), "pertime", "send_queue_record");
}
add_action("send_queue_record", "send_queue_record_details");

function send_queue_record_details()
{
   global $wpdb, $WPME_API;

  $genoomem_genooqueue = $wpdb->prefix . "genooqueue"; 
  
  
 $get_all_queue_records = $wpdb->get_results("select * from $genoomem_genooqueue where status=0");
  
  foreach($get_all_queue_records as $get_all_queue_record)
  {
      
    $order_id = $get_all_queue_record->order_id;
    
    $getpayload = $get_all_queue_record->payload;
    
    

    $order = new \WC_Order($order_id);
    
       try {
            // Make a POST request, to Genoo / WPME api, for that rest endpoint
           
       
                  $result = $WPME_API->callCustom('/wpmeorders', 'POST',json_decode($getpayload));

           
               $parent_id = $order->get_parent_id();
        
                  if($parent_id!=0)
                  {
                        $order_id = $parent_id;
                        $subscription_id = $order_id;
        
                  }
                  else
                  {
              $order_id = $order_id;
             $subscription_id = $order_id;
        
        
                  }
              if($result->order_id=='') :
                   
                    $value = explode(':', $result);
                   
                     $str = str_replace('}', "", $value[3]);
                     
                     $str_value = str_replace('"', "", $str);
                     
            update_post_meta($order_id, 'wpme_order_id', $str_value);
            update_post_meta($subscription_id, 'wpme_order_id', $str_value);

                    $wpme_order_id_value = $str_value;
                   else:
                       
                    $wpme_order_id_value = $result->order_id;
       
             update_post_meta($order_id, 'wpme_order_id', $result->order_id);
            update_post_meta($subscription_id, 'wpme_order_id', $result->order_id);

                    endif;
                    

        //  }

          if (!in_array($get_all_queue_record->order_activitystreamtypes, $failed_order_values)) {
          //  $result = $WPME_API->updateCart($wpme_order_id_value, $orderpayload);

            if (!in_array($get_all_queue_record->order_activitystreamtypes, $order_update_options))
              update_post_meta($order_id, 'wpme_order_id', $result->order_id);
          }
       
        
        if ($get_all_queue_record->order_activitystreamtypes == 'cancelled order') {
          $cancel_order_id = get_post_meta($order_id, 'wpme_order_id', true);

          $result = $WPME_API->updateCart($cancel_order_id, $orderpayload);
            }
     
                  $genoo_ids = get_post_meta(
                        $order_id,
                        "wpme_order_id",
                        true
                    );
                    
                 $genoo_lead_id = get_wpme_order_lead_id($genoo_ids);
                 

                  if($wpme_order_id_value!=''){
                      
                    
                    $wpdb->update(
                    $genoomem_genooqueue,
                    [
                        "status" => 1,
                    ],
                    [
                        "order_id" => $order_id,
                      "order_activitystreamtypes" =>  $get_all_queue_record->order_activitystreamtypes
                    ]
        );
                 }
             
       }catch (Exception $e) {
            if ($WPME_API->http->getResponseCode() == 404):
             // Looks like orders not found
            endif;
        }

}
}



?>