<?php
uploadImage(); 

$testimage; 
$faceiid; 
$faceidverify; 
$body; 
function uploadImage(){
    global $testimage; 
    global $faceiid;
    global $faceidverify; 
    global $json2;
    global $body; 
    @ini_set(‘display_error’, ‘On’);
    @error_reporting(E_ALL);
    callImage(); 
    $file_path = "VerifyFace/data/";
    //안드로이드에서 VerifyFace/data/로 이미지를 보낸다.    
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        getfacelist(); 
        //echo "success";

    } else{
        getfacelist(); 
        //echo "fail";
    }
}

function callImage(){
    global $testimage; 
    // 폴더명 지정
    $dir = "VerifyFace/data/";

    // 핸들 획득
    $handle  = opendir($dir);

    $files = array();

    // 디렉터리에 포함된 파일을 저장한다.
    while (false !== ($filename = readdir($handle))) {
    if($filename == "." || $filename == ".."){
        continue;
    }

    // 파일인 경우만 목록에 추가한다.
    if(is_file($dir . "/" . $filename)){
        $files[] = $filename;
    }
    }

    // 핸들 해제 
    closedir($handle);

    // 정렬, 역순으로 정렬하려면 rsort 사용
    rsort($files);
    //echo $files[0]; 
    // 파일명을 출력한다.
    //foreach ($files as $f) {
    //  echo $f;
    //echo "<br />";
    //} 
    $testimage = $files[0]; 
    $testimage = trim($testimage); 
    

}

 

//getfacelist(); 
//getFaceId();
//verifyFace(); 
$faceiid;
$faceidverify; 
$json2;
$body; 
function getFacelist(){
    global $json2; 
    global $faceidverify;
    global $body; 
    $url = "https://eastasia.api.cognitive.microsoft.com/face/v1.0/facelists/test?&{body}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Ocp-Apim-Subscription-Key:f2e869d6b10b435fbee3a6276588d08a'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
        curl_setopt($ch, CURLOPT_URL, "https://eastasia.api.cognitive.microsoft.com/face/v1.0/facelists/test?&{body}");
    $body = curl_exec($ch);
    curl_close($ch);
    //echo "[facelist]<br />\n";
    //echo $body;
    $json2 = $body; 
    getfaceId(); 

    
}

function getFaceId(){
    global $faceiid;
    global $testimage;
    $img_path = "https://ketchup2.azurewebsites.net/VerifyFace/data/".$testimage;
    $url = 'https://eastasia.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false';
    //$param = "{\"url\":\"".$img_path."\"}";

    $data = array("url" => $img_path); 
    $param = json_encode($data); 
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Ocp-Apim-Subscription-Key: f2e869d6b10b435fbee3a6276588d08a'
        ));
    
    $contents = curl_exec($ch);
    curl_close($ch);
    //echo "<br> [faceid]";
    $json = json_decode($contents, true); 
    
    //echo $json[0]['faceId'];
    $faceiid = $json[0]['faceId'];
    verifyFace(); 
    
}

function verifyFace(){
    global $faceiid;
    global $json2; 
    global $body; 
    $flag=0; 
    $faceid = "test"; 
    //$img_path = "https://loginwithface.azurewebsites.net/VerifyFace/data/20171106154948.jpg";
    $url = 'https://eastasia.api.cognitive.microsoft.com/face/v1.0/findsimilars?';
    $data = array("faceID" => $faceiid, 
    "faceListID" => "test", "maxNumOfCandidatesReturned" => 10, 
    "mode" => "matchPerson"); 
    $param = json_encode($data); 
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Ocp-Apim-Subscription-Key: f2e869d6b10b435fbee3a6276588d08a'
        ));
    
    $contents = curl_exec($ch);
    curl_close($ch);
    //echo "<br>[result]";
    //echo $contents;
    $json3 =json_decode($contents, true); 
    
    //echo $json3[0]['persistedFaceId'];

    //echo "<br><br><br><br>"; 
    $json2 = json_decode($body, true); 
    
    
    //echo "<br>"; 
    
    $json2['persistedFaces'][1]['persistedFaceId'];
    for($i=0; $i<=10; $i++){
        if($json3[0]['persistedFaceId'] == $json2['persistedFaces'][$i]['persistedFaceId']){
            //echo $json2['persistedFaces'][$i]['persistedFaceId'];
            
            echo $json2['persistedFaces'][$i]['userData'];
            //echo $json3[0]['confidence'];
            if(empty($json2['persistedFaces'][$i]['userData'])){
                $flag=1; 
            }
        }

    }
    if($flag==1){
        echo "notuser";
        $flag=0;
    }

}

?>

