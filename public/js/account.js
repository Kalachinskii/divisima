function validateForm(input, regex) {
    // проверка введенного инпута с переданной регулярным выражением
    if(!regex.test(input.value)) {
      // классы для бутстрапа
        input.classList.add('is-invalid');
        input.classList.remove("is-valid");
        return false;
    } else {
        input.classList.add('is-valid');
        input.classList.remove("is-invalid");
        return true;
    }
}

function sendAccountForm(e) {
    e.preventDefault();
    const loginInput = document.querySelector("#login");
    const passwordInput = document.querySelector("#password");
    const isLoginValid = validateForm(loginInput, /^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$/);
    const isPasswordValid = validateForm(passwordInput, /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/);
    
    if(isLoginValid && isPasswordValid) {
        //document.querySelector("#form-signup").submit();
        this.submit();
    }
}

document.querySelector("#form-signup")?.addEventListener("submit", sendAccountForm);
document.querySelector("#form-signin")?.addEventListener("submit", sendAccountForm);