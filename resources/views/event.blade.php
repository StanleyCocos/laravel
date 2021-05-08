<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>100事件统计</title>
	<script type="text/javascript">
		setTimeout(function(){
        setInterval(function(){
            window.location.reload();
        },1000)
    },2000);


	</script>
</head>
<body>
	<h2 style="text-align: center; background-color: #EEEEEE; height: 50px">100事件统计</h2>
	<table width="1000" border="1" align="center" rules="all" cellpadding="5">
	<tr bgcolor='#ccc'>
		<th>事件名</th>
		<th>版本</th>
		<th>平台</th>
		<th>时间</th>
		<th>imei</th>
	</tr>



@foreach($list as $arr)
	<tr align="center">
		<td>{{$arr->name}}</td>
		<td>{{$arr->version}}</td>
		<td>{{$arr->platform}}</td>
		<td>{{$arr->send_time}}</td>
		<td>{{$arr->imei}}</td>
	</tr>
@endforeach
</table>
</body>
</html>