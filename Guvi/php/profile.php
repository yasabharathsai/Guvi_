<?php
require 'vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('guvi');
$collection = $database->users;

session_start();

// Retrieve user email from the session
$userEmail = $_SESSION['user_email'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve user details from MongoDB based on the user email
    $userDetails = $collection->findOne(['email' => $userEmail]);


    if ($userDetails) {
        $userArray = $userDetails->toArray();
        $response = array("status" => "success", "user" => $userArray);
    } 
    else {
        // If user details not found, insert a new document with empty values
        $insertResult = $collection->insertOne([
            'email' => $userEmail,
            'name' => '',
            'gender' => '',
            'mobile_number' => ''
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            $response = array("status" => "success", "user" => array('email' => $userEmail,
            'name' => '',
            'gender' => '',
            'mobile_number' => '')
                
            );
        } else {
            $response = array("status" => "error");
        }
    }
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
    // Update user details in MongoDB
    $updatedName = $_POST['editName'];
    $updatedGender = $_POST['editGender'];
    $updatedMobile = $_POST['editMobile'];

    $updateResult = $collection->updateOne(
        ['email' => $userEmail],
        ['$set' => [
            'name' => $updatedName,
            'gender' => $updatedGender,
            'mobile_number' => $updatedMobile
        ]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        $response = array("status" => "success", "user" => array(
            "email" => $userEmail,
            "name" => $updatedName,
            "gender" => $updatedGender,
            "mobile_number" => $updatedMobile
        ));
    } else {
        $response = array("status" => "error");
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
