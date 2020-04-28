function gebi(hetId){
    return document.getElementById(hetId);
}
function backEndCall(methode, url, callback){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            callback(this.responseText);
        }
    };
    xhttp.open(methode, url, true);
    xhttp.send();

}
function herladen(){
    location.reload();
}
function debug(response){
    console.log("in debug");
    console.log(response);
}





function remindmail(){
    var bedrijf = document.querySelector('input[name="bedrijfsnaam"]:checked').value;
    window.location = 'remindmail.php?klant='+bedrijf;
}



function maakfactuur(){
    var bedrijf = document.querySelector('input[name="bedrijfsnaam"]:checked').value;
    alert("factuur" + bedrijf);

}
