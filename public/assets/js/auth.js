$(document).ready(function () {
  /**
   * function to validate user credential and
   * redirect user to homepage on register success.
   *
   * */
  $("#register_btn").click(function (event) {
    event.preventDefault();
    var form = $("form").serializeArray();
    var isAnyEmptyField = false;
    var formDataArr = {};
    form.forEach((element) => {
      if (!element.value) {
        isAnyEmptyField = true;
        return;
      }
      formDataArr[element.name] = element.value;
    });

    if (isAnyEmptyField) {
      generateErrorMessage("Fields can not be empty");
    }

    if (isRegisterFormValid()) {
      $.ajax({
        url: "/register",
        type: "post",
        data: {
          name: formDataArr["name"],
          email: formDataArr["email"],
          password: formDataArr["password"],
        },
        dataType: "text",
        success: function (response) {
          var response_arr = JSON.parse(response);
          if (response_arr["status"] == "success") {
            // move the user to home page is everythig is fine
            window.location = "/";
          } else if (response_arr["status"] == "failed") {
            //show error message and navigate to path to register again
            $redirect_route = "/register";
            window.location =
              "/error/" + response_arr["message"] + $redirect_route;
          } else {
            //this block exicutes if server side validation failed.
            $error_arr = response_arr["message"];
            generateErrorMessage($error_arr);
          }
        },

        error: function (xhr, status, error) {
          // path of route to navigate, after showing error message
          $redirect_route = "/register";
          window.location = "/error/" + error + $redirect_route;
        },
      });
    }
  });

  /**
   * function to validate user credential and
   * redirect user to homepage on login success.
   *
   * */
  $("#login_btn").click(function (event) {
    event.preventDefault();
    var form = $("form").serializeArray();
    var isAnyEmptyField = false;
    var formDataArr = {};
    form.forEach((element) => {
      if (!element.value) {
        isAnyEmptyField = true;
        return;
      }
      formDataArr[element.name] = element.value;
    });

    if (isAnyEmptyField) {
      generateErrorMessage("Fields can not be empty");
    }

    if (isLoginFormValid()) {
      $.ajax({
        url: "/login",
        type: "post",
        data: {
          email: formDataArr["email"],
          password: formDataArr["password"],
        },
        dataType: "text",
        success: function (response) {
          // console.log(response);
          var response_arr = JSON.parse(response);

          if (response_arr["status"] == "success") {
            // move the user to home page is everythig is fine, i.e login success.
            window.location = "/";
          } else if (response_arr["status"] == "failed") {
            //path of route to navigate, after showing error message
            $redirect_route = "/login";
            window.location =
              "/error/" + response_arr["message"] + $redirect_route;
          } else {
            //this block exicutes if server side validation failed.
            $error_arr = response_arr["message"];
            generateErrorMessage($error_arr);
          }
        },

        error: function (xhr, status, error) {
          // path of route to navigate, after showing error message
          $redirect_route = "/login";
          window.location = "/error/" + xhr + $redirect_route;
        },
      });
    }
  });

  /**
   * Returns true if the register form is valid.
   *
   * @returns boolean
   */
  function isRegisterFormValid() {
    var isValid = true;
    if (!validNameRegx($("[name='name']").val())) {
      $("#error-field-name").html("Name can only contain alphabets");
      isValid &= false;
    }
    if (!validEmailRegx($("[name='email']").val())) {
      $("#error-field-email").html("Email fromat is not valid");
      isValid &= false;
    }
    if ($("[name='password']").val().length < 6) {
      $("#error-field-password").html("Password can not be less than 6 digit");
      isValid &= false;
    }
    if ($("[name='password']").val() !== $("[name='confirm-password']").val()) {
      $("#error-confirm-password").html("Password do not match");
      isValid &= false;
    }
    return isValid;
  }

  /**
   * Returns true if the login form is valid.
   *
   * @returns boolean
   */
  function isLoginFormValid() {
    var isValid = true;
    if (!validEmailRegx($("[name='email']").val())) {
      $("#error-field-email").html("Email fromat is not valid");
      isValid &= false;
    }
    if ($("[name='password']").val().length < 6) {
      $("#error-field-password").html("Password can not be less than 6 digit");
      isValid &= false;
    }
    return isValid;
  }

  //generates error if any field is empty
  function generateErrorMessage($err_msg) {
    $("#error-field").html($err_msg);
    setTimeout(function () {
      $("#error-field").html("");
    }, 5000);
  }

  // Returns true if name contains no digit.
  function validNameRegx(value) {
    var regex = /^[a-zA-Z]+[ ][a-zA-Z]+$/;
    var regex2 = /^[a-zA-Z]+$/;
    return regex.test(value) || regex2.test(value);
  }

  // Returns true on valid mail syntax.
  function validEmailRegx(value) {
    return value.match(
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
  }
});
