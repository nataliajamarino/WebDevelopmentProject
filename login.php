<?php

  require_once "./classes/App.php";

  $app = new App();
  // If is POST login user in
  if (isset($_POST['email'])) {
    // Go to database and search user
    $user = $app->login($_POST);
    if (!empty($user)) {
      // Redirect user
      echo json_encode($user);
    } else {
      echo json_encode(["error" => "User not found"]);
    }
  }