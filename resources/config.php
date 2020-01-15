<?php

KformConfig::setConfig(array(
    "isWordpress" => false,
    "apiLoginId" => "os_api",
    "apiPassword" => 'p@$$w0rd123123',
   "authString"=>"24bbf00708286e725b8d98599c452236",
	"autoUpdate_allowedIps"=>array("80.248.30.132"),
	"campaignId"=>20,
	"resourceDir"=>"resources/"));




/* 
!---------------------------------IMPORTANT-----------------------------------!

Documentation:
	
	-Full documentation on landing pages can be found at 

Auto-Update Feature:

	-The auto-update feature will automatically update settings on your landing page
	when you make changes to your campaign within the konnektive CRM. Use this feature
	to keep your landing page up-to-date concerning new coupons / shipping options
	and product changes.

	-To use the campaign auto-update feature, the apache or ngix user 
	(depending on your httpd software) must have write access to this file
	
	-If you are not using the auto-update feature, you will need to manually 
	replace this file after making changes to the campaign	
	
!---------------------------------IMPORTANT-----------------------------------!
*/

class KFormConfig
{
	
	public $isWordpress = false;
	public $apiLoginId = '';
	public $apiPassword = '';
	public $resourceDir;
	public $baseDir;
	
	
	public $mobileRedirectUrl;
	public $desktopRedirectUrl;
	
	
	public $continents;
	public $countries;
	public $coupons;
	public $currencySymbol;
	public $insureShipPrice;
	public $landerType;
	public $offers;
	public $upsells;
	public $products;
	public $shipProfiles;
	public $states;
	public $taxes;
	public $termsOfService;
	public $webPages;
	
	static $instance = NULL;
	static $options;
	static $campaignData;
	// class constructor to set the variable values	
	
	static function setConfig($options)
	{
		self::$options = $options;	
	}
	
	public function __construct()
	{
		if(!empty(self::$instance))
			throw new Exception("cannot recreated KFormConfig");
		
		foreach((array) self::$options as $k=>$v)
			$this->$k = $v;
			
		if($this->isWordpress)
		{
			$options = get_option('konnek_options');
			foreach((array)$options as $k=>$v)
				$this->$k = $v;
		
			$data = json_decode(get_option('konnek_campaign_data'));
			foreach($data as $k=>$v)
				$this->$k = $v;
		}
		elseif(!empty(self::$campaignData))
		{
			if(json_decode(self::$campaignData) === NULL)
			{
				echo 'JSON in config.php is broken!';
				die;
			}
			else
				$data = (array)json_decode(self::$campaignData);


			foreach($data as $k=>$v)
				$this->$k = $v;
		}

		self::$instance = $this;
		
	
	}
}

/* 
!---------------------------------IMPORTANT-----------------------------------!

	ABSOLUTELY DO NOT EDIT BELOW THIS LINE
	
!---------------------------------IMPORTANT-----------------------------------!
*/
$requestUri = $_SERVER['REQUEST_URI'];
$baseFile = basename(__FILE__);

if($_SERVER['REQUEST_METHOD']=='POST' && strstr($requestUri,$baseFile))
{
	
	$authString = filter_input(INPUT_POST,'authString',FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	if(empty($authString))
		die(); //exit silently, don't want people to know that this file processes api requests if they are just sending random posts at it
	
	
	$remoteIp = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
		  $remoteIp =  $_SERVER["HTTP_CF_CONNECTING_IP"];
	
	$allowedIps = KFormConfig::$options['autoUpdate_allowedIps'];
	if(!in_array($remoteIp,$allowedIps))
		die("ERROR: Invalid IP Address. Please confirm that the Konnektive IP Address is in the allowedIps array.");
	if($authString != KFormConfig::$options['authString'])
		die("ERROR: Could not authenticate authString. Please re-download code package and replace config file on your server.");

	$data = filter_input(INPUT_POST,'data');
	$data = trim($data);
	$data = utf8_encode($data);
	$decoded = json_decode($data);
	if($decoded != NULL)
	{
		$file = fopen(__FILE__,'r');
		if(empty($file))
			die("ERROR: File not writable");

		$new_file = '';

		while($line = fgets($file))
		{
			$new_file .= $line;

			if(strpos($line,"/*[DYNAMIC-DATA-TOKEN]") === 0)
				break;
		}
		fclose($file);

		$new_file .= "KFormConfig::\$campaignData = '$data';".PHP_EOL;
		$ret = file_put_contents(__FILE__,$new_file);


		if(is_int($ret))
			die("SUCCESS");
		else
			die("ERROR: File not writable");
	}
	else
	{
		die("ERROR: what data");
	}
}

/*[DYNAMIC-DATA-TOKEN] do not remove */

KFormConfig::$campaignData = '{
    "countries": {
        "FR": "France"
    },
    "states": {
        "FR": {
            "01": "Ain",
            "02": "Aisne",
            "03": "Allier",
            "04": "Alpes-de-Haute-Provence",
            "06": "Alpes-Maritimes",
            "07": "Ard\u00e8che",
            "08": "Ardennes",
            "09": "Ari\u00e8ge",
            "10": "Aube",
            "11": "Aude",
            "12": "Aveyron",
            "67": "Bas-Rhin",
            "13": "Bouches-du-Rh\u00f4ne",
            "14": "Calvados",
            "15": "Cantal",
            "16": "Charente",
            "17": "Charente-Maritime",
            "18": "Cher",
            "CP": "Clipperton",
            "19": "Corr\u00e8ze",
            "2A": "Corse-du-Sud",
            "21": "C\u00f4te-d\u0027Or",
            "22": "C\u00f4tes-d\u0027Armor",
            "23": "Creuse",
            "79": "Deux-S\u00e8vres",
            "24": "Dordogne",
            "25": "Doubs",
            "26": "Dr\u00f4me",
            "91": "Essonne",
            "27": "Eure",
            "28": "Eure-et-Loir",
            "29": "Finist\u00e8re",
            "30": "Gard",
            "32": "Gers",
            "33": "Gironde",
            "68": "Haut-Rhin",
            "2B": "Haute-Corse",
            "31": "Haute-Garonne",
            "43": "Haute-Loire",
            "52": "Haute-Marne",
            "70": "Haute-Sa\u00f4ne",
            "74": "Haute-Savoie",
            "87": "Haute-Vienne",
            "05": "Hautes-Alpes",
            "65": "Hautes-Pyr\u00e9n\u00e9es",
            "92": "Hauts-de-Seine",
            "34": "H\u00e9rault",
            "35": "Ille-et-Vilaine",
            "36": "Indre",
            "37": "Indre-et-Loire",
            "38": "Is\u00e8re",
            "39": "Jura",
            "40": "Landes",
            "41": "Loir-et-Cher",
            "42": "Loire",
            "44": "Loire-Atlantique",
            "45": "Loiret",
            "46": "Lot",
            "47": "Lot-et-Garonne",
            "48": "Loz\u00e8re",
            "49": "Maine-et-Loire",
            "50": "Manche",
            "51": "Marne",
            "53": "Mayenne",
            "YT": "Mayotte",
            "54": "Meurthe-et-Moselle",
            "55": "Meuse",
            "56": "Morbihan",
            "57": "Moselle",
            "58": "Ni\u00e8vre",
            "59": "Nord",
            "NC": "Nouvelle-Cal\u00e9donie",
            "60": "Oise",
            "61": "Orne",
            "75": "Paris",
            "62": "Pas-de-Calais",
            "PF": "Polyn\u00e9sie fran\u00e7aise",
            "63": "Puy-de-D\u00f4me",
            "64": "Pyr\u00e9n\u00e9es-Atlantiques",
            "66": "Pyr\u00e9n\u00e9es-Orientales",
            "69": "Rh\u00f4ne",
            "BL": "Saint-Barth\u00e9lemy",
            "MF": "Saint-Martin",
            "PM": "Saint-Pierre-et-Miquelon",
            "71": "Sa\u00f4ne-et-Loire",
            "72": "Sarthe",
            "73": "Savoie",
            "77": "Seine-et-Marne",
            "76": "Seine-Maritime",
            "93": "Seine-Saint-Denis",
            "80": "Somme",
            "81": "Tarn",
            "82": "Tarn-et-Garonne",
            "TF": "Terres Australes Fran\u00e7aises",
            "90": "Territoire de Belfort",
            "95": "Val-d\u0027Oise",
            "94": "Val-de-Marne",
            "83": "Var",
            "84": "Vaucluse",
            "85": "Vend\u00e9e",
            "86": "Vienne",
            "88": "Vosges",
            "WF": "Wallis et Futuna",
            "89": "Yonne",
            "78": "Yvelines"
        }
    },
    "currencySymbol": "\u20ac",
    "shipOptions": [],
    "coupons": [],
    "products": [],
    "webPages": {
        "catalogPage": {
            "disableBack": 0,
            "url": "https:\/\/www.serumpourcilsfrance.com\/"
        },
        "checkoutPage": {
            "disableBack": 0,
            "url": "https:\/\/www.serumpourcilsfrance.com\/checkout.php",
            "autoImportLead": 1,
            "productId": null,
            "requireSig": 0,
            "sigType": 0,
            "cardinalAuth": 0,
            "paayApiKey": null
        },
        "thankyouPage": {
            "disableBack": 0,
            "url": "https:\/\/www.serumpourcilsfrance.com\/thankyou.php",
            "createAccountDialog": 0,
            "reorderUrl": null,
            "allowReorder": 0
        },
        "upsellPage1": {
            "disableBack": 1,
            "url": "https:\/\/www.serumpourcilsfrance.com\/upsell1.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 87,
            "replaceProductId": null
        },
        "upsellPage2": {
            "disableBack": 1,
            "url": "https:\/\/www.serumpourcilsfrance.com\/upsell2.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 86,
            "replaceProductId": null
        },
        "upsellPage3": {
            "disableBack": 1,
            "url": "https:\/\/www.serumpourcilsfrance.com\/upsell3.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 88,
            "replaceProductId": null
        },
        "productDetails": {
            "url": "product-details.php"
        }
    },
    "landerType": "CART",
    "googleTrackingId": "UA-156275714-1",
    "enableFraudPlugin": 0,
    "autoTax": 0,
    "taxServiceId": null,
    "companyName": "optin_solutions_llc",
    "offers": {
        "84": {
            "productId": 84,
            "name": "Feg Serum - Eyelash Enhancer",
            "description": "*No description available",
            "imagePath": "https:\/\/www.serumpourcilsfrance.com/\/resources\/images\/smain-small.jpg",
            "imageId": 1,
            "price": "11.97",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "85": {
            "productId": 85,
            "name": "Feg Serum - Eyelash Enhancer - Free",
            "description": "*No description available",
            "imagePath": "https:\/\/www.serumpourcilsfrance.com/\/resources\/images\/smain-small.jpg",
            "imageId": 1,
            "price": "0.00",
            "shipPrice": "0.00",
            "category": "FEG"
        }
    },
    "upsells": {
        "86": {
            "productId": 86,
            "name": "Feg Serum - Eyelash Enhancer - Free Gift",
            "description": "*No description available",
            "imagePath": "https:\/\/www.serumpourcilsfrance.com/\/resources\/images\/upsell1.jpg",
            "imageId": 1,
            "price": "4.95",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "87": {
            "productId": 87,
            "name": "FEG - EyeBrow (2pcs - 2 months of treatment)",
            "description": "*No description available",
            "imagePath": "https:\/\/www.serumpourcilsfrance.com/\/resources\/images\/upsell2.jpg",
            "imageId": 2,
            "price": "9.95",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "88": {
            "productId": 88,
            "name": "Silicone Make-Up Sponge",
            "description": "*No description available",
            "imagePath": "https:\/\/www.serumpourcilsfrance.com/\/resources\/images\/upsell3.jpg",
            "imageId": 3,
            "price": "4.95",
            "shipPrice": "0.00",
            "category": "FEG"
        }
    },
    "shipProfiles": [],
    "continents": {
        "FR": "EU"
    },
    "paypal": {
        "paypalBillerId": 6
    }
}';