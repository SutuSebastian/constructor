<?php

// date + time now
$current_date_time = date("d M Y - g:i A" );

// fetch website settings and info
$website_result = $conn->query("SELECT * FROM website WHERE id = 1");
$website = $website_result->fetch_object();
$website_result->close();

define ("GET_PAGE", isset($_GET['page']) ? $_GET['page'] : null);
define ("USER_ID", isset($_SESSION['id']) ? $_SESSION['id'] : null);
define ("LOGGED_IN", isset($_SESSION['id']) ? true : false);

define ("WEBSITE_TITLE", $website->title);
define ("WEBSITE_DESCRIPTION", $website->description);
define ("WEBSITE_KEYWORDS", $website->keywords);
define ("WEBSITE_AUTHOR", $website->author);
define ("WEBSITE_ROBOTS", $website->robots);
define ("WEBSITE_FAVICON", $website->favicon);
define ("WEBSITE_MAINTENANCE", $website->maintenance);
define ("WEBSITE_DEFAULT_PAGE", $website->default_page);
define ("WEBSITE_GA_CODE", $website->ga_code);

// get user info if logged in
if (LOGGED_IN) {
    $user_info_result = $conn->query("SELECT * FROM users WHERE id=".USER_ID);
    $user_info = $user_info_result->fetch_object();
    $user_info_result->close();
    
    define ("USER_FULLNAME", $user_info->fullname);
    define ("USER_USERNAME", $user_info->username);
    define ("USER_EMAIL", $user_info->email);
    define ("USER_TYPE", $user_info->type);
}

?>
