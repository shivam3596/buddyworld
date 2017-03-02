<?php //require_once 'include/session.php'; ?>
<?php require_once 'include/connection.php'; ?>
<?php require_once 'include/functions.php'; ?>
<?php //confirm_logged_in(); ?>
<?php require_once 'include/validation_function.php'; ?>


<?php
  $username = $_GET['user'];
  if (!isset($username)) {
    redirect_to('index.php');
  }
?>
<?php $user = find_user_by_username($username); ?>
<?php
	if (!isset($user) || empty($user)) {
		redirect_to('login.php');
	}
?>

<?php include 'include/layout/header.php'; ?>

<?php
	$user = find_user_by_username($username);
?>

<?php
  if (isset($_POST['submit'])) {

    $required_image = array('image');
    image_presences($required_image);

    validate_max_lengths($fields_with_max_lengths);

    $size= $_FILES['image']['size'];
    $type = addslashes($_FILES['image']['type']);
    $image = addslashes($_FILES['image']['tmp_name']);
    $extension = check_image_size($image,$size);
    check_image_type($extension);

    if (empty($errors)) {
      $username = mysql_prep($user['username']);
      $size= $_FILES['image']['size'];
	    $type = addslashes($_FILES['image']['type']);
	    $image = addslashes($_FILES['image']['tmp_name']);

      //$query = "UPDATE `updated` SET `slogan`='{$slogan}' WHERE user_id={$user_id} LIMIT 1";
      //$result = mysqli_query($connection,$query);
      $return = img($image,$username,$extension);

      if ($return) {
        //$_SESSION["message"] = "profile updated.";
        redirect_to('profile.php?user='. urlencode($username). "&username=" .urlencode($username));
      }else {
        //$_SESSION["message"] = "can't update";
        redirect_to('edit_profile.php?user='. urlencode($username));
      }
    }
  }
  else {
    //
    }
 ?>


<div class="cover bg">
	<div class="profile-info">
		<div class="dp-change">
			<img class="dp" src="" alt="Add a pic" ></img>
    </div>
		<div class="bio">
<form action="edit_profile.php?user=<?php echo htmlentities($username);?>" method="post" enctype="multipart/form-data">
			<div class="detail">
        <h5>Upload an Image</h5>
        <input style="font-size:17px;" type="file" accept=".png,.jpg,.jpeg" name="image" required>
      </div>
			<div class="detail"><?php echo htmlentities($user['username']); ?></div>
			<div class="email-info"><?php echo htmlentities($user['email']); ?></div>
		</div>
	</div>
	<div class=" slogan">
		<?php echo htmlentities($user['username']); ?><br>
	</div>
    <center>
      <input class="btn btn-success" style="margin-top:10px;" type="submit" name="submit" value="Update">
      <a class="btn btn-danger" style="margin-top:10px;" type="button" name="button" href="profile.php?user=<?php echo urlencode($user['username']) ."&username=". urlencode($user['username']); ?>"> Cancel </a>
    </center>
  </form>

</div>

<?php include 'include/layout/footer.php'; ?>
