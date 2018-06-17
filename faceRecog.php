<?php

$testimage; 
$faceiid; 
$faceidverify; 
$body; 
callImage(); 
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
    
    getFaceId();

}

 

//getfacelist(); 
//getFaceId();
//verifyFace(); 
$faceiid;
$faceidverify; 
$json2;
$body; 



function getFaceId(){
    global $faceiid;
    global $testimage;
    $img_path = "https://ketchup2.azurewebsites.net/VerifyFace/data/".$testimage;
    $url = 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=age,emotion';
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
        'Ocp-Apim-Subscription-Key: 99ac879cf67b4a7391e9ed38112c6e64'
        ));
    
    $contents = curl_exec($ch);
    curl_close($ch);
    //echo "<br> [faceid]";
    $json = json_decode($contents, true); 
    
    //echo $json[0]['faceId'];
    $faceiid = $json[0]['faceId'];
    //$faceatt = $json[0]['faceAttributes']['age'];
    $faceemo = $json[0]['faceAttributes']['emotion'];
    //rsort($json[0]['faceAttributes']);
    
    
    //echo $faceatt; 
    //echo "\n";
   // print_r($faceemo);

    $someArray = $json; // Replace ... with your PHP Array
 
    foreach ($json[0]['faceAttributes']['emotion'] as $key => $value)
    {
        echo "$key : $value |";
        
    };



}

?>

