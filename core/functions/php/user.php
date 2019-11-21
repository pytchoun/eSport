<?php

// Success notification
function successNotification() {
  $_SESSION['notification']['success'] = 1;
}

// Error notification
function errorNotification() {
  $_SESSION['notification']['error'] = 1;
}
