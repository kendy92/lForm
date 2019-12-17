# lForm

lForm is a PHP framework to help you build a secure backend form with less time-consuming.

## Why should you use this framework?
- Small & lightweight form php framework ever.
- Speed up form building in the backend and syncing with latest bootstrap layout.
- Worry-free of AODA & inconsistency design in frond end and more focus on backend.
- Less 50% coding compared to original HTML form syntax.
- Easy to manage and reusable for future projects.
- Compatible to all scale of projects.

## Installation
- Require PHP version higher than 5.6.
- Require the Bootstrap version higher than 3.0.
- Reference lForm.php in your project folder and it is ready to use. Just that simple!
```bash
  include_once("lform.php");
```

## Sample Code

```php
	session_start(); //this is required to use CSRF feature.
	include_once("lform.php");	
	$items = [
	    1 => "Province 1",
	    2 => "Province 2",
	    3 => "Province 3",
	];
	$upload_path = "/upload_path/tmp/"; // upload path
	
	$fname = "";
	$email = "";
	$province = "";
	$essay_file = "";
	$validate_message = "";
	/* Handle Form submission */
	if(isset($_POST['submitFrm'])):
		$fname = lForm::filter_post($_POST['fnameInput'], 50);
		$email = lForm::filter_post($_POST['emailInput'], 255);
		$province = lForm::filter_post($_POST['provinceSelect'], 100);
		$essay_file = $_FILES['essayUpload'];
		
		if(!lForm::is_validated($fname)):
			$validate_message = lForm::form_message($msg = "First name field is required", $type = "warning");
		elseif(!lForm::is_validated($email)):
			$validate_message = lForm::form_message($msg = "Email field is required", $type = "warning");
		elseif(!lForm::is_email($email)):
			$validate_message = lForm::form_message($msg = "Please enter valid email", $type = "warning");
		elseif(!lForm::is_validated($province)):
			$validate_message = lForm::form_message($msg = "Please select province", $type = "warning");
		else:
			if(lForm::form_check_token($post_name = "csrf_token", $session_token_name = "csrf_token")):
				if(lForm::do_upload($file_name = "essayUpload", $upload_path)):
					$validate_message = lForm::form_message($msg = "Done", $type = "success");
				else:
					$validate_message = lForm::form_message($msg = "Essay file is required", $type = "warning");
				endif;
			else:
				$validate_message = lForm::form_message($msg = "CSRF detected. leave!", $type = "error");
			endif;
		endif;
	endif;
	/* Generate CSRF_Token */
	$token = lForm::make_csrf_token();
	$_SESSION['csrf_token'] = $token;	
	/* Render form template */
	echo 
	"<div>".$validate_message."</div>".
	lForm::form_open($form_id="testFrm", $form_method="POST", $form_action = "", $is_enctype = true).
	lForm::form_row($fields = [
		lForm::form_input($field_type = "text", $field_name="fnameInput", $field_id="fnameInput", $extra_class="", $pre_val= $fname, $label_text = "First Name", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "col-6",$help_text=""),
		lForm::form_input($field_type = "email", $field_name="emailInput", $field_id="emailInput", $extra_class="", $pre_val= $email, $label_text = "Email", $custom_attr="",$hidden_label = false, $is_required = false, $col_class= "col-6", $help_text="")
	],$extra_class="").
	lForm::form_dropdown($field_name="provinceSelect", $field_id="provinceSelect", $extra_class="", $options=$items, $pre_val= $province, $label_text = "Province", $custom_attr="",$hidden_label = false, $is_required = false, $col_class="").
	lForm::form_upload($field_name="essayUpload", $field_id="essayUpload", $pre_val= "", $extra_class="", $is_required = false, $allow_types="", $label_text="Essay Upload", $hidden_label= false).
	lForm::form_submit($field_name="submitFrm", $field_id="submitFrm", $custom_text="Submit", $extra_class="btn-lg").
	lForm::form_csrf('csrf_token', $token).
	lForm::form_close();
```
Any queries or feedback please send it to: dinhconganh@gmail.com 

Happy Coding!
