<?php
// A file for just one thing - unlog;
session_start();
session_unset();
session_destroy();