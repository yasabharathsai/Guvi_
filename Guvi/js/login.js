
$(document).ready(function() {
    $('#loginForm').click(function(e) {
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();
        if (email.length <= 0 || !email.endsWith('@gmail.com')) {
            alert('Please enter a valid Gmail address!');
        
        } 
        else{

        

        $.ajax({
            type: 'POST',
            url: 'php/login.php', // Your PHP script for verification
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                if (response.status === 'success') {
                    
                    alert(response.message);
                    window.location.href = 'profile.html';
                    // Redirect or perform other actions upon successful login
                } else {
                    alert(response.message);
                }
                
            },
            error: function() {
                alert('Error: Unable to process request.');
            }
        });
    }
    });
});







    