function verifierMail() {
    str = document.getElementById('mailIndex').value;
    regexp = new RegExp("^[a-zA-Z0-9_\\-\\.]{3,}@[a-zA-Z0-9\\-_]{2,}\\.[a-zA-Z]{2,4}$", "g");

    if(!regexp.test(str)) {
        alert("Syntaxe E-mail incorrect : xxx@yyy.fr !");
        document.getElementById('mailIndex').style.background = "#F2F2F2";
        return false;
    }
    else {
        return true;
    }
}

function verifierMailRegister() {       
    prenom = document.getElementById('firstName').value;
    nom = document.getElementById('name').value;
    mel = document.getElementById('mail').value;
    pass1 = document.getElementById('password').value;
    pass2 = document.getElementById('confirm').value;
    regexp = new RegExp("^[a-zA-Z0-9_\\-\\.]{3,}@[a-zA-Z0-9\\-_]{2,}\\.[a-zA-Z]{2,4}$", "g");
    if(prenom == "" || nom == "" || mel  == "" ||  pass1 == "" ||  pass2 == "")
    {
        alert("Remplir tous les champs !");
        return false;
    }    
    else if(!regexp.test(mel)) {
        alert("Syntaxe E-mail incorrect : xxx@yyy.fr !");
        document.getElementById('mail').style.background = "#F2F2F2";
        return false;
    }
    else if(pass1 !=  pass2)
    {
        alert("les deux mots de passe doivent être identiques !");
        return false;
    }
    else {
        return true;
    }
}

function confirmDelete(s) {
	var ok = false;
	if(confirm(s)) ok = true;
	return ok;
}