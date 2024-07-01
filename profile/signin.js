window.onload = () => {
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";
}
const icon = document.getElementById("iconP");
const password = document.getElementById("password");
const spn = document.getElementsByClassName("empty");
const email = document.getElementById("email");
const validationMessage = document.getElementById("divEmail");
let allFieldsFilled = true;
const checkbox = document.getElementsByClassName("checkbox")[0];
const confirm = document.getElementsByClassName("confirm")[0];
const submit = document.getElementById("submit");

const passWord = () => {
    spn[1].style.display = "none";
}

const validation = () => {
    const emailInput = document.getElementById("email").value;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (emailInput !== "" && emailPattern.test(emailInput)) {
        validationMessage.style.display = "block";
        validationMessage.innerHTML = "Valid email address!";
        validationMessage.style.color = "green";
        document.getElementsByClassName("empty")[0].style.display = "none";
    } else if (emailInput !== "" && !emailPattern.test(emailInput)) {
        validationMessage.style.display = "block";
        validationMessage.innerHTML = "Invalid email address!";
        validationMessage.style.color = "red";
        allFieldsFilled = false;
        document.getElementsByClassName("empty")[0].style.display = "none";
    }
    icon.style.marginTop = "-1.2rem";
    password.style.marginTop = "-20px";
}

const validate = () => {
    const emailInput = document.getElementById("email").value;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    allFieldsFilled = true;

    if (emailInput !== "" && emailPattern.test(emailInput)) {
        validationMessage.style.display = "block";
        validationMessage.innerHTML = "Valid email address!";
        validationMessage.style.color = "green";
    } else if (emailInput !== "" && !emailPattern.test(emailInput)) {
        validationMessage.style.display = "block";
        validationMessage.innerHTML = "Invalid email address!";
        validationMessage.style.color = "red";
        allFieldsFilled = false;
    }

    const x = document.forms["formI"];
    let k = x.length;
    for (let i = 0; i < k; i++) {
        if (spn[i] && x.elements[i].value === "") {
            spn[i].style.display = "block";
            allFieldsFilled = false;
            if (i == 0) validationMessage.style.display = "none";
        } else {
            if (spn[i]) {
                spn[i].style.display = "none";
            }
        }
    }

    if (validationMessage.innerHTML == "Valid email address!" && spn[1].style.display == "none") {
        return true;
    }

    if (spn[1].style.display !== "none") {
        icon.style.marginTop = "-1.2rem";
        password.style.marginTop = "-20px";
        submit.style.marginTop = "30px";
    } else {
        icon.style.marginTop = "-1.2rem";
        password.style.marginTop = "-20px";
    }

    if (spn[0].style.display !== "none" && spn[1].style.display !== "none" && spn[3].style.display !== "none" && checkboxEmpty.style.display == "block") {
        submit.style.marginTop = "1rem";
    }

    return allFieldsFilled;
}

document.getElementById("email").addEventListener("change", validation);
password.addEventListener("change", passWord);

document.getElementById("submit").addEventListener("click", (event) => {
    if (!validate()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
