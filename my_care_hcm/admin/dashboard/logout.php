<?php

require "../../dbConfig/dbConfig.php";

session_destroy();
header("Location: /my_care_hcm/admin/index.php?error=You are not logged in");
exit();
