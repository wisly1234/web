
<html>
<head>
    <title>威武霸气123,我的死亡留言</title>
    <META http-equiv=Content-Language content=zh-cn>
    <META http-equiv=Content-Type content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="src/css/death.css">
</head>
<body>


	<form action="death.php" method="post">
	Name: <input type="text" name="name" id="name" value="wisly"> <br>
	message:<input type="text" name="message" id="message" value="nothing"><br>
	<input type="submit" value = "提交">
	</form>



	<?php 
		if ($_POST["name"])
		{
			$con=mysqli_connect("123.254.109.44","a1120113155","54785695","a1120113155");
			//Check connection
			if (mysqli_connect_errno())
			  {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  return;
			  }

			 $result = mysqli_query($con,"SELECT * FROM wisly");

			while($row = mysqli_fetch_array($result))
			  {
			  echo $row['id'] . " " . $row['name'];
			  echo "<br>";
			  }
		} 
	?>

</body>


</html>
