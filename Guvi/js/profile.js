$(document).ready(function () {
    // Wait for the DOM content to be fully loaded

    // Perform AJAX request to retrieve user details from the backend
    $.ajax({
        type: "GET",
        url: "php/profile.php", // Replace with the correct path to your PHP file
        success: function (response) {
            // Handle the JSON response from the backend
            if (response.status === "success") {
                // Display user details on the profile page
                $("#userEmail").text(response.user.email);
                $("#userName").text(response.user.name);
                $("#userGender").text(response.user.gender);
                $("#userMobile").text(response.user.mobile_number);
            } else {
                alert("Error: Unable to retrieve user details.");
            }
        },
        error: function (error) {
            // Handle the error response from the backend
            alert("Error: " + error.responseText);
        }
    });

    $(document).ready(function () {
        // ... (existing code)
    
        // Edit Profile button click event
        $("#editProfileBtn").click(function () {
            // Hide display elements, show edit form
            $("#editProfileForm").show();
            $("#editProfileBtn").hide();
            $("#profile_details").hide();
        });
    
        // Update Profile button click event
        $("#updateProfileBtn").click(function () {
            // Get the updated values from the form
            var editedName = $("#editName").val();
            var editedGender = $("#editGender").val();
            var editedMobile = $("#editMobile").val();
            // Perform AJAX request to update user details
            $.ajax({
                type: "POST",
                url: "php/profile.php", // Replace with the correct path to your PHP file
                data: {
                    updateProfile: true,
                    editName: editedName,
                    editGender: editedGender,
                    editMobile: editedMobile
                },
                success: function (response) {
                    // Handle the JSON response from the backend
                    if (response.status === "success") {
                        // Update displayed user details
                        $("#userName").text(response.user.name);
                        $("#userGender").text(response.user.gender);
                        $("#userMobile").text(response.user.mobile_number);
    
                        // Hide edit form, show display elements
                        $("#editProfileForm").hide();
                        $("#profileId span").show();
    
                        alert("Profile updated successfully!");
                    } else {
                        alert("Error: Unable to update profile.");
                    }
                },
                error: function (error) {
                    // Handle the error response from the backend
                    alert("Error: " + error.responseText);
                }
                

            });
            $("#editProfileForm").hide();
            $("#profile_details").show();
        $("#editProfileBtn").show();
        });
    });
    
});
