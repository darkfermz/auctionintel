<html>
<head>
    <title>PHP Test</title>
</head>
    <body>
    <?php echo '<p>Hello World</p>';

    // In the variables section below, replace user and password with your own MySQL credentials as created on your server
    $servername = "auctionintel-1.cluster-cqbkigbfyv57.us-east-1.rds.amazonaws.com";
    $username = "AuctionIntel";
    $password = "!ljTAPJGh#2#f6yny5p6";

    // Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, 'AuctionIntel');

    // Check connection - if it fails, output will include the error message
    if (!$conn) {
        die('<p>Connection failed: <p>' . mysqli_connect_error());
    }
    echo '<p>Connected successfully</p>';
	
	if (mysqli_query($conn, $sql="INSERT INTO system_log SET content='Test'")) {
		echo "New record created successfully";
		$res=mysqli_query($conn, "SELECT COUNT(*) FROM system_log");
		print_r(mysqli_fetch_assoc($res));
		
		
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	
    ?>
</body>
</html>