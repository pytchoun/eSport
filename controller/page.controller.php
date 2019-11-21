<?php
require_once('model/UserManager.php');
require_once('model/UserRoleManager.php');
require_once('model/UserTokenManager.php');
require_once('model/UserActivationCodeManager.php');
require_once('model/UserResetPasswordManager.php');
require_once('model/EmailManager.php');

// $postManager = new PostManager(); // Création d'un objet
// $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet

// $userManager = new UserManager();
// user = userManager->getUser(15)
// user->setEmail('new@mail.com')
// userManager->saveUser(user)

function homeView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/home.view.php";
}

function error404View()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Error 404 - {$site_name}";
  $page_description = "Error 404 on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, Error 404";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/error404.view.php";
}

function aboutUsView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "About us - {$site_name}";
  $page_description = "About us {$site_name}, who we are and what we do.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, about us";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/aboutUs.view.php";
}

function contactView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Contact us - {$site_name}";
  $page_description = "Contact us on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, contact us";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/contact.view.php";
}

function cookiePolicyView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Cookie Policy - {$site_name}";
  $page_description = "View our cookie policy on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, cookie policy";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/cookiePolicy.view.php";
}

function privacyPolicyView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Privacy Policy - {$site_name}";
  $page_description = "View our privacy policy on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, privacy policy";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/privacyPolicy.view.php";
}

function termsOfServiceView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Terms of Service - {$site_name}";
  $page_description = "View our terms of service on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, terms of service";

  require "$_SERVER[DOCUMENT_ROOT]/view/page/termsOfService.view.php";
}
