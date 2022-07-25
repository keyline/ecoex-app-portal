<?php
function pr($data = array(), $mode = TRUE)
{
    echo "<pre>";
    print_r($data);
    if ($mode) {
        die;
    }
}

if ( ! function_exists('test_method'))
{
    function registration_mail($params){
       $params['config']=email_settings();
       sendmail($params);
       return 1;
    } 
    function forgotpassword_mail($params){
       $params['config']=email_settings();
       sendmail($params);
       return 1; 
    } 
   function email_settings(){
        $config['protocol']    = 'smtp';
       // $config['smtp_host']    = 'mail.met-technologies.com';
       // $config['smtp_port']    = '25';        
        //$config['smtp_user']    = 'developer.net@met-technologies.com';
       // $config['smtp_pass']    = 'Dot123@#$%';
        $config['smtp_host']    = 'ssl://mail.met-technologies.com';
        $config['smtp_port']    = '465';
        $config['smtp_user']    = 'developer.net@met-technologies.com';
        $config['smtp_pass']    = 'Dot123@#$%';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not     
        return $config; 
    } 

    function sendmail($data,$attach=''){
      $obj =get_object();
      $obj->load->library('email');
      //print_r($data);die;
      $config['protocol']      = 'smtp';
      /*$config['smtp_host']     = 'ssl://mail.fitser.com';
      $config['smtp_port']     = '465';  
      $config['smtp_user']    = 'test12@fitser.com';
      $config['smtp_pass']    = 'Test123@';*/
      $config['smtp_host']     = 'ssl://mail.met-technologies.com';
      $config['smtp_port']     = '465';  
      $config['smtp_user']    = 'developer.net@met-technologies.com';
      $config['smtp_pass']    = 'Dot123@#$%';
      $config['charset']     = 'utf-8';
      $config['newline']     = "\r\n";
      $config['mailtype']  = 'html';
      $config['validation']  = TRUE;   

      $obj->email->initialize($config);

      
      if($attach!=''){
        $obj->email->attach($attach);
      }

      $obj->email->set_crlf( "\r\n" );

      $obj->email->from($data['from_email'], $data['from_name']);
      $obj->email->to($data['to']); 

      $obj->email->subject($data['subject']);
      $obj->email->message($data['message']);  

      $obj->email->send();
      //echo $obj->email->print_debugger(); die; 
      return true;    
    }
    
  
  
    /*  function sendmail($data,$attach=''){
      $obj =get_object();
      $obj->load->library('email');
      //print_r($data);die;
      $config['protocol']      = 'smtp';
      $config['smtp_host']     = 'ssl://mail.fitser.com';
      $config['smtp_port']     = '465';  
      $config['smtp_user']    = 'test12@fitser.com';
      $config['smtp_pass']    = 'Test123@';
      $config['charset']     = 'utf-8';
      $config['newline']     = "\r\n";
      $config['mailtype']  = 'html';
      $config['validation']  = TRUE;   

      $obj->email->initialize($config);

      
      if($attach!=''){
        $obj->email->attach($attach);
      }

      $obj->email->set_crlf( "\r\n" );

      $obj->email->from($data['from_email'], $data['from_name']);
      $obj->email->to($data['to']); 

      $obj->email->subject($data['subject']);
      $obj->email->message($data['message']);  

      $obj->email->send();
      //echo $obj->email->print_debugger(); die; 
      return true;    
    }*/
    function get_user_role_type(){
      $user_role=get_object()->session->userdata('user_role');
      return $user_role;
    } 
    function get_object(){
      $obj =& get_instance();
      return $obj;
    }
     function getStatusCahnge($id,$tbl,$tbl_column_name,$chng_status_colm,$status,$reason = null) {    
        //echo $id."<br>".$tbl."<br>".$tbl_column_name."<br>".$chng_status_colm."<br>".$status;exit;
        $CI = get_instance();
        $condition                      = array();
        $udata                          = array();
        $resonse                        = '';
        $condition[$tbl_column_name]    = $id;
        $udata[$chng_status_colm]       = $status;
        if($reason != null){
          $udata['cancellation_reason'] = $reason;
        }
        $resonse                        = $CI->mcommon->update($tbl,$condition,$udata); 
        //echo $CI->db->last_query(); die;  
        return $resonse;
  }
    function time_difference($to_time)
    {
        $to_time = strtotime($to_time);
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $time_diff = round(abs($to_time - $from_time) / 60,0);

        if($time_diff>1440) {
            if($time_diff>525600){
                $totalYears = ($time_diff/1440)/365;
                //echo $totalDays;die;
                $day_diff = round($totalYears,0)." years";
            } else {
                $day_diff = round(($time_diff/1440),0)." days";
            }            
        } else {
            if($time_diff>60){
                $hours = round(($time_diff/60),0);
                $mins = round(($time_diff%60),0);
                $day_diff = $hours." hours ".$mins." mins";
            } else {
                $day_diff = $time_diff. " mins";
            }            
        }
        return $day_diff;
    }
    /////////////////////////////////////new fn for time ago/////////////////////////////////////
    function time_ago($timestamp){       
      $time_ago        = strtotime($timestamp);
      $current_time    = time();
      $time_difference = $current_time - $time_ago;
      $seconds         = $time_difference;
      
      $minutes = round($seconds / 60); // value 60 is seconds  
      $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
      $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
      $weeks   = round($seconds / 604800); // 7*24*60*60;  
      $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
      $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                    
      if ($seconds <= 60){

        return "Just Now";

      } else if ($minutes <= 60){

        if ($minutes == 1){

          return "1 minute ago";

        } else {

          return "$minutes minutes ago";

        }

      } else if ($hours <= 24){

        if ($hours == 1){

          return "an hour ago";

        } else {

          return "$hours hrs ago";

        }

      } else if ($days <= 7){

        if ($days == 1){

          return "yesterday";

        } else {

          return "$days days ago";

        }

      } else if ($weeks <= 4.3){

        if ($weeks == 1){

          return "a week ago";

        } else {

          return "$weeks weeks ago";

        }

      } else if ($months <= 12){

        if ($months == 1){

          return "a month ago";

        } else {

          return "$months months ago";

        }

      } else {
        
        if ($years == 1){

          return "one year ago";

        } else {

          return "$years years ago";

        }
      }
    }

    function encoded($param){
      return urlencode(base64_encode($param));
    }
    function decoded($param){
      return base64_decode(urldecode($param));
    }
}