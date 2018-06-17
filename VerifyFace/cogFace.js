
// cogFace
// Using cognitive Face API service for verifing face in JavaScript

var subscriptionKey = "ecb40364cf9d439eb9a82d96d9dd8afc";
var imgName2 = "testimage";
var returnValue; 

var faceList = getFaceList();

// Get FaceID Using Cognivite API Service
var aaa; 
function reqListener () {
      console.log(this.responseText);
      }
var oReq = new XMLHttpRequest(); //New request object
oReq.onload = function() {
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
//alert(this.responseText); //Will alert: 42
aaa = this.responseText; 
};
oReq.open("get", "test2.php", true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to 
    //                                 continue.
oReq.send();

function getFaceId(imgName2) {
	aaa = aaa.trim(); 
	var imgName2 = aaa;
	var imgPath = "https://ketchup2.azurewebsites.net/VerifyFace/data/"+ imgName2;

	$(function() {
		var params = {
			// Request parameters
			"returnFaceId": "true",
			"returnFaceLandmarks": "false",
			//"returnFaceAttributes": "{string}",
		};
		$.ajax( {
			url: "https://eastus.api.cognitive.microsoft.com/face/v1.0/detect?" + $.param(params),
			beforeSend: function(xhrObj){
				// Request headers
				xhrObj.setRequestHeader("Content-Type","application/json");
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",subscriptionKey);
			},
			type: "POST",
			async: false,
			// Request body
			data: "{" + 
				"\"url\":\"" + imgPath + 
			"\"}"
		})
		.done(function(data) {
			var str = JSON.stringify(data);
			faceId = str.split(":").toString().split(",");

			document.getElementById('resultInfo').innerHTML += '<br>' + '[result]' + '<br>';

			document.getElementById('resultInfo').innerHTML += faceId[1];

			returnValue = faceId[1];

			verifyFace(returnValue); 

		})
		.fail(function() {
			alert(faceId);
			
		});
	});

	return returnValue;
}


function verifyFace(returnValue) {
	var faceListId = "test";
    var retval  = returnValue;
    var ddd; 
	$(function() {
		var params = {
			// Request parameters
		};

		$.ajax({
			url: "https://eastus.api.cognitive.microsoft.com/face/v1.0/findsimilars?" + $.param(params),
			beforeSend: function(xhrObj){
				// Request headers
				xhrObj.setRequestHeader("Content-Type","application/json");
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",subscriptionKey);
			},
			type: "POST",
			async: false,
			// Request body
			data: "{" +
				"\"faceID\":" + retval + "," +
				"\"faceListID\":\"" + faceListId + "\"," +
				"\"maxNumOfCandidatesReturned\":" + 10 + "," +
				"\"mode\":\"matchPerson\"" +
			"}",
		})
		.done(function(data) {
			document.getElementById('resultInfo').innerHTML += JSON.stringify(data) + '<br>';

			for (x = 0; x < faceList.length; x++) {
				if (data[0].persistedFaceId == faceList[x].persistedFaceId) {
					document.getElementById('resultInfo').innerHTML += faceList[x].persistedFaceId + '<br>';
                    document.getElementById('resultInfo').innerHTML += faceList[x].userData + '<br>';
                    ddd = faceList[x].userData;
				}
			}
		
			uploadData();

		})
		.fail(function() {
			alert("error");
		});
    });
    return ddd; 
}



function uploadData(){
	var time = new Date();
	var fileName = time.getTime();
	fileName += '.txt'
	var formData = new FormData();
	data = document.getElementById("resultInfo").innerHTML;
    formData.append("fileObj", data);
	formData.append("fileName", fileName);
 
    $.ajax({
        url: 'uploadData.php',
        processData: false,
        contentType: false,
    	data: formData,
        type: 'POST',
        success: function(result){
			
        }
    });
}

function getFaceList() {
	var faceListId = "test";

	$(function() {
		var params = {
			// Request parameters
		};

		$.ajax({
			url: "https://eastus.api.cognitive.microsoft.com/face/v1.0/facelists/" + faceListId + "?" + $.param(params),
			beforeSend: function(xhrObj){
				// Request headers
			xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
			},
			type: "GET",
			// Request body
			data: "{body}",
		})
		.done(function(data) {
			document.getElementById('resultInfo').innerHTML += '<br>' + 'Cognitive API Server에서 FaceList 불러오기를 완료했습니다. 안녕안녕안녕안녕안녕ㄴㅇㄹㄴㅇ라ㅣㄴㅇ리ㅏ
			' + '<br>' + '[FaceList]' + '<br>';

			faceList = data['persistedFaces'];

			for (x=0; x < faceList.length; x++) {
				document.getElementById('resultInfo').innerHTML += faceList[x].persistedFaceId;
				document.getElementById('resultInfo').innerHTML += faceList[x].userData + '<br>';
				
			}

			/*
			for (x in data) {
				document.getElementById("resultInfo").innerHTML += x + " " + JSON.stringify(data[x]) + "<br>";
				document.getElementById("resultInfo").innerHTML += x + " " + data[x][0].persistedFaceId + "<br>";
			}
			*/

			getFaceId(imgName2);
		})
		.fail(function() {
			alert("error");
		});
	});

	return faceList;
}

