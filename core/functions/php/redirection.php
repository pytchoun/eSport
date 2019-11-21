<?php
// Redirect user to the home page
function homeRedirection() {
  header('Location: /');
  exit;
}

// Redirect user to the login page
function loginRedirection() {
  header('Location: /login');
  exit;
}

// Redirect user to the register page
function registerRedirection() {
  header('Location: /register');
  exit;
}

// Redirect user to the reset password page
function resetPasswordRedirection() {
  header('Location: /reset-password');
  exit;
}

// Redirect user to his profile page
function profileRedirection() {
  header('Location: /profile/'.$_SESSION['account']['user_username']);
  exit;
}

// Redirect user to his profile settings page
function profileSettingsRedirection() {
  header('Location: /profile-settings');
  exit;
}

// Redirect user to his notifications center
function notificationsCenterRedirection() {
  header('Location: /notifications-center');
  exit;
}

// Redirect user to error 404
function error404Redirection() {
  header('Location: /error404');
  exit;
}
