<?php 
session_start();
    if (!isset($_SESSION['x'])) {
        $_SESSION['x'] = 0;
    }
    include("databaseT.php");

    
    if($_POST['Pokemon'] != null){
    
    $pokemon = $_POST['Pokemon'] ;
    }
    else{
        echo ("<script>alert('no name input');</script>");
    }
    if($_POST['evolution']!=null){
        $evolution = $_POST['evolution'] ;
    }
    else{
       
        echo ("<script>alert('no eveolution stage input');</script>");
    }
    if($_POST['shinyColor']!=null){
        $shinyColor = $_POST['shinyColor'] ;
    }
    else{
        
     
        echo ("<script>alert('no shiny color given');</script>");
    }
    if($_POST['averageSize']!=null){
        $averageSize = $_POST['averageSize'] ;
    }
    else{
        echo ("<script>alert('no average size given');</script>");
     
    }
    if($_POST['type']!=null){
        $type = $_POST['type'] ;
    }
    else{
        echo ("<script>alert('no type given');</script>");
    
    }
    if($_POST['weakTo']!=null){
        $weakTo = $_POST['weakTo'] ;
    }
    else{
        echo ("<script>alert('no weakness given');</script>");
   
    }
    if($_POST['canEvolve'] != null){
        $canEvolve = $_POST['canEvolve'] ;
    }
    else{
        echo ("<script>alert('no evolution given');</script>");
    
    }
    if (isset($_FILES["fileup"])) {
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["fileup"]["name"]);
    
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    // Verify if the image file is an actual image or a fake image
   
    $check = getimagesize($_FILES["fileup"]["tmp_name"]);
    if ($check !== false) {
        echo "<li>File is an image of type - " . $check["mime"] . ".</li>";
        $uploadOk = 1;
    } else {
        echo "<li>File is not an image.</li>";
        $uploadOk = 0;
    }
    
    // Verify if file already exists
/*    if (file_exists($target_file)) {
        echo "<li>The file already exists.</li>";
        $uploadOk = 0;
    }*/
    
    // Verify the file size
    if ($_FILES["fileup"]["size"] > 5000000) {
        echo "<li>The file is too large.</li>";
        $uploadOk = 0;
    }
    
    // Verify certain file formats
    if ($uploadOk == 0) {
        echo "<li>The file was not uploaded.</li>";
    } else { // upload file
        $tempFile = $_FILES["fileup"]["tmp_name"];
    
        // Use a unique filename to avoid overwriting existing files
        $uniqueFileName = uniqid() . "_" . basename($_FILES["fileup"]["name"]);
    
        $destination = $target_dir . $uniqueFileName;
    
        if (move_uploaded_file($tempFile, $destination)) {
            echo "<li>The file " . basename($_FILES["fileup"]["name"]) . " has been uploaded.</li>";
    
            
            $img = $uniqueFileName;
        } else {
            echo "<li>Error uploading your file.</li>";
        }
    }
    
}
    if (!isset($img)) {
        $img = "mon.jpg";
        echo ("<script>alert('no image given, stock image being used');</script>");
    } 
   
    if($_POST['canEvolve'] != null && $_POST['weakTo'] != null&& $_POST['type'] != null&& $_POST['averageSize'] != null&& $_POST['shinyColor'] != null&& $_POST['evolution'] != null && $_POST['Pokemon'] != null){
    $stmt = $connection->prepare("SELECT * FROM Pokedex1 WHERE name = ?");
    $stmt->bind_param("s", $pokemon);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Name found in the database update
        $updateSql = "UPDATE `Pokedex1` SET `type`='$type', `ShinyColor`='$shinyColor', `stage`='$evolution', `CanEvolve`='$canEvolve', `size`='$averageSize', `weakTo`='$weakTo', `image`='$img' WHERE `name`='$pokemon'";
        mysqli_query($connection, $updateSql);

    } else {
        // Name not found in the database insert
            $sql = "INSERT INTO `Pokedex1` (`id`, `name`, `type`, `ShinyColor`, `stage`, `CanEvolve`, `size`, `weakTo`, `image`) 
            VALUES (NULL, '$pokemon', '$type', '$shinyColor', '$evolution', '$canEvolve', '$averageSize', '$weakTo', '$img')";
            mysqli_query($connection,$sql);
        
        }
    
    $stmt->close();
    $connection->close();

  

}

?>