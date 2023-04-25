<?php
 require 'includes/config.inc.php';

 if(isset($_POST["import"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
                $sql="INSERT INTO student (Student_id, Fname, Lname, Mob_no, Dept, Year_of_study, Pwd, Hostel_id, Room_id) 
                VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."', '', NULL, NULL)";

	             $result = mysqli_query($conn, $sql);
				if(!isset($result))
				{
					echo "<script type='text/javascript'>
							alert('Invalid File:Please Upload CSV File.');
							window.location = '/Hostel-Management-System-master/Hostel-Management-System-master/add_student_csv.php'
						  </script>";		
				}
				
	         }
			 echo "<script type='text/javascript'>
						alert('CSV File has been successfully Imported.');
						window.location = '/Hostel-Management-System-master/Hostel-Management-System-master/add_student_csv.php'
					</script>";

	         fclose($file);	
		 }
	}	 


 ?>