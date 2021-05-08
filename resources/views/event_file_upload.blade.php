<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<h1>请上传事件文件</h1>
<form action="/upload" method="post" enctype="multipart/form-data">
	@csrf
    <p><input type="file" name="upload"></p>
    <p><input type="submit" value="submit"></p>
</form>

</body>
</html>