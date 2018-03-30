<?php 

require 'db.php';
require 'shaper_talk_crud.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>LeBran - Shaper Talks</title>
</head>

<body>

<h2> Add Shaper Talk </h2>    

   <form action="admin_shaper_talk_add.php" method="post" autocomplete="off">
        
    <div class="field-wrap">
        <label> Account:  <span class="req"></span> </label>
                    <input type="text" required name="talk_account" >
    </div>
    <br>
    <div class="field-wrap">
        <label> Topic:  <span class="req"></span> </label>
                <input type="text" autocomplete="off" name='talk_topic' />
    </div>
    <br>
    <div class="field-wrap">
        <label> Speaker:  <span class="req"></span> </label>
                <input type="text" autocomplete="off" name='talk_speaker' />
    </div>
    <br>

    <div class="field-wrap">      
        <label> Fee:  <span class="req"></span> </label>
                <input type="number" required autocomplete="off" id= "talk_fee" name='talk_fee' value = '1'/>
    </div>
    <br>
     
    <button type="submit" class="button" id = "submitNewShaperTalk" name="submitNewShaperTalk" />Save</button>
          
    </form>

  
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="js/index.js"></script>

</body>
</html>
