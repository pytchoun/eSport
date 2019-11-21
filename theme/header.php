<?php
session_start();

// The name of the site
$site_name = "Python";

// Current year
$year = date('Y');

// Current date - 13 years
$maxBirthDate = date('Y-m-d', strtotime('-13 years'));

// SEO informations
$page_title = "{$site_name} - Your challenge arena";
$page_description = "{$site_name} is a community website dedicated to the game Paladins of Hi-Rez Studios. We are focused on the competition between the players and to do this we provide different functionalities.";
$page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, arena";

// Required functions //

// Redirection management
require "$_SERVER[DOCUMENT_ROOT]/core/functions/php/redirection.php";
// User management
require "$_SERVER[DOCUMENT_ROOT]/core/functions/php/user.php";

// Required functions //

// Verification of user input: removing leading and trailing spaces, removing backslashes, converting special characters to HTML entities
function verifyInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
}

// Set the token for the form
function setFormToken() {
  // Check if session have a token
  if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
    $token = $_SESSION['token'];

    return $token;
  } else {
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;

    return $token;
  }
}

// Set the token for the form
$token = setFormToken();

// Verify that the submission of the form is valid
function formIsValid() {
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['token']) && isset($_POST['token']) && !empty($_SESSION['token']) && !empty($_POST['token']) && hash_equals($_SESSION['token'], $_POST['token']) === true) {
    return true;
  } else {
    return false;
  }
}

// Get the number of pages
function getNumberOfPages($message_number, $message_limit) {
  $number_of_pages = ceil($message_number / $message_limit);

  return $number_of_pages;
}

// Check if game value is correct
function gameArray($game) {
  // Get games list
  $db = connectDb();
  $query = $db->prepare("SELECT * FROM game");
  $query->execute();
  $games_list = $query->fetchAll();

  $game_array = [];
  foreach ($games_list as $game_id) {
    array_push($game_array, $game_id['id']);
  }

  if (in_array($game, $game_array)) {
    return true;
  } else {
    return false;
  }
}

// Check if region value is correct
function regionArray($region) {
  $region_array = ["EU", "NA", "SEA", "Other"];

  if (in_array($region, $region_array)) {
    return true;
  } else {
    return false;
  }
}

// Check if gender value is correct
function genderArray($gender) {
  $gender_array = ["Male", "Female", "Not specified"];

  if (in_array($gender, $gender_array)) {
    return true;
  } else {
    return false;
  }
}

// Check if language value is correct
function languageArray($language) {
  $language_array = ["Afrikanns", "Albanian", "Arabic", "Armenian", "Basque", "Bengali", "Bulgarian", "Catalan", "Cambodian", "Chinese (Mandarin)", "Croation", "Czech", "Danish", "Dutch", "English", "Estonian", "Fiji", "Finnish",
  "French", "Georgian", "German", "Greek", "Gujarati", "Hebrew", "Hindi", "Hungarian", "Icelandic", "Indonesian", "Irish", "Italian", "Japanese", "Javanese", "Korean", "Latin", "Latvian", "Lithuanian", "Macedonian",
  "Malay", "Malayalam", "Maltese", "Maori", "Marathi", "Mongolian", "Nepali", "Norwegian", "Persian", "Polish", "Portuguese", "Punjabi", "Quechua", "Romanian", "Russian", "Samoan", "Serbian", "Slovak", "Slovenian", "Spanish",
  "Swahili", "Swedish", "Tamil", "Tatar", "Telugu", "Thai", "Tibetan", "Tonga", "Turkish", "Ukranian", "Urdu", "Uzbek", "Vietnamese", "Welsh", "Xhosa"];

  if (in_array($language, $language_array)) {
    return true;
  } else {
    return false;
  }
}

// Check if country value is correct
function countryArray($country) {
  $country_array = ["Afghanistan", "Aland Islands", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
  "Barbados", "Barbuda", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Trty.", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Caicos Islands", "Cambodia",
  "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus",
  "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories",
  "Futuna Islands", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard", "Herzegovina",
  "Holy See", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Jan Mayen Islands", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya",
  "Kiribati", "Korea", "Korea (Democratic)", "Kuwait", "Kyrgyzstan", "Lao", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives",
  "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "McDonald Islands", "Mexico", "Micronesia", "Miquelon", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia",
  "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "Nevis", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestinian Territory, Occupied", "Panama", "Papua New Guinea",
  "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Principe", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Barthelemy", "Saint Helena", "Saint Kitts", "Saint Lucia", "Saint Martin (French part)", "Saint Pierre", "Saint Vincent",
  "Samoa", "San Marino", "Sao Tome", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "South Sandwich Islands", "Spain", "Sri Lanka", "Sudan", "Suriname",
  "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Grenadines", "Timor-Leste", "Tobago", "Togo", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Turks Islands",
  "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "US Minor Outlying Islands", "Uzbekistan", "Vanuatu", "Vatican City State", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (US)", "Wallis", "Western Sahara", "Yemen", "Zambia", "Zimbabwe"];

  if (in_array($country, $country_array)) {
    return true;
  } else {
    return false;
  }
}
