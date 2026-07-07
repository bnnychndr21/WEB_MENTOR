<?php try { new PDO("mysql:host=localhost;port=3306", "root", ""); echo "OK"; } catch (Exception $e) { echo $e->getMessage(); }
