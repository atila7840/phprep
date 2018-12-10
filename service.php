<?php

include('../wp-load.php');

$url = $_POST['url'];

$postid = url_to_postid( $url );

$post = get_post($postid);

$action = $post->post_content;//substr(rtrim($url, '/'), strrpos (rtrim($url, '/') , '/' )+1 );

switch( $action ){
	case 'lavosoli':
		$retval = file_get_contents("htmlForms/lavosoliform.html");
		break;
	
	case 'virtualVosoli';
		$retval = file_get_contents(getHTMLFormsURL()."virtualVosoliform.php");
		break;

	case 'tajziehseni';
		$retval = file_get_contents(getHTMLFormsURL()."tajziehseniform.php");
		break;

	case 'fasli';
		$retval = file_get_contents("htmlForms/fasliform.html");
		break;
	case 'vosolimoshtarak';
		$retval = file_get_contents("htmlForms/vosolimoshtarakform.html");
		break;

	case 'taraz';
		$retval = file_get_contents("htmlForms/tarazform.html");
		break;

	case 'vosolisabtenam';
		 $retval = file_get_contents(getHTMLFormsURL()."vosolisabtenamform.php");
		break;		

	case 'vosolisotoh';
		$retval = file_get_contents(getHTMLFormsURL()."sotohvosoliform.php");
		break;

	case 'incomecountry';
		$retval = file_get_contents(getHTMLFormsURL()."incomecountryform.php");
		break;


	default:
		$retval = 'Incorrect action';
		break;
}

echo $retval;

function getHTMLFormsURL(){
	return "http"."://".$_SERVER['SERVER_NAME'].'/wordpress/service/htmlForms/';
}

?>