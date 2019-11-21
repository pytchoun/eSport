<?php

require "$_SERVER[DOCUMENT_ROOT]/view/header.php";

$string = $_REQUEST["string"];

if($string !== "")
{
  // Get input members list
  $db = connectDb();
  $query = $db->prepare("SELECT username FROM user WHERE username LIKE '$string%' LIMIT 10");
  $query->execute();
  $username_list = $query->fetchAll();
  ?>

  <datalist id="member-list">
    <?php foreach($username_list as $username)
    { ?>
      <option value="<?php echo $username['username']; ?>">
    <?php } ?>
  </datalist>

<?php } ?>
