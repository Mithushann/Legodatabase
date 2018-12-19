<!DOCTYPE html>
<html lang="en"><!-- Makes it so it doesnt show the warning when validating-->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- link to the css style-->
<link	href="css/style.css"	media="screen"	rel="stylesheet"	type="text/css"/>
<!-- favicon is the small icon you see beside the title-->
<link rel="icon"  href="pictures/favicon/favicon-32x32.png" sizes="32x32" />
<link rel="icon"  href="pictures/favicon/favicon-16x16.png" sizes="16x16" />

<title> Lego Library </title>
</head>

<body>
<!-- Navigation code menu starts here--> 
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
    <a href="index.html">Home</a>
	<a href="About.html">About Us</a>
    <a href="result.php">Lego List</a>
  </div>
</div> <!-- Navigation code menu ends here-->

  <div class="container">
    <header>
	<!-- code for the menu button and the little three lines--> 
	  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span> 
		<form action="result.php" method ="get">
		<input type="text" name="searchkey">
		<input type="submit" value="Search">
		</form>
  </header>
  <!--Code for the table starts here-->

  
  <p>List of sets and parts</p>

  <?php
				// Connectioncheck funkar ej?
			$connection	=	mysqli_connect("mysql.itn.liu.se","lego", "",	"lego");
			if (mysqli_errno($connection)){
				die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n");
			}
			
			$search = $_GET['searchkey'];
			if ($search == NULL) {
					$result	= mysqli_query($connection, "SELECT inventory.Quantity, inventory.ItemTypeID, inventory.ItemID, inventory.SetID, 
					inventory.ColorID, colors.Colorname, parts.Partname FROM inventory, parts, colors WHERE 
					inventory.ItemTypeID='P' AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID LIMIT 100");
			}
			else{
			$result	= mysqli_query($connection, "SELECT inventory.Quantity, inventory.ItemTypeID, inventory.ItemID, inventory.SetID,
			inventory.ColorID, colors.Colorname, parts.Partname FROM inventory, parts, colors WHERE 
			inventory.ItemTypeID='P' AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID AND parts.Partname LIKE '%$search%' LIMIT 100");
			}
			
			if(mysqli_num_rows($result) == 0) {
				print("<p>No parts in inventory for this set.</p>\n");
			}
else {
				print("<table class =\"table\">\n");
				print ("<thead>");
				print ("<tr>");
				print("<th>Quantity</th>");
				print("<th>File name</th>");
				print("<th>Picture</th>");
				print("<th>Color</th>");
				print("<th>Part name</th>");
				print ("</tr>\n");
				print ("</thead>");
				print("<tbody>\n");
				
				
				while ($row =	mysqli_fetch_array($result))	
				{
				print("<tr>");
				$Quantity = $row['Quantity'];
				print("<td>$Quantity</td>");
				
				$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
				$ItemID = $row['ItemID'];
				$ColorID = $row['ColorID'];
				$imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID=$ColorID");
				$imageinfo = mysqli_fetch_array($imagesearch);
				
				if ($imageinfo['has_jpg']){
					$filename = "P/$ColorID/$ItemID.jpg";
				}
				else if($imageinfo['has_gif']){
					$filename = "P/$ColorID/$ItemID.gif";
				}
				else {
					$filename = "noimage_small.png";
				}
				print("<td>$filename</td>\n");
				$Partname = $row['Partname'];
				print("<td><a href=\"setinfo.php?Partname=$Partname\"><img src=\"$prefix$filename\" alt=\"Part $ItemID\"/> </a></td>");
				$Colorname = $row['Colorname'];
				
				print("<td>$Colorname</td>");
				print("<td>$Partname</td>");
				}
				print("</table>\n");

		}
  ?>
 <!--Code for the table starts here-->
</div>
<!-- code for the opening and closing of the menu button-->

 <script src="js/Javascript.js"></script>
</body>
</html>

<!--links-->

<!-- slide show link-->
<!-- https://codepen.io/NikitaSLF/pen/mPGpPY-->
