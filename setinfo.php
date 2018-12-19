<!DOCTYPE html>
<html lang="en">
<head>
<!-- link to the css style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- link to the css style-->
<link	href="css/style.css"	media="screen"	rel="stylesheet"	type="text/css"/>
<!-- favicon is the small icon you see beside the title-->
<link rel="icon"  href="pictures/favicon/favicon-32x32.png" sizes="32x32" />
<link rel="icon"  href="pictures/favicon/favicon-16x16.png" sizes="16x16" />

<title> Lego Sets</title>
</head>
<body>
<?php

$item = $_GET['Partname'];

$connection	=	mysqli_connect("mysql.itn.liu.se","lego", "",	"lego");

					$result	= mysqli_query($connection, "SELECT inventory.Quantity, inventory.ItemTypeID, inventory.ItemID, inventory.SetID, parts.Partname FROM inventory, parts, colors WHERE 
					inventory.ItemTypeID='P' AND inventory.ItemID=parts.PartID AND parts.Partname LIKE '%$item%' LIMIT 100");

           	if(mysqli_num_rows($result) == 0) {
				print("<p>No parts in inventory for this set.</p>\n");
			}
			else {
				print("<table class =\"table\">\n");
				print ("<thead>\n");
				print ("<tr>\n");

				print("<th>Picture</th>\n");
				print("<th>Part name</th>\n");
				print("<th>Sets</th>\n");

				print ("</tr>\n");
				print ("</thead>\n");
				print("<tbody>\n");
				
			 while ($row =	mysqli_fetch_array($result))	
				{
				print("<tr>\n");
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

				print("<td>$Colorname</td>");
                
				$SetID = $row['SetID'];
				
				$Partname = $row['Partname'];
				print("<td>$Partname</td>\n");
				print("<td>$SetID</td>\n");
				print("</tr>");
				}
				print("</table>");
			}
?>
</body>
</html>