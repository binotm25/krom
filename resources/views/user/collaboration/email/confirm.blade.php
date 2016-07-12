<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
<meta charset=&quot;utf-8&quot;>
</head>
<body>
<h2>Hi {{ $receiver }}</h2>
<h4>Great News! You have received a collaboration request from <a href="http://kritish.com/krit/public/{{ md5(rand(9999,0000)).strrev($senderId)}}/profile">{{ $sender }}</a> for your creation named <b>"{{ $title }}"</b>.</h4>
<div>You have already started inspiring people around you :) </div>
<div>Go ahead, add more of your wonderful creations on Kritish.</div>
</body>
</html>