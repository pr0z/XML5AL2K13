function verifierMail() {
    str = document.getElementById('mailIndex').value;
    regexp = new RegExp("^[a-zA-Z0-9_\\-\\.]{3,}@[a-zA-Z0-9\\-_]{2,}\\.[a-zA-Z]{2,4}$", "g");

    if(!regexp.test(str)) {
        alert("Syntaxe E-mail incorrect : xxx@yyy.z !");
        document.getElementById('mailIndex').style.background = "#F2F2F2";
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