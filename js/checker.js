email.onblur  = function () {
    fetch('checker.php', {
        method: 'post',
            headers: {
            'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
        },
        body: JSON.stringify({cmd: "check_email", value: this.value})
    }).then(function (res) {return res.json(); })
        .then(function (data) {
        if(!data.success) {
            submit.disabled = true;
            email.style.border = "2px solid red";
            email_error.textContent = data.error;
        } else {
            submit.disabled = false;
            email.style.border = "2px solid green";
            email_error.textContent = "";
        }
    });
};

user_name.onblur  =function () {
    fetch('checker.php', {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({cmd: "check_user_name", value: this.value})
    }).then(function (res) {return res.json(); }).then(function (data) {
        if(!data.success) {
            submit.disabled = true;
            user_name.style.border = "2px solid red";
            username_error.textContent = data.error;
        } else {
            submit.disabled = false;
            user_name.style.border = "2px solid green";
            username_error.textContent = "";
        }
    });
};

