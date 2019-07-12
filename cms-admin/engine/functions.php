<?php

// notification handler
function notification_handler() {
    $type_of = array('error', 'warning', 'success');
    foreach($type_of as $type) {
        if(isset($_SESSION[$type])) {
            if(!is_array($_SESSION[$type])) $_SESSION[$type] = array($_SESSION[$type]);

            foreach($_SESSION[$type] as $message) {
                echo '
                    <div class="notification notification-' . $type . '">
                       <div class="notification_content">
                           <p class="notification_type">' . ucfirst($type) . '</p>
                           <p class="notification_message">' . $message . '</p>
                       </div>
                       <div class="notification_close">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                               <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                           </svg>
                       </div>
                    </div>
                ';

            }
            unset($_SESSION[$type]);
        }
    }
}

// check if user is allowed to make actions
function is_user_allowed() {
    global $conn;

    $user_result = $conn->query("SELECT type FROM users WHERE id =" .USER_ID);
    $user = $user_result->fetch_object();
    $user_result->close();

    if ($user->type == 1) {
        $_SESSION['warning'] = "You're not allowed to do this!";
        header('Location: '.$_SERVER['REQUEST_URI']);
        exit;
    }
}

// check if user is admin
function is_admin() {
    global $conn;

    $user_result = $conn->query("SELECT type FROM users WHERE id =" .USER_ID);
    $user = $user_result->fetch_object();
    $user_result->close();

    if ($user->type == 2) {
        return true;
    } else {
        return false;
    }
}

// get base href
function get_base_href () {
    $_SERVER['SCRIPT_NAME'] = preg_replace('/index.php/', '', $_SERVER['SCRIPT_NAME']);

    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "localhost") {
            echo "https://". $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        } else {
            echo "https://". $_SERVER['SERVER_NAME'] . "/cms-admin/";
        }
    } else {
        if ($_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "localhost") {
            echo "http://". $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        } else {
            echo "http://". $_SERVER['SERVER_NAME'] . "/cms-admin/";
        }
    }
}

// get title
function get_title () {
    if (!LOGGED_IN) {
        switch (GET_PAGE) {
            case 'password-recovery':
                $title = "Password Recovery - ". WEBSITE_TITLE;
            break;
            case 'create-new-password':
                $title = "Reset Password - ". WEBSITE_TITLE;
            break;
            default:
                $title = "Login - ". WEBSITE_TITLE;
            break;
        }
        echo $title;
        return;
    }

    switch (GET_PAGE) {
      case 'dashboard':
          $title = "Dashboard - ". WEBSITE_TITLE;
      break;
      case 'statistics':
          $title = "Statistics - ". WEBSITE_TITLE;
      break;
      case 'pages':
          $title = "Pages - ". WEBSITE_TITLE;
      break;
      case 'edit-page':
          $title = "Edit Page - ". WEBSITE_TITLE;
      break;
      case '404-edit':
          $title = "Edit 404 - ". WEBSITE_TITLE;
      break;
      case 'maintenance-edit':
          $title = "Edit Maintenance - ". WEBSITE_TITLE;
      break;
      case 'css-js-files':
          $title = "CSS & JS Files - ". WEBSITE_TITLE;
      break;
      case 'edit-file':
          $title = "Edit File - ". WEBSITE_TITLE;
      break;
      case 'media-files':
          $title = "Media Files - ". WEBSITE_TITLE;
      break;
      case 'header-edit':
          $title = "Edit Header - ". WEBSITE_TITLE;
      break;
      case 'footer-edit':
          $title = "Edit Footer - ". WEBSITE_TITLE;
      break;
      case 'link-resources':
          $title = "Link Resources - ". WEBSITE_TITLE;
      break;
      case 'website-settings':
          $title = "Website Settings - ". WEBSITE_TITLE;
      break;
      case 'user-settings':
          $title = "Users Profile - ". WEBSITE_TITLE;
      break;
      case 'edit-user':
          $title = "Edit User Profile - ". WEBSITE_TITLE;
      break;
      case 'global-variables':
          $title = "Global Variables - ". WEBSITE_TITLE;
      break;

      default:
          $title = "cPanel - ". WEBSITE_TITLE;
      break;
  }
  echo $title;
}

// filter file name
function filter_file_name($name) {
    $name = strtolower($name);
    $name = preg_replace("/[^a-z\s-]/", "", $name);
    $name = preg_replace("/[\s-]+/", " ", $name);
    $name = preg_replace("/[\s_]/", "-", $name);
    return $name;
}
// filter page title
function filter_page_title($title) {
    $title = preg_replace('/[^a-z0-9]+/i', ' ', $title);
    return $title;
}
// filter page url
function filter_page_url($url) {
    $url = strtolower($url);
    $url = preg_replace("/[^a-z0-9\s-]/", "", $url);
    $url = preg_replace("/[\s-]+/", " ", $url);
    $url = preg_replace("/[\s_]/", "-", $url);
    return $url;
}
// filter sanatize string
function sanatize ($string) {
    global $conn;
    return trim(filter_var($conn->real_escape_string($string), FILTER_SANITIZE_STRING));
}
// filter sanatize email
function sanatize_email ($email) {
    global $conn;
    return trim(filter_var($conn->real_escape_string($email), FILTER_VALIDATE_EMAIL));
}
// redirect to: $location
function redirect ($location) {
    header("location: ./$location");
    exit;
}
// redirect to HOST
function redirect_home () {
    header("location: //". $_SERVER['HTTP_HOST'] ."/cms-admin");
    exit;
}
function reload () {
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
}
// logout
function logout () {
    session_destroy();
    header('Location: ./');
    exit;
}

?>
