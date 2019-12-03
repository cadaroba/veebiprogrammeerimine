//window.alert("Näe, see töötab");
//console.log("Näe, see töötab");

//teen nii et nuppu ei saa klikkida kui faili pole .js abil
window.onload = function(){
	document.getElementById("submitPic").disabled = true;
	document.getElementById("fileToUpload").addEventListener("change", checkSize);
}

function checkSize(){
	let fileToUpload = document.getElementById("fileToUpload") .files[0];
	console.log(fileToUpload);
	if(fileToUpload.size <= 2500000){
		document.getElementById("submitPic").disabled = false;
		document.getElementById("notice").innerHTML = "";
	} else {
		document.getElementById("submitPic").disabled = true;
		document.getElementById("notice").innerHTML = "Valitud fail on liiga suur!";
	}
}