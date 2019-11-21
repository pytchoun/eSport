<?php
// Get games list
$db = connectDb();
$query = $db->prepare("SELECT * FROM game ORDER BY name, platform ASC");
$query->execute();
$games_list = $query->fetchAll();
?>

<option disabled selected value="">-- Select --</option>
<?php foreach ($games_list as $game) { ?>
  <option value="<?php echo $game['id'] ?>"><?php echo $game['name']; ?> (<?php echo $game['platform']; ?>)</option>
<?php } ?>
