<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if(isset($_GET['url'])) {
    $url = $_GET['url'];
    
    // cURL से DGDrive पेज का डेटा लाना
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    // HTML से डायरेक्ट डाउनलोड लिंक निकालना
    preg_match('/href="(https:\/\/[^"]+\.mp4)"/', $response, $matches);
    
    if(isset($matches[1])) {
        echo json_encode(["direct_link" => $matches[1]]);
    } else {
        echo json_encode(["error" => "Direct link not found!"]);
    }
} else {
    echo json_encode(["error" => "No URL provided"]);
}
?>
