$(document).ready(function() {
    $('#registrationForm').click(function(e) {
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();
        var password1 = $('#password1').val();

        // Check if email is empty or does not contain @gmail.com
        if (email.length <= 0 || !email.endsWith('@gmail.com')) {
            alert('Please enter a valid Gmail address!');
        } else if (password !== password1) {
            alert('Passwords do not match!');
        } else {
            $.ajax({
                type: 'POST',
                url: 'php/register.php', // Replace with your server-side script URL
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if(response.status=== 'exists'){
                        alert('email already registered');
                        
                    }
                    else if (response.status === 'success') {
                        alert('Successfully registered!');
                    } else {
                        alert('Registration failed!');
                    }
                }
            });
        }
    });
});
