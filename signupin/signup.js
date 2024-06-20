
const spn = document.getElementsByClassName("empty");
const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const password = document.getElementById("password");
const validationMessage = document.getElementById("divEmail");
const checkbox=document.getElementsByClassName("checkbox")[0];
const confirm=document.getElementsByClassName("confirm")[0];
const checkboxEmpty=document.getElementsByClassName("checkboxEmpty")[0];
const submit= document.getElementById("submit");
const terms=document.getElementsByClassName("terms")[0];    // Adjust margin if fname or lname is visible

const validation = () => {
const emailInput = document.getElementById("email").value; 
const validationMessage = document.getElementById("divEmail");
// Regular expression for basic email validation
const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
if ( emailInput!="" && emailPattern.test(emailInput)) {
    validationMessage.style.display="block";
    validationMessage.innerHTML = "Valid email address!";
    validationMessage.style.color = "green";
    document.getElementsByClassName("empty")[2].style.display="none";
}  if ( emailInput!="" && !emailPattern.test(emailInput))  {validationMessage.style.display="block";
    validationMessage.innerHTML = "Invalid email address!";
    validationMessage.style.color = "red";
    allFieldsFilled = false;
    document.getElementsByClassName("empty")[2].style.display="none";
   
}
}
const firstName = () => {spn[0].style.display="none";}
const lastName = () => {spn[1].style.display="none";}
const passWord =() => {spn[3].style.display="none";}
const checkBox =() => {checkboxEmpty.style.display="none";}
document.getElementById("email").addEventListener("change", validation);
const validate = () => {
 
    
    let allFieldsFilled = true;
 
   
    const emailInput = document.getElementById("email").value;
    
    // Regular expression for basic email validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    if ( emailInput!="" && emailPattern.test(emailInput)) {
        validationMessage.style.display="block";
        validationMessage.innerHTML = "Valid email address!";
        validationMessage.style.color = "green";
    }  if ( emailInput!="" && !emailPattern.test(emailInput))  {validationMessage.style.display="block";
        validationMessage.innerHTML = "Invalid email address!";
        validationMessage.style.color = "red";
        allFieldsFilled = false;
       
    }


    // Form validation
    const x = document.forms["formI"];
    let k = x.length;
    for (let i = 0; i < k; i++) {
        if (spn[i] && x.elements[i].value === "") { // Check if the value of the form element is empty
            x.elements[i].style.border = "1px solid red";
            spn[i].style.display = "block";
            allFieldsFilled = false;
            if(i==2)validationMessage.style.display="none";
            
        } else {
            if (spn[i]) {
                spn[i].style.display = "none";
            }
            
        }
    }
    if(checkbox.checked==false){
        checkboxEmpty.style.display="block";
        confirm.style.textDecorationColor = "red";
       confirm.style.textUnderlineOffset= "3px"; 
       confirm.style.textDecorationThickness=" 1.15px";  
     }
    else{
        checkboxEmpty.style.display="none";
        confirm.style.textDecoration = "none";
        terms.style.textDecoration="block";
        terms.style.textDecorationColor="rgb(70, 54, 16)";

    }
       //styles if
       if(spn[0].style.display == "none" && spn[1].style.display == "none" && validationMessage.innerHTML == "Valid email address!" && spn[3].style.display == "none" && checkboxEmpty.style.display=="none")location.href="./signin.html";

       if (spn[0].style.display !== "none" || spn[1].style.display !== "none") {
           email.style.marginTop = "-23px";
           password.style.marginTop = "-23px";
       }
       else{email.style.marginTop = "-23px";
        password.style.marginTop = "-23px";}
    if (spn[0].style.display !== "none" && spn[1].style.display !== "none"  && spn[3].style.display !== "none" && checkboxEmpty.style.display=="block"){
        submit.style.marginTop="1rem";
    }

}
fname.addEventListener("change", firstName);
lname.addEventListener("change",lastName);
password.addEventListener("change", passWord);
checkbox.addEventListener("change",checkBox);
document.getElementById("submit").addEventListener("click", (event) => {
 if (!validate()) {
     event.preventDefault(); // Prevent form submission if validation fails
 }
});

  






