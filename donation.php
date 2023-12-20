<?php

/*

if(isset($_GET['step']) && $_GET['step'] == 2 ) {

	require_once('password_protect.php');

}

*/

?>





<?php

//error_reporting(E_ALL);

//ini_set('display_errors', 0);

session_start();

$version = "v2.5.0";

$path_dev = (!empty($_ENV['APPLICATION'])&&$_ENV['APPLICATION']=="dev"?"/dev":"");

$path_app = $_SERVER["DOCUMENT_ROOT"].$path_dev;

$path_host = "https://".$_SERVER["HTTP_HOST"].$path_dev;





function debug($a) {

    if($_SERVER["REMOTE_ADDR"]==='191.177.25.156') {

        print_r_pre($a);

    }

}



function print_r_pre($a) { echo '<pre>'.print_r($a,true).'</pre>'; }



/*

// Version 2.0.0

$version = "v2.0.0";

$_ENV['APPLICATION'] = "dev";

$path_dev = (!empty($_ENV['APPLICATION']) && $_ENV['APPLICATION'] == "dev") ? "/www.hillelsv.org/secure.hillelsv.org/" :"";

$path_app = $_SERVER["DOCUMENT_ROOT"].$path_dev;

$path_host = "//".$_SERVER["HTTP_HOST"].$path_dev;

*/

//phpinfo(32);

//require_once "pillarsPaymentPage_closed.php";

//exit;

/**

 * /public_html/secure.hillelsv.org

 * E:\www\adam.com\hillelsv.org\public_html\secure.hillelsv.org\

 **/

//echo $_SERVER['SERVER_ADDR'];

$debug = 0;

//define('SANDBOX', ($_SERVER['SERVER_ADDR']=='192.185.118.96'?1:0));

define('SANDBOX', 0);

define('PAYMENT_DEBUG', 0);

//$this_script = end(explode("/", $_SERVER['PHP_SELF']));

//$this_script = "pillarsPaymentPage.php";

$this_script = basename(__FILE__);

//include_once "$path_app/inc/functions.php";

//include_once "$path_app/inc/countries.php";

include_once getcwd()."/inc/functions.php";

include_once getcwd()."/inc/countries.php";



$payment_percentage_discount = 3;

$payment_type = isset_('type', 4);



if($payment_type!=1 && $payment_type!=2) $payment_type = 0;



$payment_step = isset_('step', 4);



if(($payment_step==2 && $payment_type==0) || ($payment_step!=1 && $payment_step!=2 && $payment_step!=3 && $payment_step!=4 && $payment_step!=5)) $payment_step = 1;



if($payment_step!=5) unset($_SESSION['Payment-Pillars']);



if(isset_("action", 4) == "state") {

    $name = isset_("name", 4);

    $country = isset_("country", 4);

    $selected = isset_("selected", 4);

    $pars = isset_("pars", 4);

    $only_options = isset_("only_options", 4, false);



    if(!empty($only_options) || (empty($only_options) && !empty($name))) echo fn_states_html_select($name, $country, $selected, $pars, $only_options);

    exit;

}

if(!empty($debug) || SANDBOX)

{	/* Init Vars Debug */

    $payment_sponsorship = 0;

    $payment_tribute_ad = "";

    $payment_guest_tickets = "";

    $payment_general_donation = "";

    $payment_firstName = "John";

    $payment_lastName = "Doe";

    $payment_creditCardType = "Visa";

    $payment_creditCardNumber = "";

    $payment_expDateMonth = "3";

    $payment_expDateYear = "2015";

    $payment_cvv2Number = "962";

    $payment_country = "US";

    $payment_state = "CA";

    $payment_city = "San Jose";

    $payment_address1 = "1 Main St";

    $payment_address2 = "";

    $payment_zip = "95131";

    $payment_phone = "+55 11 9999 8888";

    $payment_phone_cell = "";

    $payment_phone_home = "1";

    $payment_email = "teste@teste.com";

    $payment_relationshipToHillel = "";

    $payment_class = "";

    $payment_school = "";

    $payment_amount = empty($payment_amount)?"100":$payment_amount;

    $payment_amount_without_tax = $payment_amount;

    $payment_processing_fees = "";

    /* End Debug */

}

else

{

    $payment_sponsorship = 0;

    $payment_tribute_ad = 0;

    $payment_guest_tickets = 0;

    $payment_general_donation = "";

    $payment_firstName = "";

    $payment_lastName = "";

    $payment_creditCardType = "";

    $payment_creditCardNumber = "";

    $payment_expDateMonth = "";

    $payment_expDateYear = "";

    $payment_cvv2Number = "";

    $payment_country = "US";

    $payment_state = "";

    $payment_city = "";

    $payment_address1 = "";

    $payment_address2 = "";

    $payment_zip = "";

    $payment_phone = "";

    $payment_phone_cell = "";

    $payment_phone_home = "";

    $payment_email = "sarita@hillelsv.org";

    $payment_amount = "";

    $payment_amount_without_tax = 0;

    $payment_processing_fees = "";

    $payment_relationshipToHillel = "";

    $payment_class = "";

    $payment_school = "";
}

$payment_creditCardType_arr = array (

    "Visa"			=> "Visa",

    "MasterCard"	=> "MasterCard",

    "Discover"		=> "Discover",

    "Amex"			=> "Amex"

);



$ticketsNumberArr = array(

    array("text"=>"Please choose",  "textAmount"=>"",       "amount"=>   0),

    array("text"=>"One",            "textAmount"=>"$72",    "amount"=>  72),

    array("text"=>"Two",            "textAmount"=>"$144",   "amount"=> 144),

    array("text"=>"Three",          "textAmount"=>"$216",   "amount"=> 216),

    array("text"=>"Four",           "textAmount"=>"$288",   "amount"=> 288),

    array("text"=>"Five",           "textAmount"=>"$360",   "amount"=> 360),

    array("text"=>"Six",            "textAmount"=>"$432",   "amount"=> 432),

    array("text"=>"Seven",          "textAmount"=>"$504",   "amount"=> 504),

    array("text"=>"Eight",          "textAmount"=>"$576",   "amount"=> 576),

    array("text"=>"Nine",           "textAmount"=>"$648",   "amount"=> 648),

    array("text"=>"Table of Ten",   "textAmount"=>"$720",   "amount"=> 720)

);



$ticketsNumberStudentArr = array(

    array("text"=>"Please choose",  "textAmount"=>"",        "amount"=>    0),

    array("text"=>"One ticket",     "textAmount"=>"$18",     "amount"=>   18),

    array("text"=>"Two tickets",    "textAmount"=>"$36",     "amount"=>   36),

    array("text"=>"Three tickets",  "textAmount"=>"$54",     "amount"=>   54),

    array("text"=>"Four tickets",   "textAmount"=>"$72",     "amount"=>   72),

    array("text"=>"Five tickets",   "textAmount"=>"$90",     "amount"=>   90),

    array("text"=>"Six tickets",    "textAmount"=>"$108",    "amount"=>  108),

    array("text"=>"Seven tickets",  "textAmount"=>"$126",    "amount"=>  126),

    array("text"=>"Eight tickets",  "textAmount"=>"$144",    "amount"=>  144),

    array("text"=>"Nine tickets",   "textAmount"=>"$162",    "amount"=>  162),

    array("text"=>"Ten tickets",    "textAmount"=>"$180",    "amount"=>  180)

);



$ticketsNumberYoungAlumniArr = array(

    array("text"=>"Please choose",  "textAmount"=>"",        "amount"=>    0),

    array("text"=>"One ticket",     "textAmount"=>"$36",     "amount"=>   36),

    array("text"=>"Two tickets",    "textAmount"=>"$72",     "amount"=>   72),

    array("text"=>"Three tickets",  "textAmount"=>"$108",     "amount"=>   108),

    array("text"=>"Four tickets",   "textAmount"=>"$144",     "amount"=>   144),

    array("text"=>"Five tickets",   "textAmount"=>"$180",     "amount"=>   180),

    array("text"=>"Six tickets",    "textAmount"=>"$216",    "amount"=>  216),

    array("text"=>"Seven tickets",  "textAmount"=>"$252",    "amount"=>  252),

    array("text"=>"Eight tickets",  "textAmount"=>"$288",    "amount"=>  288),

    array("text"=>"Nine tickets",   "textAmount"=>"$324",    "amount"=>  324),

    array("text"=>"Ten tickets",    "textAmount"=>"$360",    "amount"=>  360)

);



$sponsorshipPriceArr = array(

    array(

        "text"		=> "Please select desired sponsorship level",

        "tickets"	=> 0,

        "amount"	=> 0

    ),
	
	    array(

        "text"		=> "Abraham - $25,000 (10 tickets)",

        "tickets"	=> 10,

        "amount"	=> 18000

    ),

    array(

        "text"		=> "Moses - $18,000 (6 tickets)",

        "tickets"	=> 6,

        "amount"	=> 18000

    ),

    array(

        "text"		=> "Miriam - $10,000 (4 tickets)",

        "tickets"	=> 4,

        "amount"	=> 10000

    ),

    array(

        "text"		=> "Prophet Deborah - $5,000 (2 tickets)",

        "tickets"	=> 2,

        "amount"	=> 5000

    ),

    array(

        "text"		=> "King David - $3,600 (2 tickets)",

        "tickets"	=> 2,

        "amount"	=> 3600

    ),

    array(

        "text"		=> "Judah Maccabee - $1,800",

        "tickets"	=> 0,

        "amount"	=> 2500

    )
);



$sponsorshipTributePriceArr = array(



    array("text"=>"Please select desired Tribute Ad", "amount"=>   0)

, array("text"=>"Queen Esther - $1,000 - Full page B&W ad", "amount"=> 1000)

, array("text"=>"Theodore Herzl - $720 - 1/2 page B&W ad", "amount"=>  720)

, array("text"=>"Golda Meir - $540 - 1/4 page B&W ad", "amount"=>  540)

, array("text"=>"Elie Weisel - $360 - Business card ad", "amount"=>  360)

, array("text"=>"David Ben-Gurion - $180 - Mazal tov greeting (10 words)",   "amount"=>   180)

    //, array("text"=>"Eighth Page	- $    175",   "amount"=>   175)

    //, array("text"=>"Mazel Tov	- $      50",   "amount"=>   50)

);



$sponsorshipStandardGreetingArr = array(

    "Please choose"

, "Mazel Tov to Hillel of Silicon Valley and the Honorees"

, "Mazel Tov to all the L'Dor V'Dor of the Community Honorees"

, "Mazel Tov to L'Dor V'Dor Honorees and"

, "My own greeting"

);



$ticketsNamesArr = array(

    array("name"=>"", "food"=>"")

);



$additional = 72;



$formVars = array();



$formVars["sponsorshipPrice"] = isset_("sponsorshipPrice", 2, 0);

$formVars["sponsorshipPrice"] = is_numeric($formVars["sponsorshipPrice"])?(int)$formVars["sponsorshipPrice"]:0;

$formVars["sponsorshipPrice"] = isset($sponsorshipPriceArr[$formVars["sponsorshipPrice"]])?$formVars["sponsorshipPrice"]:0;

$payment_sponsorship = $sponsorshipPriceArr[$formVars["sponsorshipPrice"]]["amount"];

$formVars["sponsorshipTributePrice"] = isset_("sponsorshipTributePrice", 2, 0);

$formVars["sponsorshipTributePrice"] = is_numeric($formVars["sponsorshipTributePrice"])?(int)$formVars["sponsorshipTributePrice"]:0;

$formVars["sponsorshipTributePrice"] = isset($sponsorshipTributePriceArr[$formVars["sponsorshipTributePrice"]])?$formVars["sponsorshipTributePrice"]:0;

$payment_tribute_ad = $sponsorshipTributePriceArr[$formVars["sponsorshipTributePrice"]]["amount"];

$formVars["sponsorshipStandardGreeting"] = isset_("sponsorshipStandardGreeting", 2, 0);

$formVars["sponsorshipStandardGreeting"] = is_numeric($formVars["sponsorshipStandardGreeting"])?(int)$formVars["sponsorshipStandardGreeting"]:0;

$formVars["sponsorshipStandardGreetingInput"] = isset_("sponsorshipStandardGreetingInput", 2);

$payment_firstName = $formVars["ticketsFirstName"] = isset_("ticketsFirstName", 2, $payment_firstName);

$payment_lastName = $formVars["ticketsLastName"] = isset_("ticketsLastName", 2, $payment_lastName);

$payment_country = $formVars["ticketsCountry"] = isset_("ticketsCountry", 2, $payment_country);

$payment_state = $formVars["ticketsState"] = isset_("ticketsState", 2, $payment_state);

$payment_city = $formVars["ticketsCity"] = isset_("ticketsCity", 2, $payment_city);

$payment_address1 = $formVars["ticketsAddress1"] = isset_("ticketsAddress1", 2, $payment_address1);

$payment_address2 = $formVars["ticketsAddress2"] = isset_("ticketsAddress2", 2, $payment_address2);

$payment_zip = $formVars["ticketsZip"] = isset_("ticketsZip", 2, $payment_zip);

$payment_email = $formVars["ticketsEmail"] = isset_("ticketsEmail", 2, $payment_email);

$formVars["ticketsNumber"] = isset_("ticketsNumber", 2, 0);

$formVars["ticketsNumber"] = is_numeric($formVars["ticketsNumber"])?(int)$formVars["ticketsNumber"]:0;

$formVars["ticketsGuestsRegistered"] = !empty($ticketsNumberArr[$formVars["ticketsNumber"]]['amount'])?$ticketsNumberArr[$formVars["ticketsNumber"]]['amount']:0;

$sponsorshipPriceArrTicket = 0;

if($formVars["ticketsNumber"]>0 && $formVars["sponsorshipPrice"]>0 && !empty($sponsorshipPriceArr[$formVars["sponsorshipPrice"]]["tickets"])) {

    $sponsorshipPriceArrTicket = $sponsorshipPriceArr[$formVars["sponsorshipPrice"]]["tickets"];

    $formVars["ticketsGuestsRegistered"] = 0;

    if($formVars["ticketsNumber"]>$sponsorshipPriceArrTicket)

        $formVars["ticketsGuestsRegistered"] = !empty($ticketsNumberArr[($formVars["ticketsNumber"]-$sponsorshipPriceArrTicket)]['amount'])?$ticketsNumberArr[($formVars["ticketsNumber"]-$sponsorshipPriceArrTicket)]['amount']:0;

}

$formVars["ticketsNumberStudent"] = isset_("ticketsNumberStudent", 2, 0);

$formVars["ticketsNumberStudent"] = is_numeric($formVars["ticketsNumberStudent"])?(int)$formVars["ticketsNumberStudent"]:0;

$formVars["ticketsNumberYoungAlumni"] = isset_("ticketsNumberYoungAlumni", 2, 0);

$formVars["ticketsNumberYoungAlumni"] = is_numeric($formVars["ticketsNumberYoungAlumni"])?(int)$formVars["ticketsNumberYoungAlumni"]:0;

if(!empty($ticketsNumberStudentArr[$formVars["ticketsNumberStudent"]]['amount'])) $formVars["ticketsGuestsRegistered"] += $ticketsNumberStudentArr[$formVars["ticketsNumberStudent"]]['amount'];

if(!empty($ticketsNumberYoungAlumniArr[$formVars["ticketsNumberYoungAlumni"]]['amount'])) $formVars["ticketsGuestsRegistered"] += $ticketsNumberYoungAlumniArr[$formVars["ticketsNumberYoungAlumni"]]['amount'];

$payment_guest_tickets = $formVars["ticketsGuestsRegistered"];

$formVars["ticketsNames"] = isset_("ticketsNames", 2, $ticketsNamesArr);

$formVars["ticketsNames"] = is_array($formVars["ticketsNames"]) ? $formVars["ticketsNames"] : $ticketsNamesArr;





foreach ($formVars["ticketsNames"] as $key => $value) {

    //$formVars["ticketsNames"][$key] = array("name"=>filtra($value["name"]), "food"=>filtra($value["food"]));

    if(isset($value["name"])) $formVars["ticketsNames"][$key]["name"] = filtra($value["name"]);

    if(isset($value["food"])) $formVars["ticketsNames"][$key]["food"] = filtra($value["food"]);

}







$formVars["ticketsSeatingPreference"] = isset_("ticketsSeatingPreference", 2);

$formVars["ticketsTotalUnderwriter"] = 0; //isset_("ticketsTotalUnderwriter", 2, 0);

$formVars["ticketsAdditionalGuests"] = 0; //isset_("ticketsAdditionalGuests", 2, 0);



if($formVars["ticketsNumber"]>0) $formVars["ticketsAdditionalGuests"] = $formVars["ticketsNumber"];



if($sponsorshipPriceArrTicket>0 && $formVars["ticketsNumber"]>0) {

    $formVars["ticketsTotalUnderwriter"] = $formVars["ticketsNumber"]>$sponsorshipPriceArrTicket?$sponsorshipPriceArrTicket:$formVars["ticketsNumber"];

    $formVars["ticketsAdditionalGuests"] = $formVars["ticketsNumber"]>$sponsorshipPriceArrTicket?($formVars["ticketsNumber"]-$sponsorshipPriceArrTicket):0;

}



$formVars["ticketsAdditionalStudentGuests"] = 0; //isset_("ticketsAdditionalStudentGuests", 2, 0);

$formVars["ticketsAdditionalYoungAlumniGuests"] = 0;

if($formVars["ticketsNumberStudent"]>0) $formVars["ticketsAdditionalStudentGuests"] += $formVars["ticketsNumberStudent"];



if($formVars["ticketsNumberYoungAlumni"]>0) $formVars["ticketsAdditionalYoungAlumniGuests"] += $formVars["ticketsNumberYoungAlumni"];



$payment_sponsorship = isset_("payment_sponsorship", 2, $payment_sponsorship);

$payment_tribute_ad = isset_("payment_tribute_ad", 2, $payment_tribute_ad);

$payment_guest_tickets = isset_("payment_guest_tickets", 2, $payment_guest_tickets);

$payment_general_donation = isset_("payment_general_donation", 2, $payment_general_donation);

$payment_general_donation = is_numeric($payment_general_donation)?floatval($payment_general_donation):0;

$payment_amount = $payment_sponsorship + $payment_tribute_ad + $payment_guest_tickets + $payment_general_donation;

$payment_amount_without_tax = trim(isset_("payment_amount_without_tax", 2, $payment_amount_without_tax));



if(!is_numeric($payment_amount_without_tax)) $payment_amount_without_tax = 0;



$payment_processing_fees = isset_("payment_processing_fees", 2, $payment_processing_fees);



if(!empty($payment_processing_fees)) $payment_amount = round($payment_amount+($payment_amount*($payment_percentage_discount/100)), 2);



$payment_firstName = isset_("payment_firstName", 2, $payment_firstName);

$payment_lastName = isset_("payment_lastName", 2, $payment_lastName);

$payment_creditCardType = isset_("payment_creditCardType", 2, $payment_creditCardType);

$payment_creditCardNumber = trim(isset_("payment_creditCardNumber", 2, $payment_creditCardNumber));

$payment_expDateMonth = isset_("payment_expDateMonth", 2, $payment_expDateMonth);

$payment_expDateYear = isset_("payment_expDateYear", 2, $payment_expDateYear);

$payment_cvv2Number = isset_("payment_cvv2Number", 2, $payment_cvv2Number);

$payment_country = isset_("payment_country", 2, $payment_country);

$payment_state = isset_("payment_state", 2, $payment_state);

$payment_city = isset_("payment_city", 2, $payment_city);

$payment_address1 = isset_("payment_address1", 2, $payment_address1);

$payment_address2 = isset_("payment_address2", 2, $payment_address2);

$payment_zip = isset_("payment_zip", 2, $payment_zip);

$payment_phone = isset_("payment_phone", 2, $payment_phone);

$payment_phone_cell = isset_("payment_phone_cell", 2, $payment_phone_cell);

$payment_phone_home = isset_("payment_phone_home", 2, $payment_phone_home);

$payment_email = isset_("payment_email", 2, $payment_email);

$payment_relationshipToHillel = isset_("payment_relationshipToHillel", 2, $payment_relationshipToHillel);

$payment_class = isset_("payment_class", 2, $payment_class);

$payment_school = isset_("payment_school", 2, $payment_school);



$formVarsPayment = array();



if(isset_("paymentStepBack", 2, false)) {



    $formVarsPayment["payment_general_donation"] = $payment_general_donation;

    $formVarsPayment["payment_amount_without_tax"] = $payment_amount_without_tax;

    $formVarsPayment["payment_processing_fees"] = $payment_processing_fees;

    $formVarsPayment["payment_firstName"] = $payment_firstName;

    $formVarsPayment["payment_lastName"] = $payment_lastName;

    $formVarsPayment["payment_creditCardType"] = $payment_creditCardType;

    $formVarsPayment["payment_creditCardNumber"] = $payment_creditCardNumber;

    $formVarsPayment["payment_expDateMonth"] = $payment_expDateMonth;

    $formVarsPayment["payment_expDateYear"] = $payment_expDateYear;

    $formVarsPayment["payment_cvv2Number"] = $payment_cvv2Number;

    $formVarsPayment["payment_country"] = $payment_country;

    $formVarsPayment["payment_state"] = $payment_state;

    $formVarsPayment["payment_city"] = $payment_city;

    $formVarsPayment["payment_address1"] = $payment_address1;

    $formVarsPayment["payment_address2"] = $payment_address2;

    $formVarsPayment["payment_zip"] = $payment_zip;

    $formVarsPayment["payment_phone"] = $payment_phone;

    $formVarsPayment["payment_phone_cell"] = $payment_phone_cell;

    $formVarsPayment["payment_phone_home"] = $payment_phone_home;

    $formVarsPayment["payment_email"] = $payment_email;

    $formVarsPayment["payment_relationshipToHillel"] = $payment_relationshipToHillel;

    $formVarsPayment["payment_class"] = $payment_class;

    $formVarsPayment["payment_school"] = $payment_school;



}



$error = array();



if($payment_step == 4) {



    if(empty($payment_amount)||!is_numeric($payment_amount)) $error["payment_amount"] = "Total payment amount is necessary.";

    if(empty($payment_firstName)) $error["payment_firstName"] = "Type your Payment First name.";

    if(empty($payment_lastName)) $error["payment_lastName"] = "Type your Payment Last name.";

    if(empty($payment_country)) $error["payment_country"] = "Type your Payment Country.";

    if(empty($payment_state)) $error["payment_state"] = "Type your Payment State.";

    if(empty($payment_city)) $error["payment_city"] = "Type your Payment City.";

    if(empty($payment_address1)) $error["payment_address1"] = "Type your Payment Address.";

    if(empty($payment_zip)||strlen($payment_zip)<5) $error["payment_zip"] = "Type your Payment ZIP code.";

    if(empty($payment_phone)) $error["payment_phone"] = "Type your Payment Phone number.";

    if(empty($payment_phone_cell) && empty($payment_phone_home)) $error["payment_phone"] = "Type your Payment Phone type(Cell,Home).";

    if(empty($payment_email)||!is_email($payment_email)) $error["payment_email"] = "Type your Payment Mail address.'";

    if(empty($payment_creditCardType)) $error["payment_creditCardType"] = "Type your Credit Card Type.";

    if(empty($payment_creditCardNumber)||!is_numeric($payment_creditCardNumber)) $error["payment_creditCardNumber"] = "Type your Credit Card Number.";

    if(empty($payment_expDateMonth)||!is_numeric($payment_expDateMonth)||empty($payment_expDateYear)||!is_numeric($payment_expDateYear)) $error["payment_expDates"] = "Type your Credit Card Expiration Date.";

    if(empty($payment_cvv2Number)||!is_numeric($payment_cvv2Number)) $error["payment_cvv2Number"] = "Type your Credit Card Security Code.";

}



if(count($error)>0) $payment_step = 3;





//Functions



function print_input ($v, $r=false, $d=false) {

    foreach ($v as $key => $val) {

        $text = empty($r)?$key:$r.'['.$key.']';

        if(is_array($val)) {

            print_input ($val, $text, $d);

        } else {

            if($d) {

                echo '<div class="row-fluid">

						<div class="span4"><i>'.$text.'</i></div>

						<div class="span8"><input type="text" name="'.$text.'" value="'.$val.'" ></div>

					</div>';

            } else {

                echo '<input type="hidden" name="'.$text.'" value="'.$val.'">';

            }

        }

    }



}if($payment_step==4) {



    //echo '<pre>'.print_r($GLOBALS, true).'</pre>';



    //exit;



    /* CONSTANTS ************************************************************** */



    if(!defined('PAYMENT_DEBUG')) define('PAYMENT_DEBUG', 0);



    if(!defined('SANDBOX')) exit('Fail: SANDBOX not defined!');



    /* API user: The user that is identified as making the call. you can also use your own API username that you created on PayPal’s sandbox or the PayPal live site */



    if(SANDBOX) define('API_USERNAME', 'vende_1356909137_biz_api1.gmail.com');



    else define('API_USERNAME', 'director_api1.hillelsv.org');



    /**



     * API_password: The password associated with the API user If you are using your own API username, enter the API password that was generated by PayPal below



     * IMPORTANT - HAVING YOUR API PASSWORD INCLUDED IN THE MANNER IS NOT SECURE, AND ITS ONLY BEING SHOWN THIS WAY FOR TESTING PURPOSES



     */



    if(SANDBOX) define('API_PASSWORD', '1356909170');



    else define('API_PASSWORD', 'MF547FACUY7PGLV4');



    /* API_Signature:The Signature associated with the API user. which is generated by paypal. */



    if(SANDBOX) define('API_SIGNATURE', 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AlWch.kMnG2ujb9Ktk2.gi8xZyoe');



    else define('API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AG6QYFT6-C6qxHDmiX7AviwMBEOT');



    /* Endpoint: this is the server URL which you have to connect for submitting your API request.*/



    if(SANDBOX) define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');



    else define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');



    /*



    Define the PayPal URL. This is the URL that the buyer is first sent to to authorize payment with their paypal account change the URL depending



    if you are testing on the sandbox or going to the live PayPal site For the sandbox,



    the URL is https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=



    For the live site, the URL is https://www.paypal.com/webscr&cmd=_express-checkout&token=



    */



    if(SANDBOX) define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');



    else define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');



    /* Third party Email address that you granted permission to make api call.*/



    define('API_SUBJECT', '');



    /*USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.like define('USE_PROXY',TRUE);*/



    define('USE_PROXY', FALSE);



    /*



    PROXY_HOST: Set the host name or the IP address of proxy server.



    PROXY_PORT: Set proxy port.



    PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE



    */



    define('PROXY_HOST', '127.0.0.1');



    define('PROXY_PORT', '808');



    /* Version: this is the API version in the request.It is a mandatory parameter for each API request.The only supported value at this time is 2.3 */



    define('API_VERSION', '61.0');



    // Ack related constants



    define('ACK_SUCCESS', 'SUCCESS');



    define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');



    /* END CONSTANTS */







    /* CALLER SERVICE */



    /**



     * hash_call: Function to perform the API call to PayPal using API signature



     * @methodName is name of API  method.



     * @nvpStr is nvp string.



     * returns an associtive array containing the response from the server.



     */



    function hash_call($methodName,$nvpStr)



    {



        //setting the curl parameters.



        $ch = curl_init();



        curl_setopt($ch, CURLOPT_URL,API_ENDPOINT);



        curl_setopt($ch, CURLOPT_VERBOSE, 1);



        //turning off the server and peer verification(TrustManager Concept).



        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);



        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);



        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);



        curl_setopt($ch, CURLOPT_POST, 1);



        //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.



        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php



        if(USE_PROXY)



            curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);



        //check if version is included in $nvpStr else include the version.



        if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {



            $nvpStr = "&VERSION=" . urlencode(API_VERSION) . $nvpStr;



        }







        $nvpreq="METHOD=".urlencode($methodName).$nvpStr;







        //setting the nvpreq as POST FIELD to curl



        curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);



        //getting response from server



        $response = curl_exec($ch);



        //convrting NVPResponse to an Associative Array



        $nvpResArray = deformatNVP($response);



        $nvpReqArray = deformatNVP($nvpreq);



        //$_SESSION['PAYMENT_nvpReqArray']=$nvpReqArray;



        if (curl_errno($ch)) {



            // moving to display page to display curl errors



            $_SESSION['PAYMENT_curl_error_no'] = curl_errno($ch) ;



            $_SESSION['PAYMENT_curl_error_msg'] = curl_error($ch);



        } else {



            //closing the curl



            curl_close($ch);



        }



        return $nvpResArray;



    }



    /** This function will take NVPString and convert it to an Associative Array and it will decode the response.



     * It is usefull to search for a particular key and displaying arrays.



     * @nvpstr is NVPString.



     * @nvpArray is Associative Array.



     */



    function deformatNVP($nvpStr)



    {



        $intial = 0;



        $nvpArray = array();



        while(strlen($nvpStr)){



            //postion of Key



            $keypos = strpos($nvpStr,'=');



            //position of value



            $valuepos = strpos($nvpStr,'&') ? strpos($nvpStr,'&'): strlen($nvpStr);



            /*getting the Key and Value values and storing in a Associative Array*/



            $keyval = substr($nvpStr,$intial,$keypos);



            $valval = substr($nvpStr,$keypos+1,$valuepos-$keypos-1);



            //decoding the respose



            $nvpArray[urldecode($keyval)] = urldecode( $valval);



            $nvpStr = substr($nvpStr,$valuepos+1,strlen($nvpStr));



        }



        return $nvpArray;



    }



    /* END CALLER SERVICE */



    /* DO DIRECT PAYMENT RECEIPT */



    /* Set required parameters */



    $payment_type = "Sale";



    $country_code = "US"; //$_POST['countrycode'];



    $payment_currencyCode = "USD";



    $payment_padDateMonth = str_pad($payment_expDateMonth, 2, '0', STR_PAD_LEFT);



    /*



    Construct the request string that will be sent to PayPal.



    The variable $nvpStr contains all the variables and is a name value pair string with & as a delimiter



    */



    /*USER=xxx



    &PWD=xxxx



    &SIGNATURE=xx



    &AMT=14.95



    &CREDITCARDTYPE=Visa



    &ACCT=4109985144405283



    &EXPDATE=112012



    &CVV2=123



    &FIRSTNAME=



    &LASTNAME=



    &STREET=123+some+road



    &CITY=vancouver



    &STATE=BC



    &ZIP=V1V+1V1



    &COUNTRYCODE=CA



    &CURRENCYCODE=USD











    &VERSION=60



    &METHOD=CreateRecurringPaymentsProfile



    &PROFILESTARTDATE=2009-11-20T0%3A0%3A0



    &BILLINGPERIOD=Month



    &BILLINGFREQUENCY=1



    &DESC=test*/



    $payment_amount_discounted = !empty($payment_amount_discount)?$payment_amount-($payment_amount*($payment_amount_discount/100)):$payment_amount;



    $nvpArr = array(



        "USER" => urlencode(API_USERNAME)



    ,"PWD" => urlencode(API_PASSWORD)



    ,"SIGNATURE" => urlencode(API_SIGNATURE)



    ,"SUBJECT" => urlencode(API_SUBJECT)



    ,"PAYMENTACTION" => $payment_type



    ,"AMT" => $payment_amount_discounted



    ,"CREDITCARDTYPE" => $payment_creditCardType



    ,"ACCT" => $payment_creditCardNumber



    ,"EXPDATE" => $payment_padDateMonth.$payment_expDateYear



    ,"CVV2" => $payment_cvv2Number



    ,"L_NAME0" => "Donations are Tax Deductible"



    ,"L_DESC0" => ""



    ,"L_AMT0" => $payment_amount_discounted



    ,"L_NUMBER0" => 1



    ,"L_QTY0" => 1



    ,"FIRSTNAME" => $payment_firstName



    ,"LASTNAME" => $payment_lastName



    ,"STREET" => $payment_address1



    ,"CITY" => $payment_city



    ,"ZIP" => $payment_zip



    ,"COUNTRYCODE" => $country_code



    ,"STATE" => $payment_state



    ,"CURRENCYCODE" => $payment_currencyCode



    );



    $nvpStr = "&".http_build_query($nvpArr);







    /* Make the API call to PayPal, using API signature.



    The API response is stored in an associative array called $resArray */



    if(!PAYMENT_DEBUG) $resArray = hash_call("doDirectPayment", $nvpStr);



    else $resArray = array(



        "TIMESTAMP" => "2012-12-31T01:20:22Z"



    , "CORRELATIONID" => "6c12fd92d8097"



    , "ACK" => "Success"



    , "VERSION" => "61.0"



    , "BUILD" => "4137385"



    , "AMT" => $payment_amount_discounted



    , "CURRENCYCODE" => "USD"



    , "AVSCODE" => "X"



    , "CVV2MATCH" => "M"



    , "TRANSACTIONID" => "85882291FE7160604 PAYMENT_DEBUG=TRUE"



    );



    //print_r_pre(explode("&",$nvpStr));



    //print_r_pre( $resArray);



    /* Display the API response back to the browser.



    If the response from PayPal was a success, display the response parameters'



    If the response was an error, display the errors received using APIError.php.



    */



    require_once ($path_app."/inc/phpmailer/class.phpmailer.php");



    //include_once('../V2/DB/class.DB.php');



    //$DestinationForm = isset($_REQUEST['_DestinationForm'])?$_REQUEST['_DestinationForm']:'DonationForm';



    $DestinationForm = 'DonationForm';



    //$DB = new DB();



    $link = mysql_connect('localhost', 'hillelsv_hillel2', 'shalom123');



    $db_selected = mysql_select_db('hillelsv_hsv', $link);



    $sql = "SELECT dsInfo FROM adminInfo where idInfo = '$DestinationForm'";



    $res = mysql_query($sql);



    $num_rows = mysql_num_rows($res);







    if($num_rows > 0)

    {



        $row = mysql_fetch_assoc($res);



        $dsTo = $row['dsInfo'];



    }

    else

    {

        $dsTo = 'sarita@hillelsv.org';

    }



    //echo '$dsTo: '.$dsTo;



    //echo '<br>$dsMail: '.$dsMail;



    //echo '<pre>'.print_r($GLOBALS,true).'</pre>';



    $mail = new PHPMailer();

    $mail->IsSMTP();

    $mail->Host = "in-v3.mailjet.com";  // specify main and backup server

    $mail->Port = 587;

    $mail->SMTPAuth = true;     // turn on SMTP authentication

    $mail->Username = "a809293ecd1c71ce4e365d5c6e013c09";  // SMTP username

    $mail->Password = "43cffcfceba5c38cb3b3f6eae1d7020c"; // SMTP password

    $mail->SMTPSecure = "tls";

    $mail->From = "web@secure.hillelsv.org";

    $mail->FromName = "Web Hillel of SV";



    //$mail->AddReplyTo($dsEmail, $dsNombre);



    $mail->WordWrap = 80;



    $mail->IsHTML(true);




    $footer = '<br><div class="row-fluid">





    <div class="span8" style="text-align: center; font-size: 12px;">



<div id="beneficiary">

<center><i><span style="font-size:10.0pt;color:#3F2103">Beneficiary of Maccabee Task Force, Hillel International, H & J Ullman Philanthropic Fund, Koret Foundation, Myra Reinhard Family Foundation, MZ Foundation, <br/>
Milton & Sophie Meyer Fund, Davis Family Foundation, and Adam & Gila Milstein Family Foundation. Jewish Community Federation of San Francisco, the Peninsula, <br/>
Marin, and Sonoma Counties and the Jewish Federation of Silicon Valley.</span></i></center>

</div>

<br>



<div id="footerlogos">

<a href="https://www.jvalley.org"><img src="https://hillelsv.org/wp-content/uploads/2018/01/jf_r.png" alt="" width="173" height="45" class="alignnone size-full wp-image-5629" /></a>

<a href="#"><img src="https://hillelsv.org/wp-content/uploads/2018/01/givingcirclelow_r.png" alt="" width="44" height="45" class="alignnone size-full wp-image-5631" /></a>

<a href="https://jewishfed.org/"><img src="https://hillelsv.org/wp-content/uploads/2018/01/sfjcf_r.png" alt="" width="87" height="45" class="alignnone size-full wp-image-5632" /></a>

</div>

    </div>





  </div>';



    $body = "



			<tr>



				<td style='padding: 3px 20px' colspan='2'><br><h4>Registration</h4></td>



			</tr>";

    foreach ($formVars["ticketsNames"] as $key => $value) {



        $body .= "";



    }



    $body .= "

";



    $body .= "



			<tr>



				<td style='padding: 3px 20px' colspan='2'><br><h4>SPONSORSHIP OPPORTUNITIES</h4></td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong></strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".$sponsorshipPriceArr[$formVars["sponsorshipPrice"]]["text"]."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong></strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".$sponsorshipTributePriceArr[$formVars["sponsorshipTributePrice"]]["text"]."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Write your own greeting here… (maximum 10 words):</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".$formVars["sponsorshipStandardGreetingInput"]."</td>



			</tr>



			";



    $body .= "



			<tr>



				<td style='padding: 3px 20px' colspan='2'><br><h4>PAYMENT INFORMATION</h4></td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Sponsorship:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".number_format($payment_sponsorship, 2, '.', ',')."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Tribute Ad:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".number_format($payment_tribute_ad, 2, '.', ',')."</td>



			</tr>

			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>General Donation:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".number_format($payment_general_donation, 2, '.', ',')."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Amount to be changed:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".number_format($payment_amount, 2, '.', ',')."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Please add {$payment_percentage_discount}% to cover processing fees:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>".(!empty($payment_processing_fees)?"true":"false")."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Credit Card Type:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_creditCardType</td>



			</tr>";



    $body .= "



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Cardholder's First Name:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_firstName</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Cardholder's Last Name:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_lastName</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Country:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_country</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>State:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_state</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>City:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_city</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Address 1:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_address1</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Address 2:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_address2</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Zip:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_zip</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Phone Number:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_phone Cell:".($payment_phone_cell?"True":"False")." Home:".($payment_phone_home?"True":"False")."</td>



			</tr>



			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>E-Mail Address:*</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_email</td>



			</tr>
			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Relationship to Hillel of Silicon Valley:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_relationshipToHillel</td>



			</tr>
			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>Class of:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_class</td>



			</tr>
			<tr>



				<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>School:</strong></td>



				<td style='padding: 3px 20px; border:1px solid #ddd;'>$payment_school</td>



			</tr>";



    $ack = strtoupper($resArray["ACK"]);



    // Success



    if($ack=="SUCCESS"||$ack=="SUCCESSWITHWARNING")



    {



        $body = "<table class='table' style='border-collapse:collapse;'>



					<tr>



						<td style='padding: 3px 20px; border-top:0 solid #000;' colspan='2'><br><h4>PAYPAL INFORMATION</h4></td>



					</tr>



					<tr>



						<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>TRANSACTION ID:</strong></td>



						<td style='padding: 3px 20px; border:1px solid #ddd;'>{$resArray['TRANSACTIONID']}</td>



					</tr>



					<tr>



						<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>AMOUNT:</strong></td>



						<td style='padding: 3px 20px; border:1px solid #ddd;'>".number_format($resArray['AMT'], 2, '.', ',')."</td>



					</tr>



					<tr>



						<td style='padding: 3px 20px; border:1px solid #ddd;'><strong>TIMESTAMP:</strong></td>



						<td style='padding: 3px 20px; border:1px solid #ddd;'>{$resArray['TIMESTAMP']}</td>



					</tr>



					$body



				</table>";



        $_SESSION['Payment']['log'] = $body.$footer;



        $body = "<br />



				<div style='padding: 3px 2px; color:#19419D; font-size:16px;'>



					<strong>Thank you for your contribution to Hillel of Silicon Valley!</strong>



				</div>



				$body



				<br /><br />



				".$footer;



        $mail->Body =  "<html><body>$body</body></html>";

        //GetBody($responseStatus . "\r\n" .$responseMsg);



        $aTo = explode(';',$dsTo);



        if(empty($debug) && (!SANDBOX)) {
            $mail->AddAddress('sarita@hillelsv.org');
            $mail->AddAddress('admin@hillelsv.org');
        }



        else $mail->AddAddress('hoanganhtuan1008@gmail.com'); //if debug send mail to developer



        $mail->Subject = "L'Dor V'Dor - hillelsv.org"; //GetSubject($responseStatus);//$_POST["dsSubject"] . " " . $responseStatus;// . ' ' . $dsTo;



        $mail->Send();



        $mail->ClearAddresses();



        $mail->Subject = "L'Dor V'Dor - hillelsv.org"; //GetSubject($responseStatus);//$_POST["dsSubject"] . " " . $responseStatus;// . ' ' . $dsTo;



        $mail->AddAddress($payment_email);



        $mail->Send();



        if(is_email($formVars["ticketsEmail"]) && strtolower(trim($formVars["ticketsEmail"])) !== strtolower(trim($payment_email))) {



            $mail->ClearAddresses();



            $mail->AddAddress($formVars["ticketsEmail"]);



            $mail->Send();



        }



        $_SESSION['Payment-Pillars']['payment_sponsorship'] = $payment_sponsorship;



        $_SESSION['Payment-Pillars']['payment_tribute_ad'] = $payment_tribute_ad;



        $_SESSION['Payment-Pillars']['payment_guest_tickets'] = $payment_guest_tickets;



        $_SESSION['Payment-Pillars']['payment_general_donation'] = $payment_general_donation;



        $_SESSION['Payment-Pillars']['payment_amount'] = $payment_amount;



        $_SESSION['Payment-Pillars']['ticketsNames'] = $formVars["ticketsNames"];



        header('location:'.$path_host.'/'.$this_script.'?step=5');



        exit('<a href="'.$path_host.'/'.$this_script.'?step=5">If it was not redirected click here</a>');







    }



    // Not Success



    else



    {











        $codERR = $resArray["L_ERRORCODE0"];











        if(strpos("10512", "$codERR")!==false) $error["payment_firstName"]="*Please enter a first name.";



        if(strpos("10513", "$codERR")!==false) $error["payment_lastName"]="*Please enter a last name.";



        if(strpos("10759", "$codERR")!==false) $error["payment_creditCardType"]="*Please enter a valid credit card number and type..";



        if(strpos("10527  10534  10535  10567", "$codERR")!==false) $error["payment_creditCardNumber"]="*Please enter a valid credit card number and type.";



        if(strpos("10508", "$codERR")!==false) $error["payment_expDates"]="*Please enter a valid credit card expiration date.";



        if(strpos("10748 15004 10762 10504", "$codERR")!==false) $error["payment_cvv2Number"]="*Please enter a Credit Card Verification Number.";











        if(strpos("10561 10701 10708 10714", "$codERR")!==false) $error["payment_billing_address"]="*Please enter complete billing address.";



        if(strpos("10756", "$codERR")!==false) $error["payment_billing_address"]="*The country and billing address associated with this credit card do not match.";







        if(strpos("10709 10702 10720", "$codERR")!==false ) $error["payment_address1"]="*Please enter an address1.";



        if(strpos("10710 10704 10718 10722", "$codERR")!==false) $error["payment_city"]="*Please enter a City.";



        if(strpos("10711 10705 10715 10723 10751", "$codERR")!==false) $error["payment_state"]="*Please enter a State.";



        if(strpos("10712 10706 10716 10724", "$codERR")!==false) $error["payment_zip"]="*Please enter your digit postal code.";



        if(strpos("10713 10707 10725 10746", "$codERR")!==false) $error["payment_country"]="*Please enter a Country.";



        if(strpos("10755", "$codERR")!==false) $error["payment_amount"]="*This transaction cannot be processed due to an unsupported currency.";











        $payment_general_error = array();



        if(strpos("10502", "$codERR")!==false) $payment_general_error[] = "*This transaction cannot be processed. Please use a valid credit card.";



        if(strpos("10752 15007 15006 15005", "$codERR")!==false ) $payment_general_error[] = "*This transaction cannot be processed. Was declined by the issuing bank.";



        if(strpos("10764 10763", "$codERR")!==false) $payment_general_error[] = "*This transaction cannot be processed at this time. Please try again later.";







        if(strpos("11821", "$codERR")!==false) $payment_general_error[] = "*This transaction cannot be processed because it has already been denied by a Fraud Management Filter.";



        if(strpos("11610", "$codERR")!==false) $payment_general_error[] = "*Payment Pending your review in Fraud Management Filters.";







        if(strpos("10754 15003 15002 15001 11612 11611 10761 10505", "$codERR")!==false||count($payment_general_error)==0) $payment_general_error[] = "*This transaction cannot be processed.";







        $body = "<table style='border-collapse:collapse;'>$body</table><br /><br />".$footer;



        $body = "<br />



				<div style='padding: 3px 2px; color:red; font-size:16px;'>



					<strong>Payment attempt failed: $".number_format($payment_amount, 2, '.', ',')."</strong>



				</div>



				<div style='padding: 3px 20px; color:red; font-size:14px;'>



					<div><strong>Paypal Error messages:</strong></div>



					<div>".implode('<br />', $error)."</div>



					<div>".implode('<br />', $payment_general_error)."</div>



				</div>



				<table style='border-collapse:collapse;'>



					$body



				</table><br /><br />".$footer;



        $mail->Body =  "<html><body>$body</body></html>"; //GetBody($responseStatus . "\r\n" . $responseMsg);



        $aTo = split(';',$dsTo);



        if(empty($debug) && (!SANDBOX)) {
            $mail->AddAddress('sarita@hillelsv.org');
            $mail->AddAddress('admin@hillelsv.org');
        }else $mail->AddAddress('hoanganhtuan1008@gmail.com'); //if debug send mail to developer



        $mail->Subject = "Payment attempt failed - L'Dor V'Dor - hillelsv.org"; //GetSubject($responseStatus);//$_POST["dsSubject"] . " " . $responseStatus;// . ' ' . $dsTo;



        $mail->Send();




        $payment_step = 3;



    }







    /* END DO DIRECT PAYMENT RECEIPT */



}



?>



<?php /**



HTML



 */ ?>



<!DOCTYPE HTML>



<html lang="en">



<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<script>
   function showPaymentSection() {
      // You may need to adjust this logic based on how your page toggles the visibility
      var paymentSection = document.getElementById('paymentSection');
      if (paymentSection.style.display === 'none') {
         paymentSection.style.display = 'block';
      }
      // Optionally, you can scroll to the section after making it visible
      paymentSection.scrollIntoView({ behavior: 'smooth' });
   }
</script>

<script>
   function showPaymentSection() {
      $('#paymentSection').toggle();  // Toggle visibility
      $('#paymentSection').get(0).scrollIntoView({ behavior: 'smooth' });  // Scroll into view
   }
</script>



    <title>Hillel of Silicon Valley :: Jewish Student Life on Campus -



        <?=$version?>



    </title>



    <meta name="description" content="">



    <meta name="author" content="Adam Rosenthal">



    <base href="<?=$path_host?>">



    <!--<link href='https://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>-->



    <link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">



    <link href="./css/basic.css" rel="stylesheet" media="screen">



    <link href="https://fonts.googleapis.com/css?family=Bowlby+One+SC|Delius" rel="stylesheet">



    <link href="https://fonts.googleapis.com/css?family=Delius" rel="stylesheet">



    <style type="text/css">



        @font-face {



            font-family: 'comic_sans_msregular';



            src: url('./css/comic/comic-webfont.eot');



            src: url('./css/comic/comic-webfont.eot?#iefix') format('embedded-opentype'), url('./css/comic/comic-webfont.woff') format('woff'), url('./css/comic/comic-webfont.ttf') format('truetype'), url('./css/comic/comic-webfont.svg#comic_sans_msregular') format('svg');



            font-weight: normal;



            font-style: normal;



        }



        @font-face {



            font-family: 'EB Garamond';



            font-style: normal;



            font-weight: 400;



            src: local('EB Garamond'), local('EBGaramond'), url(https://themes.googleusercontent.com/static/fonts/ebgaramond/v4/kYZt1bJ8UsGAPRGnkXPeFYbN6UDyHWBl620a-IRfuBk.woff) format('woff');



        }



        .container, .container label {



            font-family: Calibri, Verdana, Arial, sans-serif;



            font-size: 18px;



            color: #192D56;



        }

a {
    color: #192D56;
    text-decoration: none;
    font-weight: bold;
}

.btn-primary {
	background-color: #192D56 !important;
	margin: auto;
  display: block;
}

.btn-primary:hover {
	background-color:##1E439C !important;
	background-position: 0px -5px !important;
}

        .font-garamond {



            font-family: 'EB Garamond', serif;



        }



        .pillars-name {



            text-align: left;



            font-size: 34px;



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



            color: #1E439C;



            margin: 100px 0 15px 0;



        }



        .pillars-title {



            text-align: left;



            font-size: 27px;



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



            color: #19419D;



            margin: 20px 0 0 0;



        }



        .wp-image-5620  {

            margin-top:-110px;

        }



        .pillars-subtitle {



            text-align: left;



            font-size: 27px;



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



            color: #7F7F7F;



            margin: 0 0 20px 0;



            font-style: italic;



            font-weight: bold;



        }



        .pillars-subtitle2 {



            font-size: 21px;



            color: #7F7F7F;



            font-style: italic;



            font-weight: bold;



        }



        .pillars-date {



            text-align: left;



            font-size: 22px;



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



            color: #365F91;



            margin: 30px 0 20px 0;



            font-weight: bold;



        }



        .pillars-body {



            text-align: left;/*font-size: 18px;



			color: #19419D;*/
			
			display:inline-flex !important;



        }



        .pillars-gray {



            color: #7F7F7F;



        }



        .is-amount {



            text-align: right;



        }



        .hillel-no-wrap {



            white-space: nowrap;



        }



        .hillel-center {



            text-align: center;



        }



        .hillel-size-1 {



            font-size: 34px;



            white-space: nowrap;



        }



        .hillel-size-2 {



            font-size: 45px;



            white-space: nowrap;



        }



        .hillel-size-3 {



            font-size: 29px;



        }



        .hillel-size-4 {



            font-size: 20px;



        }



        .hillel-family-1 {



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



        }



        .hillel-family-10 {



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



        }



        .hillel-purple {



            color: #19419D;



            font-weight: bold;



        }



        .hillel-green {



            color: #76923C;



            font-weight: bold;



        }



        .hillel-gray {



            color: #666666;



            font-weight: bold;



        }



        .hillel-blue {



            color: #365F91;



            font-weight: bold;



        }



        .hillel-title {



            text-align: left;



            font-size: 22px;



            /*font-family: comic_sans_msregular, Verdana, Arial, sans-serif;*/



            font-family: Calibri, Verdana, Arial, sans-serif;



            color: #76923C;



            margin: 100px 0 50px 0;



        }

        .style1

        {

            font-family: 'Delius', cursive!important;

            font-size:  15px;

        }

        .style2

        {

            font-family: 'Bowlby One SC', cursive;

            font-size:  30px;

        }

        .eventtext {
            width:100% !important;
        }

        .eventsponsors {
            display:none;
        }
		
		.topback {
			margin-top:-70px;
		}
		
		.topback2 {
			margin-top:28px;
		}
		
		.topback3 {
			margin-top:-65px;
		}
		.reglink {
			font-size: 20.5px;
			color: #fff;
			font-weight: inherit;
		}
		.reglinkred {
			font-weight: initial;
			font-size: 20.5px;
		}

    </style>



</head>



<body>



<?php //if(!empty($debug)) echo "<pre>".print_r($_POST, true)."</pre>"?>



<?php if((isset($error)&&is_array($error)&&count($error)>0) || (isset($payment_general_error)&&is_array($payment_general_error)&&count($payment_general_error)>0)) {



    if(isset($payment_general_error)&&is_array($payment_general_error)) $error = array_merge($error, $payment_general_error);



    ?>



    <div class="row-fluid">



        <div class="span12"> <br />



            <div style='padding: 3px 20px; color:red; font-size:16px;'> <strong>Payment attempt failed</strong> </div>



            <div style='padding: 3px 20px; color:red; font-size:14px;'>



                <div><strong>Error messages:</strong></div>



                <div><?php echo implode('<br />', $error)?></div>



            </div>



        </div>



    </div>



    <br />



<?php } ?>



<?php



if($payment_step == 1) {



?>



<?php /**



L’Dor V’Dor



 */ ?>



<div class="container">



    <div class="row-fluid">



        <div class="span12" style="margin-top: 20px;"> <img src='./img/logo.jpg' alt="Logo" align="left"/> </div>

<a href="https://hillelsv.org" class="btn btn-large btn-primary pull-right topback3">Back to Hillel's Website</a>


    </div>






    <div class="row-fluid">



        <!--<div class="span12 hillel-green hillel-size-2 hillel-center hillel-family-10"><img src="img/LVDVHeader.jpg" alt=""/></div>-->
				

    <div class="row-fluid">



        <div class="span12 hillel-purple hillel-size-1 hillel-center hillel-family-10 style2">Please join us at</div>



    </div>
        <div class="span12 hillel-green hillel-size-2 hillel-center hillel-family-10"><img src="img/top-2024.jpg" /></div>
		



    </div>



    <div class="row-fluid"></div>



    <div class="row-fluid">



        <div class="span12 hillel-purple hillel-size-3 hillel-center hillel-family-10 style2"><br />March 3, 2024 / 3:00 - 5:00 PM</div>



    </div>



    <div class="row-fluid">



        <div class="span12 hillel-center" style="margin-top: 20px;"> <!--<img src='./img/pillars-logo2017.jpg' alt="l'dor v'dor" width="500" height="538"/>--> </div>



    </div>


    <div class="row-fluid">



        <div class="span8 hillel-blue hillel-size-4 hillel-family-2 eventtext"  style="margin-top: 20px;">


            <p class="style1">
<img src="/img/payment-about-2024.jpg">
			</p>

            <!--<p class="style1 text-center">        L’Dor V’Dor <br>

              Ensuring Future Generations<br>

              Sponsorship Opportunities<br>

            </p>-->

            <p><br>

            </p>



        </div>

    </div>



    <!--<div class="row-fluid" style="margin-top: 80px;">



      <div class="row-fluid" id="event">



        <div class="span12 hillel-blue hillel-size-4 hillel-family-1"  style="margin-top: 50px;">



          <p class=" hillel-center ">MARCH 17 AT 5:00 pm</p>



        </div>



      </div>



    </div>-->



    <!--<div class="row-fluid">



      <div class="span6 hillel-blue hillel-size-4 hillel-family-2"  style="margin-top: 50px;">

  <h2>Event Information</h2>

        <p><span class="style1">It is our privilege to recognize community and student leaders for their contributions to Hillel's mission of ensuring future Jewish generations. Leonard and Sylvia Metz, this year’s community honorees, have devoted years of service and support for Hillel programs. Visionaries and leaders, the Metzes understand the situation Hillel SV faces on its five campuses, countering anti-Israel activities and rhetoric. We are deeply grateful for their counsel, insight, optimism, energy, and generous support throughout the years. </span> <br>

        </p>



  </div>



      <img src='./img/pillars-logo2017.jpg' alt="l'dor v'dor" class="pull-right span4" align="right"/>



      <div class="span12 hillel-blue hillel-size-4 hillel-family-2" style="margin-left: 0px;">



        <p class="style1"><br>

        Our 2018 Student Honorees are:  Josephine Tutman and Jordan Taxon, both of San Jose State University.  </p>

        <p class="style1"> L’Dor V’Dor, the major annual fundraising event for Hillel, offers a variety of opportunities for you to support and contribute to Hillel's mission.</p>

        <p class="style1">Help us celebrate those who have made a difference to our community.  It won’t be the same without you in attendance!</p>



      </div>



    </div>



  </div>-->



    <div class="container"> <br />



        <br />



        <div class="row-fluid paymentbuttons">



            <div class="span6 pillars-body"> <a href="<?=$path_host?>/<?=$this_script?>?step=2&type=1" class="btn btn-large btn-primary">Registration</a> </div>



            <div class="span6 pillars-body"> <a href="https://hillelsv.org/ldor-vdor/sponsorship-opportunities/" class="btn btn-large btn-primary">Sponsorship/Tribute Ad Opportunities</a> </div>
			



        </div>


        <div class="row-fluid">



            <div class="span12 pillars-body hillel-center">



                <img src='img/bottom-2024.jpg'>



            </div>



        </div>



        <br />



        <br />



        <br />



        <div class="row-fluid">



            <div class="span12 pillars-body hillel-center">



                <div style="color: #7F7F7F; font-style: italic; font-weight: bold;">



                    <p>For more information, please contact <a href="mailto:sarita@hillelsv.org">sarita@hillelsv.org</a> <br>



                        L&rsquo;Dor  V&rsquo;Dor <br>



                        Ensuring  Future Generations<br>



                        Sponsorship Opportunities</p>



                </div>



            </div>



        </div>



    </div>



    <?php } if($payment_step == 2) {?>



    <form method="POST" action="<?php echo $path_host.'/'.$this_script?>" name="formStep2" id="formStep2" <?php if(!empty($debug)) echo 'target="_blank"'?>>



        <?php /** Registration */ ?>



        <a name="Tickets"></a>



        <div id="containerTickets" class="container" style="display:<?php echo $payment_type==1?"block":"none"?>;">



            <div class="row-fluid">



                <div class="span12">


				<a href="https://hillelsv.org" class="btn btn-large btn-primary pull-right topback2">Back to Hillel's Website</a>

                    <div style="text-align: center; margin-top: 50px;"><img src="img/top-2024.jpg" alt="L Dor V' Dor" title="L Dor V' Dor"></div>



                </div>



            </div>



            <div class="row-fluid">



                <div class="">



                    <div class="pillars-name">Registration</div>

                    <br />

                    <div class="hillel-family-1">

                    </div>



                </div>

            </div>

Thank you for your interest in attending L'Dor V'Dor 2024!
<br />
<br />
            <div class="row-fluid">

                <div class="span12 pillars-body">
				
				    <button type="button" id="buttonToRegistration" class="btn btn-large btn-primary button-step-2">Registration</button>

                    <button type="button" id="buttonToSponsorship" class="btn btn-large btn-primary button-step-2">Sponsorship & Tribute Ad Opportunities</button>

                    <button type="submit" class="btn btn-large btn-primary">Make a Donation</button>

                </div>

            </div>





            <div class="row-fluid">



                <div class="span12">



                    <div style="text-align: center; margin-top: 50px;"><img src="img/bottom-2024.jpg" alt="L Dor V' Dor" title="L Dor V' Dor"></div>



                </div>



            </div>





        </div>



</div>



<?php /** SPONSORSHIP OPPORTUNITIES */ ?>



    <a name="Sponsorship"></a>



    <div id="containerSponsorship" class="container" style="display:<?php echo $payment_type==2?"block":"none"?>;">



        <div class="row-fluid">



            <div class="span12">


				<a href="https://hillelsv.org" class="btn btn-large btn-primary pull-right topback2">Back to Hillel's Website</a>

                <div style="text-align: center; margin-top: 50px;"><img src="img/top-2024.jpg" alt="L Dor V' Dor" title="L Dor V' Dor"></div>



            </div>



        </div>



        <div class="row-fluid">



            <div class="span6">



                <p class="pillars-name">Sponsorship Opportunities</p>

                <h3> Please Respond by February 2nd, 2024 to be Included in the Tribute Book </h3>

                <p>



                    <label class="hillel-family-1">For sponsorship benefits at each level, please <a href="https://hillelsv.org/ldor-vdor/sponsorship-opportunities/">click here</a></label>



                    <select name="sponsorshipPrice" id="sponsorshipPrice" class="input-block-level">



                        <?php foreach($sponsorshipPriceArr as $key => $val) {?>



                            <option value="<?php echo $key?>" <?php echo $formVars["sponsorshipPrice"]==$key?"selected":""?>><?php echo $val["text"]?></option>



                        <?php }?>



                    </select>



                </p>



                <br>



                <p>



                    <label class="hillel-family-1">Yes, I/We would like to place a Tribute Ad</label>



                    <select name="sponsorshipTributePrice" class="input-block-level">



                        <?php foreach($sponsorshipTributePriceArr as $key => $val) {?>



                            <option value="<?php echo $key?>" <?php echo $formVars["sponsorshipTributePrice"]==$key?"selected":""?>><?php echo $val["text"]?></option>



                        <?php }?>



                    </select>



                </p>



                <br>



                <p>



                    <label for="sponsorshipStandardGreetingInput" class="hillel-family-1">Write your 10 word Mazel Tov greeting here...</label>



                    <input type="text" class="input-block-level" name="sponsorshipStandardGreetingInput" id="sponsorshipStandardGreetingInput" value="<?php echo $formVars["sponsorshipStandardGreetingInput"]?>">



                </p>



            </div>



            <div class="span6" style="margin-top: 50px"><!--<img src='./img/pillars-logo2017.jpg' alt="l'dor v'dor" />--></div>



            <div class="row-fluid">



                <div class="row-fluid">



                    <div class="span12">



                        <div class="pillars-body" style="color: #7F7F7F; font-style: italic; font-weight: bold;">



                            <p align="center">The deadline for Tribute Book Ads or Mazel Tov Greetings is <strong>February 2nd, 2024</strong>. For ad specifications, please email <a href="mailto:alexdruk@sonic.net">alexdruk@sonic.net</a>.</p>



                            <p>&nbsp;</p>



                        </div>



                    </div>



                </div>



                <div class="row-fluid">



                    <div class="span12 pillars-body">



                    <a href="https://us.givergy.com/ldorvdor2024/?controller=guest&action=checkRegistration&from=Register&method=phone" target="_blank" class="btn btn-large btn-primary reglinkred">Registration</a>

                        <button type="submit" class="btn btn-large btn-primary">Continue to Payment</button>



                    </div>



                </div>



            </div>



        </div>



        <div class="row-fluid">



            <div class="span12">



                <div style="text-align: center; margin-top: 50px;"><img src="img/bottom-2024.jpg" alt="L Dor V' Dor" title="L Dor V' Dor"></div>



            </div>



        </div>



    </div>



<input type="hidden" name="step" value="3">



<input type="hidden" name="type" id="type" value="<?php echo $payment_type?>">



<?php if(!empty($debug)) echo "<br /><br />"?>



<?php if(!empty($formVarsPayment)) { echo "<div class='container'>"; print_input($formVarsPayment, false, $debug); echo "</div>"; } ?>



    </form>









    <script src="./js/jquery.js"></script>



    <script src="./js/bootstrap.min.js"></script>



    <script type="text/javascript">



        $("document").ready(function() {



            $(".button-step-2").bind("click", toggle_type);



            $("select[name='ticketsCountry']").bind("change", function(){change_state(".input_tickets_state", "ticketsState", $(this).val(), "", "placeholder=\"State\"")});



            $('#formStep2').bind('submit', validateFormStep2);



            $('#sponsorshipPrice').bind('change', fnSponsorshipPrice);



            $('#ticketsNumber').bind('change', fnTicketsNames);



            $('#ticketsTotalUnderwriter').bind('change', underwriter);



            $('#ticketsAdditionalGuests').bind('change', additionalGuest);



            $('#ticketsTotalUnderwriter, #ticketsAdditionalGuests').bind('focus, click', highlightContent);



            fnTicketsNamesLoad(<?php echo (count($ticketsNumberArr)-1)+(count($ticketsNumberStudentArr)-1)?>);



        });



        var ticketsNumber = [];



        var ticketsNumberStudent = [];



        <?php



        foreach($ticketsNumberArr as $key => $value) {



            echo "ticketsNumber[$key] = {'text':'".$value["text"]."', 'textAmount':'".$value["textAmount"]."', 'amount':".$value["amount"]."}\n";



        }



        $sponsorshipPriceArrTemp = array();



        foreach($sponsorshipPriceArr as $key => $value) {



            $sponsorshipPriceArrTemp[] = $value["tickets"];



        }



        echo "var sponsorshipPrice = [".(implode(",", $sponsorshipPriceArrTemp))."];\n";



        foreach($ticketsNumberStudentArr as $key => $value) {



            echo "ticketsNumberStudent[$key] = {'text':'".$value["text"]."', 'textAmount':'".$value["textAmount"]."', 'amount':".$value["amount"]."}\n";



        }



        ?>



        fnSponsorshipPrice = function() {



            var s = sponsorshipPrice[$(this).val()];



            var n = $('#ticketsNumber').val();



            var o = "";



            var t;



            $.each(ticketsNumber, function(i,e){



                t = e.text+(e.textAmount==''?'':(i>s?' - '+ticketsNumber[(i-s)].textAmount:' - Free'));



                o += '<option value="'+i+'">'+t+'</option>';



            });



            $('#ticketsNumber').html(o).val(n);



            fnSumAmount();



            fnSumTickets();



        }



        fnSumAmount = function() {



            var s = sponsorshipPrice[$('#sponsorshipPrice').val()];



            var t = $('#ticketsNumber').val();



            var a = 0;







            if(t-s>0) a = ticketsNumber[t-s].amount;







            $('#ticketsGuestsRegistered').val(a);



        }



        fnSumTickets = function() {



            var t = $('#ticketsNumber').val();



            var st = $('#ticketsNumberStudent').val();



            var yat = $('#ticketsNumberYoungAlumni').val();



            var s = sponsorshipPrice[$('#sponsorshipPrice').val()];



            var a=0, b=0, c=st, d = yat;



            if(t>0) b = t;



            if(s>0 && t>0) {



                a = t>s?s:t;



                b = t>s?(t-s):0;



            }





            $('#ticketsTotalUnderwriter').val(a);



            $('#ticketsAdditionalGuests').val(b);



            $('#ticketsAdditionalStudentGuests').val(c);



            $('#ticketsAdditionalYoungAlumniGuests').val(c);



            totalGuestsRegistered();



        }



        toggle_type = function() {



            location.href = "<?=$_SERVER["REQUEST_URI"]?>#Tickets";



            $("#containerSponsorship, #containerTickets").hide();



            if(this.id == "buttonToTickets") {



                $("#containerTickets").show();



                $("#type").val("1");



                location.href = "<?=$_SERVER["REQUEST_URI"]?>#Tickets";



            }



            else if(this.id == "buttonToSponsorship") {



                $("#containerSponsorship").show();



                $("#type").val("2");



                location.href = "<?=$_SERVER["REQUEST_URI"]?>#Sponsorship";



            }
			
			else if(this.id == "buttonToRegistration") {



                $("#containerSponsorship").hide();



                $("#type").val("2");



                location.href = "https://us.givergy.com/ldorvdor2024/?controller=guest&action=checkRegistration&from=Register&method=phone";



            }



            else if(this.id == "linkToSponsorship") {



                $("#containerSponsorship").show();



                $("#type").val("2");



                location.href = "<?=$_SERVER["REQUEST_URI"]?>#Sponsorship";



            }



            return false;



        }



        var ticketsNamesContainer = [];



        var ticketsNumberArr = [];



        var ticketsNumberStudentArr = [];



        fnTicketsNamesLoad = function(c) {



            for(var i=0; i<c; i++) {



                ticketsNamesContainer[i] = {'id':i, 'name':'', 'fish':'', 'vegetarian':''};



            }



            <?php



            $comma = '';



            $ticketsNumberArrJs = '';



            foreach ($ticketsNumberArr as $value) {



                $ticketsNumberArrJs .= $comma.$value['amount'];



                $comma = ',';



            }



            echo "ticketsNumberArr = [$ticketsNumberArrJs];\n";



            ?>



        }



        fnChangeStudentsTickets = function() {

            //var v = $('#ticketsNumberStudent').val();

            //$('#ticketsNumber').val(v);

            fnTicketsNames();

        }



        fnSetStudentsTickets = function(v) {

            $('#ticketsNumberStudent').val(v);

        }



        fnTicketsNames = function() { console.log(this);



            var ei;



            $.each($('.ticketsNames'), function(i,e) {



                ei = e.id.replace('ticketsNames-', '');



                //ticketsNamesContainer[ei] = {'id':ei, 'name':$('#'+e.id+'-name').val(), 'fish':($('#'+e.id+'-fish').attr('checked')?true:false), 'vegetarian':($('#'+e.id+'-vegetarian').attr('checked')?true:false)};



                ticketsNamesContainer[ei] = {'id':ei, 'name':$('#'+e.id+'-name').val(), 'fish':false, 'vegetarian':false};



            });



            $('.ticketsNames').remove();



            var tn = $('#ticketsNumber').val();



            var b = parseInt(tn);



            //fnSetStudentsTickets(b);



            var m = '';



            $.each(ticketsNamesContainer, function(i,e) {



                if(i<b) {



                    m += '<div id="ticketsNames-'+e.id+'" class="row-fluid ticketsNames" style="padding-top: 5px; padding-bottom: 5px">';

                    m += '	  <div class="span4">';

                    m += '		<label class="control-label" for="ticketsNames-'+e.id+'-name" >Name:</label>';

                    m += '	  </div>';

                    m += '	<div class="span8 form-inline">';

                    m += '		<input type="text" name="ticketsNames['+e.id+'][name]" id="ticketsNames-'+e.id+'-name" placeholder="Name" value="">';

                    m += '	  </div>'

                    m += '</div>';



                }



            });



            $(m).insertAfter('.ticketsNumber');



            fnSumAmount();



            fnSumTickets();



        }



        underwriter = function () {



            generateTicket();



            generateForm ();



            totalGuestsRegistered();



        }



        additionalGuest = function () {



            generateForm ();



            fnSumAmount();



            totalGuestsRegistered();



        }



        totalGuestsRegistered = function () {



            var



                u 	= parseInt($('#ticketsTotalUnderwriter').val()),



                ag 	= parseInt($('#ticketsAdditionalGuests').val());



            t	= 0;







            t = u + ag;







            if(t > 10) {



                alert('Max of 10 person per booking');



                $('.ticketsNames').remove();



            }



            else {



                $('#totalGuestsRegistered').val(t);



            }



        }



        generateTicket = function () {



            var s = sponsorshipPrice, ei;



            var tn = parseInt($('#ticketsTotalUnderwriter').val());







            if(tn > <?php echo count($sponsorshipPriceArrTemp) ?>) {



                tn = 5;



                $('#ticketsTotalUnderwriter').val(tn);



                $('#sponsorshipPrice').val(tn);



                alert('Total Underwriter Seats Must Be Less Than 5');



            }







            $('#sponsorshipPrice').val(sponsorshipPrice[tn]);







            $.each($('.ticketsNames'), function(i,e) {



                ei = e.id.replace('ticketsNames-', '');



                ticketsNamesContainer[ei] = {'id':ei, 'name':$('#'+e.id+'-name').val(), 'fish':false, 'vegetarian':false};



            });







            var o = "", optionText;



            var t;



            var j = 0;



            $.each(ticketsNumber, function(i,e){



                if(e.textAmount != '') {



                    if(j < tn) {



                        optionText = 'Free';



                    }



                    else {



                        optionText = ticketsNumber[i-tn].textAmount;



                    }







                    t = e.text + ' - '+ optionText;



                    o += '<option value="'+i+'">'+t+'</option>';



                    j++;



                    console.log(i+'>'+s[j]);



                }



            });



            $('#ticketsNumber').html(o).val(tn);



        }



        generateForm = function () {



            var nt = 0,



                tn = parseInt($('#ticketsTotalUnderwriter').val()),



                ts = parseInt($('#ticketsAdditionalGuests').val());







            $('.ticketsNames').remove();







            if(tn > 0 ) {



                nt += tn;



            }



            if(ts > 0 ) {



                nt += ts;



            }







            $('#ticketsNumber').val(nt);







            var b = parseInt(tn)+parseInt(ts);



            var m = '';



            $.each(ticketsNamesContainer, function(i,e) {



                if(i<b) {



                    m += '<div id="ticketsNames-'+e.id+'" class="row-fluid ticketsNames" style="padding-top: 5px; padding-bottom: 5px">';



                    m += '	  <div class="span4">'



                    m += '		<label class="control-label" for="ticketsNames-'+e.id+'-name" >Name:</label>'



                    m += '	  </div>'



                    m += '	<div class="span8 form-inline">'



                    m += '		<input type="text" name="ticketsNames['+e.id+'][name]" id="ticketsNames-'+e.id+'-name" placeholder="Name" value="">'



                    m += '	  </div>'



                    m += '</div>';



                }



            });



            $(m).insertAfter('.ticketsNumber');



        }



        highlightContent = function() {



            $(this).select()



        }



        validateFormStep2 = function(){ return true;



            var e=[], m='', f=false;



            //sumDonations();







            if($.trim($('input[name="ticketsFirstName"]').val())=='') {



                e[e.length] = 'Type your First name.';



                if(f==false) f = $('input[name="ticketsFirstName"]');



                $('.field-ticketsFirstName').addClass('error');



            } else {



                $('.field-ticketsFirstName').removeClass('error');



            }



            if($.trim($('input[name="ticketsLastName"]').val())=='') {



                e[e.length] = 'Type your Last name.';



                if(f==false) f = $('input[name="ticketsLastName"]');



                $('.field-ticketsLastName').addClass('error');



            } else {



                $('.field-ticketsLastName').removeClass('error');



            }



            if($.trim($('#ticketsCountry').val())=='') {



                e[e.length] = 'Type your Country.';



                if(f==false) f = $('#ticketsCountry');



                $('.field-ticketsCountry').addClass('error');



            } else {



                $('.field-ticketsCountry').removeClass('error');



            }



            if($.trim(formStep2.ticketsState.value)=='') {



                e[e.length] = 'Type your State.';



                if(f==false) f = formStep2.ticketsState;



                $('.field-ticketsState').addClass('error');



            } else {



                $('.field-ticketsState').removeClass('error');



            }



            if($.trim($('input[name="ticketsCity"]').val())=='') {



                e[e.length] = 'Type your City.';



                if(f==false) f = $('input[name="ticketsCity"]');



                $('.field-ticketsCity').addClass('error');



            } else {



                $('.field-ticketsCity').removeClass('error');



            }



            if($.trim($('input[name="ticketsAddress1"]').val())=='') {



                e[e.length] = 'Type your Address.';



                if(f==false) f = $('input[name="ticketsAddress1"]');



                $('.field-ticketsAddress1').addClass('error');



            } else {



                $('.field-ticketsAddress1').removeClass('error');



            }



            if($.trim($('input[name="ticketsZip"]').val())=='') {



                e[e.length] = 'Type your ZIP code.';



                if(f==false) f = $('input[name="ticketsZip"]');



                $('.field-ticketsZip').addClass('error');



            } else {



                $('.field-ticketsZip').removeClass('error');



            }



            if(!isEmail($.trim($('input[name="ticketsEmail"]').val()))) {



                e[e.length] = 'Type your Mail address.';



                if(f==false) f = $('input[name="ticketsEmail"]');



                $('.field-ticketsEmail').addClass('error');



            } else {



                $('.field-ticketsEmail').removeClass('error');



            }



            if(e.length>0) {



                $.each(e, function(a,b){



                    m += b+'\n';



                });



                alert('Please, check the info below:\n\n'+m);



                $(f).focus();



                return false



            }



            return true;



        }



    </script>



<?php



}



if($payment_step == 3) {



    ?>



    <?php /**



    PAYMENT INFORMATION



     */ ?>


<div id="paymentSection" class="row-fluid">
    <div id="container-payment" class="container">



        <form method="POST" action="<?php echo $path_host.'/'.$this_script?>" name="DoDirectPaymentForm" id="DoDirectPaymentForm" <?php if(!empty($debug)) echo 'target="_blank"'?>>



            <div class="row-fluid" style="margin-top:-50px">



                <div class="pillars-name"><img src="/img/logo.jpg" alt="L Dor V' Dor" title="L Dor V' Dor"><!--<span style="font-style:italic;">Ensuring Future Generations</span>-->
				<a href="https://hillelsv.org" class="btn btn-large btn-primary pull-right topback2">Back to Hillel's Website</a>



                </div>



                <div class="span4"><!--<img src='./img/ldorvdor.jpg' width="230" align="right" alt="l'dor v'dor" style="position: absolute;"/>--></div>



            </div>



            <div class="row-fluid">



                <div class="span12 pillars-subtitle">Payment Information</div>



            </div>



            <div class="row-fluid">



                <div class="span12" style="font-family: sans-serif; font-weight: bold; font-style: italic; color: #000;">Please note that sponsorships and tribute ads are tax deductible.</div>



            </div>



            <div class="row-fluid">



                <div class="span4"> <a href="javascript:void(0);" style="text-decoration:underline;" onClick="window.open('https://secure.hillelsv.org/SecureDonations.php','SecureDonations','width=800,height=700,dependent=yes,resizable=yes,scrollbars=yes,menubar=no,toolbar=no,status=no,directories=no,location=yes'); return false;"><strong>Is it Secure?</strong></a> </div>



                <div class="span3"></div>



                <div class="span5" style="text-align:center;"><img src="./img/paypal_credcards.gif" /></div>



            </div>



            <br />



            <div class="row-fluid field-payment_sponsorship control-group">



                <div class="span4">



                    <label class="control-label" for="payment_sponsorship"><strong>Sponsorship:</strong></label>



                </div>



                <div class="span3 input-prepend input-append controls"> <span class="add-on">$</span>



                    <input type="text" name="payment_sponsorship" id="payment_sponsorship" value="<?php echo $payment_sponsorship; //number_format($payment_sponsorship, 0, '.', ',')?>" class="input-medium is-amount" disabled>



                    <span class="add-on">.00</span> </div>



                <div class="span5">



                    <button type="submit" class="btn input-large button-sponsorship">Edit Sponsorship</button>



                </div>



            </div>



            <div class="row-fluid field-payment_tribute_ad control-group">



                <div class="span4">



                    <label class="control-label" for="payment_tribute_ad"><strong>Tribute Ad:</strong></label>



                </div>



                <div class="span8 input-prepend input-append controls"> <span class="add-on">$</span>



                    <input type="text" name="payment_tribute_ad" id="payment_tribute_ad" value="<?php echo $payment_tribute_ad; //number_format($payment_tribute_ad, 0, '.', ',')?>" class="input-medium is-amount" disabled>



                    <span class="add-on">.00</span> </div>



            </div>



            <div class="row-fluid field-payment_general_donation control-group">



                <div class="span4">



                    <label class="control-label" for="payment_general_donation"><strong>General Donation:</strong></label>



                </div>



                <div class="span8 input-prepend input-append controls"> <span class="add-on">$</span>



                    <input type="text" name="payment_general_donation" id="payment_general_donation" value="<?php echo $payment_general_donation?>" class="input-medium is-amount" >



                    <span class="add-on">.00</span> </div>



            </div>



            <br />



            <div class="row-fluid ic-donate-group control-group <?php echo isset($error["payment_amount"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_amount"><strong>TOTAL TO BE CHARGED:</strong></label>



                </div>



                <div class="span3 input-prepend input-append controls"> <span class="add-on">$</span>



                    <?php



                    function html_part_number($v) {



                        return explode('.', (string)number_format($v,2,'.',''));



                    }



                    $payment_amount_exp = html_part_number($payment_amount);



                    ?>



                    <input type="text" name="payment_amount" id="payment_amount" value="<?php echo isset($payment_amount_exp[0])?(int)$payment_amount_exp[0]:(int)$payment_amount?>" class="input-medium is-amount"  placeholder="AMOUNT TO BE CHARGED" disabled>



                    <input type="hidden" name="payment_amount_without_tax" value="<?php echo $payment_amount_without_tax?>">



                    <span class="add-on payment_amount_rest">.<?php echo isset($payment_amount_exp[1])?$payment_amount_exp[1]:'00'?></span> </div>



                <div class="span5 controls"> <span class="help-inline">



        <input type="checkbox" name="payment_processing_fees" id="payment_processing_fees" value="1" <?php echo (!empty($payment_processing_fees)?"checked=\"checked\"":"")?>>



        Please add <?php echo $payment_percentage_discount?>% to cover processing fees</span> </div>



            </div>



            <?php /*<div class="row-fluid">



					<div class="span4">



					</div>



					<div class="span8">



						<label class="checkbox">



							<input type="checkbox" name="payment_processing_fees" id="payment_processing_fees" value="1" <?php echo (!empty($payment_processing_fees)?"checked=\"checked\"":"")?>> Please add <?php echo $payment_percentage_discount?>% to cover processing fees



						</label>



					</div>



				</div>*/?>



            <br / >



            <div class="row-fluid field-payment_creditCardType control-group <?php echo isset($error["payment_creditCardType"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_creditCardType"><strong>Credit Card Type:*</strong></label>



                </div>



                <div class="span8 controls">



                    <select name="payment_creditCardType" id="payment_creditCardType">



                        <option value=''>Select an option</option>



                        <?php



                        foreach($payment_creditCardType_arr as $value => $text) {



                            echo "<option value=\"$value\" ".($payment_creditCardType==$value?"selected":"").">$text</option>\n";



                        }



                        ?>



                    </select>



                </div>



            </div>



            <div class="row-fluid field-payment_creditCardNumber control-group <?php echo isset($error["payment_creditCardNumber"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_creditCardNumber"><strong>Credit Card Number:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_creditCardNumber" id="payment_creditCardNumber" value="<?php echo $payment_creditCardNumber?>" maxlength="19" placeholder="Credit Card Number">



                </div>



            </div>



            <div class="row-fluid field-payment_expDates control-group <?php echo isset($error["payment_expDates"])?"error":""?>">



                <div class="span4">



                    <label class="control-label"><strong>Expiration Date:*</strong></label>



                </div>



                <div class="span8 controls">



                    <select name="payment_expDateMonth" id="payment_expDateMonth" class="input-mini">



                        <option value=></option>



                        <?php



                        $payment_expDateMonth_arr = array(



                            "01"=>"1",



                            "02"=>"2",



                            "03"=>"3",



                            "04"=>"4",



                            "05"=>"5",



                            "06"=>"6",



                            "07"=>"7",



                            "08"=>"8",



                            "09"=>"9",



                            "10"=>"10",



                            "11"=>"11",



                            "12"=>"12"



                        );



                        foreach($payment_expDateMonth_arr as $text => $value) {



                            echo "<option value=\"$value\" ".($payment_expDateMonth==$value?"selected":"").">$text</option>\n";



                        }



                        ?>



                    </select>



                    <select name="payment_expDateYear" id="payment_expDateYear" class="input-small">



                        <option value=></option>



                        <?php



                        for($year=date("Y"); $year<date("Y")+20; $year++) {



                            echo "<option value=\"$year\" ".($payment_expDateYear==$year?"selected":"").">$year</option>\n";



                        }



                        ?>



                    </select>



                </div>



            </div>



            <div class="row-fluid field-payment_cvv2Number control-group <?php echo isset($error["payment_cvv2Number"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_cvv2Number"><strong>Card Security Code:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_cvv2Number" id="payment_cvv2Number" value="<?php echo $payment_cvv2Number?>" class="input-mini" maxlength="4" placeholder="Card Security Code">



                    <img src="./img/paypal_mini_cvv2.gif" alt="" style="vertical-align: top;"> </div>



            </div>



            <br / >



            <div class="row-fluid field-payment_firstName control-group <?php echo isset($error["payment_firstName"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_firstName"><strong>Cardholder’s First Name:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_firstName" id="payment_firstName" value="<?php echo $payment_firstName?>" maxlength="32" placeholder="Cardholder’s First Name">



                </div>



            </div>



            <div class="row-fluid field-payment_lastName control-group <?php echo isset($error["payment_lastName"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_lastName"><strong>Cardholder’s Last Name:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_lastName" id="payment_lastName" value="<?php echo $payment_lastName?>" maxlength="32" placeholder="Cardholder’s Last Name">



                </div>



            </div>



            <div class="row-fluid field-payment_address1 control-group <?php echo isset($error["payment_address1"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_address1"><strong>Address 1:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_address1" id="payment_address1" value="<?php echo $payment_address1?>" maxlength="100" placeholder="Address 1">



                </div>



            </div>



            <div class="row-fluid field-payment_address2 control-group <?php echo isset($error["payment_address2"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_address2"><strong>Address 2:</strong></label>



                    </label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_address2" id="payment_address2" value="<?php echo $payment_address2?>" maxlength="100" placeholder="Address 2">



                </div>



            </div>



            <div class="row-fluid field-payment_city control-group <?php echo isset($error["payment_city"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_city"><strong>City:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_city" id="payment_city" value="<?php echo $payment_city?>"maxlength="40" placeholder="City">



                </div>



            </div>



            <div class="row-fluid field-payment_state control-group <?php echo isset($error["payment_state"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_state"><strong>State:*</strong></label>



                </div>



                <div class="span8 input_payment_state controls"> <?php echo fn_states_html_select("payment_state", $payment_country, $payment_state, "id=\"payment_state\" placeholder=\"State\"")?> </div>



            </div>



            <div class="row-fluid field-payment_zip control-group <?php echo isset($error["payment_zip"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_zip"><strong>Zip:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_zip" id="payment_zip" value="<?php echo $payment_zip?>" maxlength="10" placeholder="Zip">



                </div>



            </div>



            <div class="row-fluid field-payment_country control-group <?php echo isset($error["payment_country"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_country"><strong>Country:*</strong></label>



                </div>



                <div class="span8 controls"> <?php echo fn_countries_html_select("payment_country", $payment_country, "id=\"payment_country\""); ?> </div>



            </div>



            <div class="row-fluid field-payment_phone control-group <?php echo isset($error["payment_phone"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_phone"><strong>Phone:*</strong></label>



                </div>



                <div class="span3 controls">



                    <input type="text" name="payment_phone" id="payment_phone" value="<?php echo $payment_phone?>" placeholder="Phone">



                </div>



                <div class="span2 controls"> <span class="help-inline">(xxx) xxx-xxx</span> </div>



                <div class="span1 controls">



                    <label class="checkbox">



                        <input type="checkbox" name="payment_phone_cell" id="payment_phone_cell" <?php echo $payment_phone_cell?'checked':''?> value="1">



                        Cell </label>



                </div>



                <div class="span2 controls">



                    <label class="checkbox">



                        <input type="checkbox" name="payment_phone_home" id="payment_phone_home" <?php echo $payment_phone_home?'checked':''?> value="1">



                        Home </label>



                </div>



            </div>



            <div class="row-fluid field-payment_email control-group <?php echo isset($error["payment_email"])?"error":""?>">



                <div class="span4">



                    <label class="control-label" for="payment_email"><strong>E-Mail Address:*</strong></label>



                </div>



                <div class="span8 controls">



                    <input type="text" name="payment_email" id="payment_email" placeholder="E-Mail Address">



                </div>



            </div>
            <div class="row-fluid field-payment_relationshipToHillel control-group <?php echo isset($error["payment_relationshipToHillel"])?"error":""?>">
                <div class="span4">
                    <label class="control-label" for="payment_relationshipToHillel"><strong>Relationship to Hillel of Silicon Valley:</strong></label>
                </div>
                <div class="span8 controls">
                    <select name="payment_relationshipToHillel" id="payment_relationshipToHillel">
                        <option value=''>Select an option</option>
                        <option value='Alumni'>Alumni</option>
                        <option value='Community Member'>Community Member</option>
                        <option value='Friend'>Friend</option>
                        <option value='Parent'>Parent</option>
                        <option value='Student'>Student</option>
                    </select>
                </div>
            </div>
            <div class="row-fluid field-payment_class control-group <?php echo isset($error["payment_class"])?"error":""?>">
                <div class="span4">
                    <label class="control-label" for="payment_class"><strong>Class of:</strong></label>
                </div>
                <div class="span8 controls">
                    <input type="text" name="payment_class" id="payment_class" value="<?php echo $payment_class?>" placeholder="Enter your class">
                </div>
            </div>
            <div class="row-fluid field-payment_school control-group <?php echo isset($error["payment_school"])?"error":""?>">
                <div class="span4">
                    <label class="control-label" for="payment_school"><strong>School:</strong></label>
                </div>
                <div class="span8 controls">
                    <input type="text" name="payment_school" id="payment_school" value="<?php echo $payment_school?>" placeholder="Enter your school">
                </div>
            </div>

            <br />



            <div class="row-fluid">



                <div class="span12 pillars-body">



                    <button type="submit" class="btn btn-large btn-primary">Sponsorship Opportunities</button>



                    <a href="https://us.givergy.com/ldorvdor2024/?controller=guest&action=checkRegistration&from=Register&method=phone" target="_blank" class="btn btn-large btn-primary reglink">Registration</a>



                    &nbsp;&nbsp;



                    <input type="hidden" name="step" id="payment_step" value="4" />



                    <input type="hidden" name="type" id="payment_type" value="<?php echo $payment_type?>">



                    <input type="hidden" name="paymentStepBack" value="1">



                    <button type="submit" class="btn btn-large btn-primary">Confirm Payment</button>



                </div>



            </div>



            <?php if(!empty($debug)) echo "<br /><br />"?>



            <?php print_input ($formVars, false, $debug)?>



            <div class="row-fluid">



                <div class="span12"></div>



            </div>



        </form>
</div>


    </div>



    <script src="./js/jquery.js"></script>



    <script src="./js/bootstrap.min.js"></script>



    <script type="text/javascript">



        $("document").ready(function() {



            $("select[name='payment_country']").bind("change", function(){change_state(".input_payment_state","payment_state",$(this).val(), "","placeholder=\"State\"")});



            $('input[name="payment_processing_fees"]').bind('click', fn_payment_processing_fees);



            $('#DoDirectPaymentForm').bind('submit', validatePaymentForm);



            $('#payment_general_donation').bind("blur focus keyup", sumAmounts);



            $('.button-sponsorship').bind("click", fnBackSponsorship);



            $('.button-tickets').bind("click", fnBackTickets);



        });



        fnBackSponsorship = function(){fnBack('2','2')}



        fnBackTickets = function(){fnBack('2','1')}



        fnBack = function(s, t){



            $('#payment_step').val(s);



            $('#payment_type').val(t);



            validatePaymentFormVar = false;



        }



        payment_processing_fees = <?php echo is_numeric($payment_amount_without_tax)?floatval($payment_amount_without_tax):0?>;



        payment_processing_fees_tax = 0;



        fn_payment_processing_fees = function(){



            var amount = $('input[name="payment_amount"]').val();



            if($('input[name="payment_processing_fees"]').attr('checked')) {



                if($.isNumeric(amount)) {



                    payment_processing_fees = Number(amount);



                    //payment_processing_fees_tax = (payment_processing_fees+payment_processing_fees*.05).toFixed(2);



                    payment_processing_fees_tax = (payment_processing_fees+payment_processing_fees*<?php echo $payment_percentage_discount/100?>).toFixed(2);



                    $('input[name="payment_amount"]').val(payment_processing_fees_tax.toString().replace(/\..*$/,''));



                    $('.payment_amount_rest').html('.'+(payment_processing_fees_tax.toString().replace(/^.*\./,'')));



                }



            } else {



                $('input[name="payment_amount"]').val(payment_processing_fees);



                $('.payment_amount_rest').html('.00');



                payment_processing_fees = 0;



                payment_processing_fees_tax = 0;



            }



        }



        sumAmounts = function(){



            var total = 0;



            if($.isNumeric($("#payment_sponsorship").val())) total = total + Number($("#payment_sponsorship").val());



            if($.isNumeric($("#payment_tribute_ad").val())) total = total + Number($("#payment_tribute_ad").val());



            if($.isNumeric($("#payment_guest_tickets").val())) total = total + Number($("#payment_guest_tickets").val());



            if($.isNumeric($("#payment_general_donation").val())) total = total + Number($("#payment_general_donation").val());



            $("input[name='payment_amount']").val(total);



            $("input[name='payment_amount_without_tax']").val(total);



            if(!$('input[name="payment_processing_fees"]').attr('checked')) payment_processing_fees = Number(total);



            fn_payment_processing_fees();



        }



        <?php if(!empty($debug) || SANDBOX) { /* Init Debug */?>







        function generateCC(){



            var cc_number = new Array(16);



            var cc_len = 16;



            var start = 0;



            var rand_number = Math.random();



            switch(document.DoDirectPaymentForm.payment_creditCardType.value)



            {



                case "Visa":



                    cc_number[start++] = 4;



                    break;



                case "Discover":



                    cc_number[start++] = 6;



                    cc_number[start++] = 0;



                    cc_number[start++] = 1;



                    cc_number[start++] = 1;



                    break;



                case "MasterCard":



                    cc_number[start++] = 5;



                    cc_number[start++] = Math.floor(Math.random() * 5) + 1;



                    break;



                case "Amex":



                    cc_number[start++] = 3;



                    cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;



                    cc_len = 15;



                    break;



            }



            for (var i = start; i < (cc_len - 1); i++) {



                cc_number[i] = Math.floor(Math.random() * 10);



            }



            var sum = 0;



            for (var j = 0; j < (cc_len - 1); j++) {



                var digit = cc_number[j];



                if ((j & 1) == (cc_len & 1)) digit *= 2;



                if (digit > 9) digit -= 9;



                sum += digit;



            }



            var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);



            cc_number[cc_len - 1] = check_digit[sum % 10];



            document.DoDirectPaymentForm.payment_creditCardNumber.value = "";



            for (var k = 0; k < cc_len; k++) {



                document.DoDirectPaymentForm.payment_creditCardNumber.value += cc_number[k];



            }



        }







        $(document).ready(function(){



            generateCC();



            $('select[name="payment_creditCardType"]').bind('change', generateCC);



        });







        <?php } /* End Debug */?>



        var validatePaymentFormVar = true;



        validatePaymentForm = function(){



            if(!validatePaymentFormVar) return true;



            var e=[], m='', f=false;



            //sumDonations();



            if(!$.isNumeric($.trim($('input[name="payment_amount"]').val()))) {



                e[e.length] = 'Type Total amount.';



                if(f==false) f = $('input[name="payment_amount"]');



                $('.field-payment_amount').addClass('error');



            } else {



                $('.field-payment_amount').removeClass('error');



            }



            if($.isNumeric($.trim($('input[name="payment_amount"]').val()))&&!$.isNumeric($.trim($('input[name="payment_amount_without_tax"]').val()))) {



                if($('input[name="payment_processing_fees"]').attr('checked')) $('input[name="payment_amount_without_tax"]').val(payment_processing_fees);



                else  $('input[name="payment_amount_without_tax"]').val($('input[name="payment_amount"]').val());



            }



            if($.trim($('input[name="payment_firstName"]').val())=='') {



                e[e.length] = 'Type your Payment First name.';



                if(f==false) f = $('input[name="payment_firstName"]');



                $('.field-payment_firstName').addClass('error');



            } else {



                $('.field-payment_firstName').removeClass('error');



            }



            if($.trim($('input[name="payment_lastName"]').val())=='') {



                e[e.length] = 'Type your Payment Last name.';



                if(f==false) f = $('input[name="payment_lastName"]');



                $('.field-payment_lastName').addClass('error');



            } else {



                $('.field-payment_lastName').removeClass('error');



            }



            if($.trim($('#payment_country').val())=='') {



                e[e.length] = 'Type your Payment Country.';



                if(f==false) f = $('#payment_country');



                $('.field-payment_country').addClass('error');



            } else {



                $('.field-payment_country').removeClass('error');



            }



            if($.trim(DoDirectPaymentForm.payment_state.value)=='') {



                e[e.length] = 'Type your Payment State.';



                if(f==false) f = DoDirectPaymentForm.payment_state;



                $('.field-payment_state').addClass('error');



            } else {



                $('.field-payment_state').removeClass('error');



            }



            if($.trim($('input[name="payment_city"]').val())=='') {



                e[e.length] = 'Type your Payment City.';



                if(f==false) f = $('input[name="payment_city"]');



                $('.field-payment_city').addClass('error');



            } else {



                $('.field-payment_city').removeClass('error');



            }



            if($.trim($('input[name="payment_address1"]').val())=='') {



                e[e.length] = 'Type your Payment Address.';



                if(f==false) f = $('input[name="payment_address1"]');



                $('.field-payment_address1').addClass('error');



            } else {



                $('.field-payment_address1').removeClass('error');



            }



            if($.trim($('input[name="payment_zip"]').val())=='') {



                e[e.length] = 'Type your Payment ZIP code.';



                if(f==false) f = $('input[name="payment_zip"]');



                $('.field-payment_zip').addClass('error');



            } else {



                $('.field-payment_zip').removeClass('error');



            }



            if($.trim($('input[name="payment_phone"]').val())=='') {



                e[e.length] = 'Type your Payment Phone number.';



                if(f==false) f = $('input[name="payment_phone"]');



                $('.field-payment_phone').addClass('error');



            } else if(!$('input[name="payment_phone_cell"]').attr('checked') && !$('input[name="payment_phone_home"]').attr('checked')) {



                e[e.length] = 'Type your Payment Phone type (Cell,Home).';



                if(f==false) f = $('input[name="payment_phone_cell"]');



                $('.field-payment_phone').addClass('error');



            } else {



                $('.field-payment_phone').removeClass('error');



            }



            if(!isEmail($.trim($('input[name="payment_email"]').val()))) {



                e[e.length] = 'Type your Payment Mail address.';



                if(f==false) f = $('input[name="payment_email"]');



                $('.field-payment_email').addClass('error');



            } else {



                $('.field-payment_email').removeClass('error');



            }



            if($.trim(DoDirectPaymentForm.payment_creditCardType.value)=='') {



                e[e.length] = 'Type your Credit Card Type.';



                if(f==false) f = DoDirectPaymentForm.payment_creditCardType;



                $('.field-payment_creditCardType').addClass('error');



            } else {



                $('.field-payment_creditCardType').removeClass('error');



            }



            if($.trim($('input[name="payment_creditCardNumber"]').val())=='') {



                e[e.length] = 'Type your Credit Card Number.';



                if(f==false) f = $('input[name="payment_creditCardNumber"]');



                $('.field-payment_creditCardNumber').addClass('error');



            } else {



                $('.field-payment_creditCardNumber').removeClass('error');



            }



            if($.trim(DoDirectPaymentForm.payment_expDateMonth.value)==''||$.trim(DoDirectPaymentForm.payment_expDateYear.value)=='') {



                e[e.length] = 'Type your Credit Card Expiration Date.';



                if(f==false&&$.trim(DoDirectPaymentForm.payment_expDateMonth.value)=='') f = DoDirectPaymentForm.payment_expDateMonth;



                else if(f==false&&$.trim(DoDirectPaymentForm.payment_expDateYear.value)=='') f = DoDirectPaymentForm.payment_expDateYear;



                $('.field-payment_expDates').addClass('error');



            } else {



                $('.field-payment_expDates').removeClass('error');



            }



            if($.trim($('input[name="payment_cvv2Number"]').val())=='') {



                e[e.length] = 'Type your Credit Card Security Code.';



                if(f==false) f = $('input[name="payment_cvv2Number"]');



                $('.field-payment_cvv2Number').addClass('error');



            } else {



                $('.field-payment_cvv2Number').removeClass('error');



            }



            if(e.length>0) {



                $.each(e, function(a,b){



                    m += b+'\n';



                });



                alert('Please, check the info below:\n\n'+m);



                $(f).focus();



                return false



            }



            return true;



        }



    </script>



<?php }



if($payment_step == 5) {?>



    <?php /**



    CONFIRMATION



     */ ?>



    <div id="container-payment" class="container"> <br />



        <br />



        <div class="row-fluid">



            <div class="span12 hillel-center"> <span style="color:#19419D; font-size:29px; font-family:Arial, sans-serif;">L’Dor V’Dor</span> <span style="color:#444; font-size:24px; font-style:italic; font-family:Arial, sans-serif;">Ensuring Future Generations</span> </div>



        </div>



        <div class="row-fluid">



            <!--<div class="span12 hillel-center" ><img src='img/LVDVHeader.jpg' width="1586" alt="l'dor v'dor"/></div>-->
				<a href="https://hillelsv.org" class="btn btn-large btn-primary pull-right topback2">Back to Hillel's Website</a>

            <div class="span12 hillel-center" ><img src='img/top-2024.jpg' width="1586" alt="l'dor v'dor"/></div>



        </div>



        <br />



        <div class="row-fluid">



            <div class="span12 hillel-center"><span style="color: #19419D;font-size: 20px;font-family: Arial, sans-serif;border: 1px solid #000;padding: 7px 15px 5px 15px;">THANK YOU FOR SUPPORTING HILLEL OF SILICON VALLEY !</span></div>



        </div>



        <br />



        <div class="row-fluid">



            <div class="span12 hillel-center" style="font-size:27px; font-style: italic; color:#888; font-weight: bold;">Please keep this confirmation for your records</div>



        </div>



        <br />



        <div class="row-fluid" style="font-family:serif; font-size:15px; color:#000;">



            <div class="span12">



                <table class="table table-striped table-bordered" align="center" style="width: 50%;">



                    <tr>



                        <td>Sponsorship:</td>



                        <td style="text-align: right;"><?php echo number_format((isset($_SESSION['Payment-Pillars']['payment_sponsorship'])?$_SESSION['Payment-Pillars']['payment_sponsorship']:0), 2, '.', ',')?></td>



                    </tr>



                    <tr>



                        <td>Tribute Ad:</td>



                        <td style="text-align: right;"><?php echo number_format((isset($_SESSION['Payment-Pillars']['payment_tribute_ad'])?$_SESSION['Payment-Pillars']['payment_tribute_ad']:0), 2, '.', ',')?></td>



                    </tr>


                    <tr>



                        <td>General Donation:</td>



                        <td style="text-align: right;"><?php echo number_format((isset($_SESSION['Payment-Pillars']['payment_general_donation'])?$_SESSION['Payment-Pillars']['payment_general_donation']:0), 2, '.', ',')?></td>



                    </tr>



                    <tr>



                        <td>Total charged to your credit card:</td>



                        <td style="text-align: right;"><?php echo number_format((isset($_SESSION['Payment-Pillars']['payment_amount'])?$_SESSION['Payment-Pillars']['payment_amount']:0), 2, '.', ',')?></td>



                    </tr>



                </table>



            </div>



        </div>



        <div class="row-fluid">



            <div class="span12">



                <table class="table table-striped" align="center" style="width: 50%; margin-bottom: 0;">



                    <thead>



                    <tr>



                        <th style="margin-bottom:-10px; color: #888;">Guests:</th>



                    </tr>



                    </thead>



                </table>



                <table class="table table-striped table-bordered" align="center" style="width: 50%;">



                    <thead>



                    <tr>



                        <th>Name</th>



                    </tr>



                    </thead>



                    <tbody>



                    <?php foreach ((isset($_SESSION['Payment-Pillars']['ticketsNames'])&&is_array($_SESSION['Payment-Pillars']['ticketsNames'])?$_SESSION['Payment-Pillars']['ticketsNames']:array()) as $key => $value) {?>



                        <tr>



                            <td><?php echo isset($value['name'])?$value['name']:''?></td>



                        </tr>



                    <?php }?>



                    </tbody>



                </table>



            </div>



        </div>



        <br />



        <br />



        <div class="row-fluid">



            <div class="span2"></div>



            <div class="span8" style="text-align: center; font-size: 14px;">



                <p>Hillel is a non-profit organization.  Our tax ID is 77-0575153.    </p>

            </div>



            <div class="span2"></div>



        </div>

    </div>



    <script src="./js/jquery.js"></script>



    <script src="./js/bootstrap.min.js"></script>



<?php  }?>



<script type="text/javascript">



    $("document").ready(function() {



        $('.is-amount').bind('keyup blur', is_amount);



    });



    change_state = function(e, name, country, selected, pars, only_options) {



        country = country?country:"<?php echo $payment_country?>";



        selected = selected?selected:"<?php echo $payment_state?>";



        $.post("<?php echo $path_host.'/'.$this_script?>"



            , {action:"state", name:name, country:country, selected:selected, pars:pars, only_options:only_options}



            , function(r) {



                $(e).html(r);



            });



    }



    is_amount = function() {



        this.value = this.value.replace(/[^\d]+/,'');



    }



    isNumeric = function(str) {



        var p = /^[0-9]+$/;



        return (p.test(str));



    }



    isEmail = function(str) {



        //if(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(str)) return true;



        if(/^(.+?@.+?\..+?)$/i.test(str)) return true;



        else return false;



    }



</script>

<br>







<div class="row-fluid">



    <div class="span" style="text-align: center; font-size: 12px;">



        <div id="beneficiary">

            <center><i><span style="font-size:10.0pt;color:#3F2103">Beneficiary of Maccabee Task Force, Hillel International, H & J Ullman Philanthropic Fund, Koret Foundation, Myra Reinhard Family Foundation, MZ Foundation, <br/>
Milton & Sophie Meyer Fund, Davis Family Foundation, and Adam & Gila Milstein Family Foundation. Jewish Community Federation of San Francisco, the Peninsula, <br/>
Marin, and Sonoma Counties and the Jewish Federation of Silicon Valley.</span></i></center>

        </div>

        <br>



        <div id="footerlogos">

            <a href="https://www.jvalley.org"><img src="https://hillelsv.org/wp-content/uploads/2018/01/jf_r.png" alt="" width="173" height="45" class="alignnone size-full wp-image-5629" /></a>

            <a href="#"><img src="https://hillelsv.org/wp-content/uploads/2018/01/givingcirclelow_r.png" alt="" width="44" height="45" class="alignnone size-full wp-image-5631" /></a>

            <a href="https://jewishfed.org/"><img src="https://hillelsv.org/wp-content/uploads/2018/01/sfjcf_r.png" alt="" width="87" height="45" class="alignnone size-full wp-image-5632" /></a>

        </div>



    </div>





</div>





<?php if($debug) echo '<pre>'.print_r($_POST, true).'</pre>';?>





<br><br><br>







</body>



</html>



