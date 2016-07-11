<?php
//Get Facebook Likes Count of a page
function fbLikeCount($id,$appid,$appsecret,$collection){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret.'&fields=fan_count';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json);

	//Extract the likes count from the JSON object
	if($json_output->fan_count){
		/*$likes=array("likes" => $json_output->fan_count);
		$collection->insert($likes);*/
	return	$likes = $json_output->fan_count;
	}else{
		return 0;
	}
}

function fbposts($id){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/v2.6/'.$id.'/posts?format=json&access_token=EAAWF1YwTzZBgBACom1a2jMlCTs8O2GyZBkW8DBUQXosqN4acqlR7VkB7XjJwZCb32CPLqHyXW5dxCNt9DeFBvsd7RTmcPf1KCKph9JvaXwtDsLKFSy3PZAVJ9CXFzatHHpZBPDqE2KZCZBsZAfhtbYlhwCiSzPb9LZBgZD&limit=5';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    for($i=0;$i<5;$i++){
	if($json_output["data"][$i]["story"]){
		echo $json_output["data"][$i]["story"]; }
		else 
			echo $json_output["data"][$i]["message"];
    echo $json_output["data"][$i]["created_time"];
    echo $json_output["data"][$i]["id"];
    echo "<br />";
	}
}

function fbpostswithcomments($id,$collection){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/v2.6/'.$id.'/posts?fields=comments&format=json&access_token=EAAWF1YwTzZBgBACom1a2jMlCTs8O2GyZBkW8DBUQXosqN4acqlR7VkB7XjJwZCb32CPLqHyXW5dxCNt9DeFBvsd7RTmcPf1KCKph9JvaXwtDsLKFSy3PZAVJ9CXFzatHHpZBPDqE2KZCZBsZAfhtbYlhwCiSzPb9LZBgZD';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
	$cnt1 = count($json_output["data"]);
	for($i=0;$i<$cnt1;$i++){
	echo $json_output["data"][$i]["id"]."<br /><br />";
	$cnt = count($json_output["data"][$i]["comments"]["data"]);
	for($j=0;$j<$cnt;$j++){
	echo $json_output["data"][$i]["comments"]["data"][$j]["message"]."<br />";
	echo $json_output["data"][$i]["comments"]["data"][$j]["from"]["name"]."<br />";
	$comments= array("comments" => $json_output["data"][$i]["comments"]["data"][$j]["message"]);
    $collection->insert($comments);
	}
	}
}

function fbpages($collection){
	//Construct a Facebook URL
	$json_url ='https://graph.facebook.com/search?q=iphone7&type=page&access_token=EAAWF1YwTzZBgBACom1a2jMlCTs8O2GyZBkW8DBUQXosqN4acqlR7VkB7XjJwZCb32CPLqHyXW5dxCNt9DeFBvsd7RTmcPf1KCKph9JvaXwtDsLKFSy3PZAVJ9CXFzatHHpZBPDqE2KZCZBsZAfhtbYlhwCiSzPb9LZBgZD&limit=25';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json, true);
    for($i=0;$i<25;$i++){
    echo $json_output["data"][$i]["name"];
    echo $json_output["data"][$i]["id"];
    echo "<br />";
	
	/*$info= array(
	"pagename" => $json_output["data"][$i]["name"],
	"fbid" => $json_output["data"][$i]["id"]
	);
    $collection->insert($info);*/
}
    for($i=0;$i<25;$i++){
    echo ("Likes: ".fbLikeCount($json_output["data"][$i]["id"],'1554527108190184','f6709c79756961aaf7b6dcb14fd6d71e',$collection)."\n");
}
for($i=0;$i<15;$i++){
    echo (fbpostswithcomments($json_output["data"][$i]["id"],$collection)."\n");
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