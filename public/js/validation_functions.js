existEmail = (value) => {
    let result;
    let email = {
        url: BASE_URL + "/auth/emailExist",
        data: {
            email: value,
        },
        async: false,
        dataType: "json",
        method: "post",
        success: function(res) {
            result = res;
        },
        error: function(err) {
            console.log(err);
        }
    }
    $.ajax(email);

    if (result.status == 1) {
        return false;
    } else {
        return true;
    }
}

existMobile = (value) => {
    let result;
    let username = {
        url: BASE_URL + "/auth/mobileExist",
        data: {
            phone: value,
        },
        async: false,
        method: "post",
        dataType: "json",
        success: function(res) {
            result = res;
        },
        error: function(err) {
            console.log(err);
        }
    }
    $.ajax(username);
    if (result.status == 1) {
        return false;
    } else {
        return true;
    }
}

validGotra = (value) => {
    let result;
    let username = {
        url: BASE_URL + "/gotras/validgotra",
        data: {
            "gotra_id": value,
        },
        async: false,
        method: "post",
        dataType: "json",
        success: function(res) {
            result = res;
        },
        error: function(err) {
            console.log(err);
        }
    }
    $.ajax(username);
    if (result.status == 1) {
        return true;
    } else {
        return false;
    }
}


jQuery.validator.addMethod("email", function(value, element) {
    return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
}, 'Please enter a valid email address..');

jQuery.validator.addMethod("emailExist", function(value, element) {
    let has = existEmail(value);
    return this.optional(element) || has;
}, 'Email already exist!');

jQuery.validator.addMethod("mobileExist", function(value, element) {
    let has = existMobile(value);
    return this.optional(element) || has;
}, 'Mobile already exist!');

jQuery.validator.addMethod("validGotra", function(value, element) {
    let has = validGotra(value);
    return this.optional(element) || has;
}, 'Entered gotra is not correct');

jQuery.validator.addMethod("phone", function(value, element) {
    return this.optional(element) || /^[6-9]\d{9}$/gi.test(value);
}, 'Not a valid phone no.');