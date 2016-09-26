window.onload = function() {
    var loginForm = document.querySelector('.loginform');
    var registerForm = document.querySelector('.registration');
    
    function validateEmail(email) {
        return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email);
    }
    
    function validatePhone(phone) {
        return /^([+0-9\-])+$/.test(phone);
    }
    
    if (registerForm) {
        //Desactivar la validación por HTML5
        registerForm.setAttribute('novalidate', true);
        
        registerForm.onsubmit = function(e) {
            var email = document.getElementById('email');
            var password = document.getElementById('password');
            var cpassword = document.getElementById('cpassword');
            var name = document.getElementById('name');
            var lastname = document.getElementById('lastname');
            var age = document.getElementById('age');
            var male = document.getElementById('male');
            var female = document.getElementById('female');
            var phone = document.getElementById('phone');

            var errors = [];

            if (email.value == "") {
                errors.push('Email is required');
            }
            if (!validateEmail(email.value)) {
                errors.push('Enter a valid email');
            }
            if (password.value == "") {
                errors.push('Confirm password');
            }
            if (cpassword.value == "") {
                errors.push('Password is required');
            }
            if (password.value !== cpassword.value) {
                errors.push('Passwords don\'t match');
            }
            if (name.value == "") {
                errors.push('Name is required');
            }
            if (lastname.value == "") {
                errors.push('Last name is required');
            }
            if (age.value == "") {
                errors.push('Age is required');
            }
            if (phone.value == "") {
                errors.push('Phone is required');
            }
            if (!validatePhone(phone.value)) {
                errors.push('Phone is invalid');
            }

            if (errors.length) {
                alert(errors.join("\n"));
                return false;
            }
        };
    }
    if (loginForm) {
        //Desactivar la validación por HTML5
        loginForm.setAttribute('novalidate', true);
        
        loginForm.onsubmit = function(e) {
            var email = document.getElementById('email-login');
            var password = document.getElementById('password-login');

            var errors = [];

            if (email.value == "") {
                errors.push('Email is required');
            }
            if (!validateEmail(email.value)) {
                errors.push('Enter a valid email');
            }
            if (password.value == "") {
                errors.push('Confirm password');
            }

            if (errors.length) {
                alert(errors.join("\n"));
                return false;
            }
        };
    }  
};
