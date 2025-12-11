function checkEmail(Email)

{
	var TestEmail = /^(.[A-Za-z0-9\-]*\w)+@+([A-Za-z0-9\-]*\w)+(\.[A-Za-z]*\w)+$/;
	var wynik = Email.match(TestEmail);

	if (wynik == null)
	{
		alert("Proszę wpisać poprawny adres e-mail!");
        forms["kontakt"]["email"].value='';
        document.getElementById("contactform").action = "javascript:void(0);"; 
		return false;
	}
		return true;
}


function validateForm() {
    var y = document.forms["contactform"]["name"].value;
    var z = document.forms["contactform"]["email"].value;
    var w = document.forms["contactform"]["message"].value;

    if ( y =="" || z == "") {
        alert("Wypełnij wymagane pola");
        document.getElementById("contactform").action = "javascript:void(0);";
        return false;
    }else{
        checkEmail(z);
    }
    
    if (w == ""){
        alert("Nie wpisałeś zadnej treści wiadomości.")
        document.getElementById("contactform").action = "javascript:void(0);";
        return false;
    }

    if (y !="" && z != "" && w != "") {
        document.getElementById("contactform").action = "/php/mail.php"; 
        return true;
    }
};
