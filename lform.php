<?php
class lForm {
    /*****************************
    QUICK CALL Function
    input field: n form_input
    select box: n form_dropdown
    radio box: n form_radio
    checkbox: n form_checkbox
    textarea: n form_textarea
    upload field: n form_upload
    ******************************/

    /* RENDER FORM FIELDS TEMPLATE */
    public static function form_open($form_id="", $form_method="POST", $form_action = "", $is_enctype = false) {
        return '<form method="'.$form_method.'" '.($action ? "action='".$form_action."'" : "").' name="'.$form_id.'" id="'.$form_id.'" '.($is_enctype ? 'enctype="multipart/form-data"' : '').'>';
    }

    public static function form_close() {
        return '</form>';
    }

    public static function form_input($field_type = "text", $field_name="", $field_id="", $extra_class="", $pre_val="", $label_text = "", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "", $help_text="") {
        return '<div class="form-group '.$col_class.'">
            <label class="'.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
            <input type="'.$field_type.'" name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-control '.$extra_class.'" value="'.$pre_val.'" '.$custom_attr.' '.($is_required ? "required" : "").' aria-describedby="'.$field_id.'helpText"/>
            '.($help_text ? "<span id='".$field_id."helpText' class='form-text text-muted'>".$help_text."</span>" : "").'
        </div>';
    }
    
    public static function form_textarea($field_name="", $field_id="", $extra_class="", $pre_val="", $label_text = "", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "", $help_text="") {
        return '<div class="form-group '.$col_class.'">
            <label class="'.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
            <textarea name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-control '.$extra_class.'" '.$custom_attr.' '.($is_required ? "required" : "").' aria-describedby="'.$field_id.'helpText">'.$pre_val.'</textarea>
            '.($help_text ? "<span id='".$field_id."helpText' class='form-text text-muted'>".$help_text."</span>" : "").'
        </div>';
    }    

    public static function form_hidden($field_name="", $field_id="", $extra_class="", $pre_val="",$custom_attr="") {
        return '
            <input type="hidden" name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-control '.$extra_class.'" value="'.$pre_val.'" '.$custom_attr.' />';
    }

    public static function form_radio($field_name="", $field_id="", $extra_class="", $pre_val="", $label_text = "", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "") {
        return '<div class="form-group '.$col_class.'">
            <input type="radio" name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-check-input '.$extra_class.'" value="'.$pre_val.'" '.$custom_attr.' '.($is_required ? "required" : "").'/>
            <label class="form-check-label '.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
        </div>';
    }

    public static function form_checkbox($field_name="", $field_id="", $extra_class="", $pre_val="", $label_text = "", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "") {
        return '<div class="form-group '.$col_class.'">
            <input type="checkbox" name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-check-input '.$extra_class.'" value="'.$pre_val.'" '.$custom_attr.' '.($is_required ? "required" : "").'/>
            <label class="form-check-label '.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
        </div>';
    }

    public static function form_dropdown($field_name="", $field_id="", $extra_class="", $options=[], $pre_val="", $label_text = "", $custom_attr="",$hidden_label = false, $is_required = false, $col_class="") {
        $render =  '<div class="form-group '.$col_class.'">
            <label class="'.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
            <select name="'.($field_name ? $field_name :$field_id).'" id="'.$field_id.'" class="form-control '.$extra_class.' '.$custom_attr.'" '.($is_required ? "required" : "").'>
            <option value="">--Please select--</option>';
            foreach($options as $key => $val) {
                $render .= '<option '.($pre_val == $key ? "selected" : "").' value="'.$key.'">'.$val.'</option>';
            }
        $render .= '</select></div>';
        return $render;
    }

    public static function form_upload($field_name="", $field_id="", $pre_val="", $extra_class="", $is_required = false, $allow_types="", $label_text="", $hidden_label= false) {
        return '<div class="custom-file">
            <input type="file" class="custom-file-input '.$extra_class.'" id="'.$field_id.'" name="'.$field_name.'" '.($allow_types ? 'accept="'.$allow_types.'"' : '').' '.($is_required ? "required" : "").' value="'.$pre_val.'"/>
            <label class="custom-file-label '.($hidden_label ? "sr-only" : "").'" for="'.$field_id.'">'.$label_text.'</label>
        </div>';
    }

    public function do_upload($file_name = "", $form_upload_path) { //make sure upload path end with the slash
        $file_upload = $_FILES[$file_name];
        if(isset($file_upload) && $file_upload['size'] > 0) { //check if file is not empty
            return (@move_uploaded_file($file_upload['tmp_name'], $form_upload_path.$file_upload['name'])) ? true : false;
        } else {
            return false;
        }
    }

    public static function form_submit($field_name="", $field_id="", $custom_text="Submit", $extra_class="") {
        return '<div class="form-group">
            <button type="submit" name="'.$field_name.'" id="'.$field_id.'" class="btn '.$extra_class.'">'.$custom_text.'</button>
        </div>';
    }

    public static function form_row($fields = [],$extra_class="") {
        $render = '<div class="form-row '.$extra_class.'">';
        foreach($fields as $field) {
            $render .= $field;
        }
        $render .= '</div>';
        return $render;
    }

    public static function form_message($msg = "", $type = "primary") {
        $render = "";
        switch($type) {
            case "success":
                $render = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
                break;
            case "info":
                $render = '<div class="alert alert-info" role="alert">'.$msg.'</div>';
                break;
            case "error":
                $render = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
                break;
            case "warning":
                $render = '<div class="alert alert-warning" role="alert">'.$msg.'</div>';
                break;
            break;
            default:
                $render = '<div class="alert alert-primary" role="alert">'.$msg.'</div>';
                break;
        }
        return $render;
    }

    public static function form_csrf($token_name, $token) {
        return '<input type="hidden" name="'.$token_name.'" value="'.$token.'">';
    }

    /* END OF RENDER FORM FIELDS TEMPLATE */


    /* BUILT IN FUNCTION */
    public static function form_check_token($post_name = "", $session_token_name = "") {
        if(isset($_POST[$post_name])){
            $filter_token = strip_tags(filter_var(substr($_POST[$post_name], 0, 128), FILTER_SANITIZE_STRING));
            if($_SESSION[$session_token_name] == $filter_token){
                unset($_SESSION[$session_token_name]); //name of preset session token
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function make_csrf_token() { //remember to put session_start at beginning of the code to use this function.
        return strtoupper(md5(uniqid(rand(), TRUE)));
    }
    public static function filter_post($field_name, $max_length) {
        return strip_tags(filter_var(substr($field_name, 0, $max_length), FILTER_SANITIZE_STRING));
    }

    public static function is_validated($field_name) { //check for empty field
        return (empty($field_name) || $field_name == "") ? false : true;
    }

    public static function is_email($field_name) {
        return (!filter_var($field_name, FILTER_VALIDATE_EMAIL)) ? false : true;
    }

    function send_mail($subject = "", $from ="no-reply@admin.ca", $from_title = "Automatic Mail System",
                       $to = "", $cc_to = [], $bcc_to = [], $message = "", $attachment_files = "") {

        //this function requires PHPMailer library.
        $mail = new PHPMailer();
        $mail->setFrom($from, $from_title);
        $mail->addAddress($to);
        if(count($cc_to) > 0) {
            foreach($cc_to as $cc) {
                $mail->addCC($cc);
            }
        }
        if(count($bcc_to) > 0) {
            foreach($bcc_to as $bcc) {
                $mail->addBCC($bcc);
            }
        }
        if(!empty($attachment_files)) {
            $mail->addAttachment($attachment_files);
        }
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        if(!$mail->send()) {
            return false;
        } else {
            $mail->ClearAddresses();
            return true;
        }
    }

}
?>
