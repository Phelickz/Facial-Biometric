// JavaScript Document
//alert("Veripay Face Dector Ready ")
// JavaScript Document
//alert("Veripay Face Dector Ready ")
var CLASS_ID =Math.floor((Math.random() * 600666666) + 1);
localStorage.setItem("CLASS_IDD", CLASS_ID);
console.log(localStorage.getItem("CLASS_IDD"))

localStorage.setItem("ECLASS_IDD", CLASS_ID );

var TASK="enroll";
var token;

var myUrl="https://eaglet4.appmartgroup.com/Biometric/EToken";
 //store Local

var request = $.ajax({
	 url: myUrl,
	 method: "POST",
	 data: {
        "task": TASK,
		"classID": CLASS_ID ,
"livedetection":false,
        
  },
});
request.done(function(data) {

Etoken =data;
console.log("entrol token",Etoken);
localStorage.setItem("Enroll_TOKEN_IDD", Etoken );
});
 request.fail(function( jqXHR, textStatus ) {

console.log("Check Network Connection ");
 
 
});	  

//var dataURLD= localStorage.getItem("dataURL");
//alert(dataURLD);
