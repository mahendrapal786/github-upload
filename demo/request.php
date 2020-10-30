<?php
    $data = $_POST;
    $post_data['api_token'] = 'F2cjhOHStsbqK0rSxRCMDCXlkuRrXALQK2MnbAsqA15KdvLDC47gOUOhRGxVuX7K';
   /* $post_data['source'] = $data['source'];
    $post_data['page'] = $data['page'];
    $post_data['form'] = $data['form'];*/
    $post_data['first_name'] = $data['fullname'];
    $post_data['email'] = $data['email'];
    $post_data['mobile_no'] = $data['phone'];
    $post_data['method_of_contact'] = 'method of contact';
    $post_data['send_email'] = '1';
    
    $args = array('timeout' => 45, 'headers' => array('Content-Type' => 'application/json'), 'body' => json_encode($post_data));


    echo '1';


    /*$response_data = wp_remote_post(APIURL_CRM . '/api/create-lead-wordpress', $args);
    print_r($response_data); */
    die;
    //send_lead_email($data);
    die;
?>