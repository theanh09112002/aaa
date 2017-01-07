<?php
set_time_limit(0); 
$token = ""; //token iphone get tại Autobotfb.com
$getID = json_decode(auto('https://graph.facebook.com/me?access_token='.$token.'&fields=id'),true);
$getpage = json_decode(auto('https://graph.facebook.com/'.$getID[id].'/conversations?fields=participants,unread_count&access_token='.$token),true);
for($i=0;$i<count($getpage[data]);$i++){
      if ($getpage[data][$i][unread_count] > 0) {
        //echo $getpage[data][$i][id];
        $getms = json_decode(auto('https://graph.facebook.com/'.$getpage[data][$i][id].'?fields=messages,message_count&access_token='.$token),true);
        $getnd = json_decode(auto('https://graph.facebook.com/'.$getms[messages][data][0][id].'?fields=message,from&access_token='.$token),true);
        //echo  $getnd[message];
        //echo $getnd[from][name];
        //echo $getnd[from][id];
        $traloi = StarSim($getnd[message]);
        if($getnd[from][id] !== $getID[id])
        auto('https://graph.fb.me/'.$getnd[from][id].'/inbox?access_token='.$token.'&message='.urlencode($traloi).'&method=post&subject=+'); 
      }
}
function StarSim($noidung){
$c = curl_init("http://autobotfb.com/api/sim.php?VTA=LOVE&NHI==$noidung");
// Key vô hạn nên các bạn dùng thoải mái nha.. khi nào web mình die thì thôi...:D. lấy api tại : Api.AuTobotFb.Com
curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$phanhoi = curl_exec($c);
curl_close($c);
if(strpos($phanhoi, '<head><title>400')===false)
$st = 1;
else $phanhoi = 'Hệ Thống Phản Hồi Đang Quá Tải';
return $phanhoi;
}

function auto($url){
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $url);
$ch = curl_exec($curl);
curl_close($curl);
return $ch;
}

?>