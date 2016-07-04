<?php
//Get Facebook Likes Count of a page
function fbLikeCount($id,$appid,$appsecret){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret.'&fields=fan_count';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json);

	//Extract the likes count from the JSON object
	if($json_output->fan_count){
	return	$likes = $json_output->fan_count;
	}else{
		return 0;
	}
}

function fbposts($id){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/v2.6/'.$id.'/posts?format=json&access_token=EAACEdEose0cBAGxokZCf24L45tWkEtDnsYgmWeinEN003vTUdxKAqMbO2xAPTSoZAtDuv4mcLfwxTZBlypXRw6KaLTp6Psb5WCL3swLv2RGODZB0qOIisLKWYDZBhGyv36UZALmeAiu6R4yKmEyUEFeZBc8jk10S5hVD5bQHdABgwZDZD&limit=5,';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    echo var_dump($json_output);
}

function fbpages(){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/search?q=iphone7&type=page&access_token=EAAWF1YwTzZBgBAD77Xc7lvtAzhYmDjZCZAZBU4XC1BFMXxJ0kymJ3oWZCr9gsb4ut5vfzKzCHEObiorWoZCfkVbJzApRKjhuMm67phEZCnJxZBKw4h7JauQMmZBcJPZBc8PgLyhvKl11bF2K5aD2qZC2bmdMyZBC35ZCodL4ZD&limit=2';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    for($i=0;$i<2;$i++){
    echo $json_output["data"][$i]["name"];
    echo $json_output["data"][$i]["id"];
    echo "\n";
}
    for($i=0;$i<2;$i++){
    echo ("Likes:      ".fbLikeCount($json_output["data"][$i]["id"],'1554527108190184','f6709c79756961aaf7b6dcb14fd6d71e')."\n");
}
for($i=0;$i<2;$i++){
    echo (fbposts($json_output["data"][$i]["id"])."\n");
}
}

fbpages();
//This Will return like count of CoffeeCupWeb Facebook page
?>