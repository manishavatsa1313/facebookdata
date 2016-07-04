<?php
//Get Facebook Likes Count of a page
function fbLikeCount($id,$appid,$appsecret,$collection){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret.'&fields=fan_count';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json);

	//Extract the likes count from the JSON object
	if($json_output->fan_count){
		$collection=array("likes" => $json_output->fan_count);
	return	$likes = $json_output->fan_count;
	}else{
		return 0;
	}
}

function fbposts($id){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/v2.6/'.$id.'/posts?format=json&access_token=EAAWF1YwTzZBgBAKUEyeYsynLUcNIZCkfw05Ft3dsf8abtzxS9DPvZBUCS8ByWeBB6LMgddpR6fyiEbrplb4RZAgxg0FZCte4ivJidbnQF6kC6PTVfPE5AoRFcIIBBRQTTlmHCvj3FT9DdOi2eZCKi013rSDgwM4QjfVlpxuQYfHAZDZD&limit=5';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    echo var_dump($json_output);
}

function fbpages($collection){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/search?q=iphone7&type=page&access_token=EAAWF1YwTzZBgBAKUEyeYsynLUcNIZCkfw05Ft3dsf8abtzxS9DPvZBUCS8ByWeBB6LMgddpR6fyiEbrplb4RZAgxg0FZCte4ivJidbnQF6kC6PTVfPE5AoRFcIIBBRQTTlmHCvj3FT9DdOi2eZCKi013rSDgwM4QjfVlpxuQYfHAZDZD&limit=25';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    for($i=0;$i<25;$i++){
    $pages= array("page name" => $json_output["data"][$i]["name"]);
    echo $json_output["data"][$i]["name"];
    $ids= array("id" => $json_output["data"][$i]["id"]);
    echo $json_output["data"][$i]["id"];
    echo "<br />";
    $collection->insert($pages);
    $collection->insert($ids);
}
    for($i=0;$i<25;$i++){
    echo ("Likes: ".fbLikeCount($json_output["data"][$i]["id"],'1554527108190184','f6709c79756961aaf7b6dcb14fd6d71e',$collection)."\n");
}
for($i=0;$i<2;$i++){
    echo (fbposts($json_output["data"][$i]["id"])."\n");
}
}

 $m = new MongoClient();
	
echo "Connection to database successfully <br />";

$db = $m->mydb;
	
echo "Database mydb selected <br />";

$collection = $db->createCollection("mycol");

echo "Collection created succsessfully <br />";

fbpages($collection);
//This Will return like count of CoffeeCupWeb Facebook page
?>