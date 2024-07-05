const spn = document.getElementsByClassName("empty");
        const fname = document.getElementById("fname");
        const lname = document.getElementById("lname");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const validationMessage = document.getElementById("divEmail");
        const checkbox = document.getElementsByClassName("checkbox")[0];
        const checkboxEmpty = document.getElementsByClassName("checkboxEmpty")[0];
        const submit = document.getElementById("submit");

        const validation = () => {
            const emailInput = email.value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (emailInput !== "" && emailPattern.test(emailInput)) {
                validationMessage.style.display = "block";
                validationMessage.innerHTML = "Valid email address!";
                validationMessage.style.color = "green";
                spn[2].style.display = "none";
            } else if (emailInput !== "" && !emailPattern.test(emailInput)) {
                validationMessage.style.display = "block";
                validationMessage.innerHTML = "Invalid email address!";
                validationMessage.style.color = "red";
                spn[2].style.display = "none";
            }
        }

        const firstName = () => spn[0].style.display = "none";
        const lastName = () => spn[1].style.display = "none";
        const passWord = () => spn[3].style.display = "none";
        const checkBox = () => checkboxEmpty.style.display = "none";

        email.addEventListener("change", validation);
        fname.addEventListener("change", firstName);
        lname.addEventListener("change", lastName);
        password.addEventListener("change", passWord);
        checkbox.addEventListener("change", checkBox);

        const validate = () => {
            let allFieldsFilled = true;
            const x = document.forms["formI"];
            let k = x.length;

            for (let i = 0; i < k; i++) {
                if (spn[i] && x.elements[i].value === "") {
                    x.elements[i].style.border = "1px solid red";
                    spn[i].style.display = "block";
                    allFieldsFilled = false;
                    if (i == 2) validationMessage.style.display = "none";
                } else {
                    if (spn[i]) {
                        spn[i].style.display = "none";
                    }
                }
            }
            if(spn[0].style.display !== "none"|| spn[1].style.display !== "none" ) {
                email.style.marginTop="-6%";
                if(spn[2].style.display !== "none")password.style.marginTop="-6%";
                else password.style.marginTop="-6%"
            }

            if (!checkbox.checked) {
                checkboxEmpty.style.display = "block";
            } else {
                checkboxEmpty.style.display = "none";
            }

            if (spn[0].style.display === "none" &&
                spn[1].style.display === "none" &&
                validationMessage.innerHTML === "Valid email address!" &&
                spn[3].style.display === "none" &&
                checkboxEmpty.style.display === "none") {
                return true;
            } else {
                return false;
            }
        }

        submit.addEventListener("click", (event) => {
            if (!validate()) {
                event.preventDefault();
            }
        } 
    );

  






