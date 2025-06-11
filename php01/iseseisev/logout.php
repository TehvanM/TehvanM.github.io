<!-- Tehvan Marjapuu iseseisev -->


<?php
session_start();
session_destroy();
header("location:index.php");
exit;
?>