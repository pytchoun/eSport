<?php
require('controller/page.controller.php');
require('controller/user.controller.php');

$url[0] = '';
if(isset($_GET['url'])) {
  $url = explode('/', $_GET['url']);
}

switch ($url[0]) {
  case "":
    homeView();
    break;
  case "login":
    loginView();
    break;
  case "register":
    registerView();
    break;
  case "logout":
    logoutView();
    break;
  case "account-activation":
    accountActivationView($url);
    break;
  case "account-recovery":
    accountRecoveryView($url);
    break;
  case "reset-password":
    accountResetPasswordView();
    break;
  case "about-us":
    aboutUsView();
    break;
  case "contact":
    contactView();
    break;
  case "cookie-policy":
    cookiePolicyView();
    break;
  case "privacy-policy":
    privacyPolicyView();
    break;
  case "terms-of-service":
    termsOfServiceView();
    break;
  default:
    error404View();
    break;
}

// if($url == '') {
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/home/view/home.php";
// } elseif($url[0] == 'login') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/login/model/login.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/login/view/login.php";
// } elseif($url[0] == 'register') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/register/model/register.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/register/view/register.php";
// } elseif($url[0] == 'logout') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/logout/model/logout.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
// } elseif($url[0] == 'account-activation' AND !empty($url[1])) {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/activation/model/activation.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/activation/view/activation.php";
// } elseif($url[0] == 'account-recovery' AND !empty($url[1])) {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/recovery/model/recovery.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/recovery/view/recovery.php";
// } elseif($url[0] == 'reset-password') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/reset password/model/reset-password.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/authentication/reset password/view/reset-password.php";
// } elseif($url[0] == 'about-us') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/about us/model/about-us.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/about us/view/about-us.php";
// } elseif($url[0] == 'contact') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/contact/model/contact.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/contact/view/contact.php";
// } elseif($url[0] == 'cookie-policy') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/cookie policy/model/cookie-policy.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/cookie policy/view/cookie-policy.php";
// } elseif($url[0] == 'privacy-policy') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/privacy policy/model/privacy-policy.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/privacy policy/view/privacy-policy.php";
// } elseif($url[0] == 'terms-of-service') {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/terms of service/model/terms-of-service.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/page/terms of service/view/terms-of-service.php";
// } else {
//   require "$_SERVER[DOCUMENT_ROOT]/modules/404/model/404.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
//   include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
//   require "$_SERVER[DOCUMENT_ROOT]/modules/404/view/404.php";
// }
