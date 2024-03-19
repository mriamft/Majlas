<?php
session_start();
session_unset();
session_destroy();

echo '<script>window.location.href = "index.html";</script>';
exit;//to ensure stopping the execution of this script
?>