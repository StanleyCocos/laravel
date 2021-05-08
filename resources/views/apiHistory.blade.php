<!DOCTYPE html>
<html>
<head>
	<title>接口访问记录</title>
</head>
<script type="text/javascript">
		setTimeout(function(){
        setInterval(function(){
            window.location.reload();
        },1000)
    },2000);


	</script>

<body>
	<h2 style="text-align: center; background-color: #EEEEEE; height: 40px">100App接口访问记录</h2>
	<table width="1500" border="1" align="center" rules="all" cellpadding="5">
	<tr bgcolor='#ccc'>
		<th>接口名</th>
		<th>版本</th>
		<th>状态</th>
		<th>平台</th>
		<th>时间</th>
		<th>imei</th>
		<th>查看详情</th>
	</tr>



@foreach($list as $arr)
	<tr align="center">
		<td>{{$arr->api}}</td>
		<td>{{$arr->version}}</td>
		<td>{{$arr->state}}</td>
		<td>{{$arr->platform}}</td>
		<td>{{$arr->time}}</td>
		<td>{{$arr->imei}}</td>
		<td><a href="http://172.16.11.80/laravel/design100/public/apiHistoryDetail/{{$arr->id}}">查看详情</a></td>
	</tr>
@endforeach
</table>

<p>iphone-6-plus: b0ea7c92-e93c-4ca6-8fb7-c4d6987ce2d3</p>
<p>iphone-xr: 53070b48-aadd-42e4-bbaf-8c74267fb4e3</p>
<p>iphone6: 53070b48-aadd-42e4-bbaf-8c74267fb4e3</p>

</body>
</html>