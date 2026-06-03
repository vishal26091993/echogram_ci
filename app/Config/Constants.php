<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH.'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR') || define('HOUR', 3600);
defined('DAY') || define('DAY', 86400);
defined('WEEK') || define('WEEK', 604800);
defined('MONTH') || define('MONTH', 2_592_000);
defined('YEAR') || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS') || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR') || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG') || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE') || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS') || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE') || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN') || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/*
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/*
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/*
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

// Firebase key
defined('FIREBASE_API_KEY') || define('FIREBASE_API_KEY', '');

// Custome Define

$root = 'http://'.$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$config['base_url'] = $root;

$imgroute = $config['base_url'];
$baseroute = $config['base_url'];
$imgrouteapp = $imgroute;

defined('IS_DELETE') || define('IS_DELETE', 0); // 0 = active, 1= Delete
defined('IS_DELETED') || define('IS_DELETED', 0); // 0 = active, 1= Delete
defined('isDelete') || define('isDelete', 0); // 0 = active, 1= Delete
defined('TEST_DATA') || define('TEST_DATA', 1); // 0 = Live, 1=Test
defined('CURRENT_DATE') || define('CURRENT_DATE', date('Y-m-d H:i:s')); // created date

// response code
defined('FAILD_CODE') || define('FAILD_CODE', 0); // Query failed to exicute
defined('SUCCESS_CODE') || define('SUCCESS_CODE', 1); // Query succesfully exicute
defined('EXIST_CODE') || define('EXIST_CODE', 2); // Record fields exist.
defined('FILE_UPLOAD_FAIL') || define('FILE_UPLOAD_FAIL', 3); // File Not Uploaded
defined('PENDING_VERIFY') || define('PENDING_VERIFY', 4); // Pending Busienss User Account
defined('REJECT_VERIFY') || define('REJECT_VERIFY', 5); // Reject Business User Account
defined('UNAUTH_CODE') || define('UNAUTH_CODE', 6); // Reject Business User Account

// response message
defined('SUCCESS_MSG') || define('SUCCESS_MSG', 'Saved successfully.'); // insert update success message
defined('UPDATE_MSG') || define('UPDATE_MSG', 'Records updated successfully.'); // update success message
defined('FAIL_MSG') || define('FAIL_MSG', 'Something went wrong. Please try again later.'); // insert update fail message
defined('FILE_UPLOAD_FAIL_MSG') || define('FILE_UPLOAD_FAIL_MSG', 'File Not Uploaded.'); // insert update fail message

// User role
defined('SUPER_ADMIN') || define('SUPER_ADMIN', 3); // Super Admin
defined('SUB_USER') || define('SUB_USER', 4); // Resturarnt Sub user
defined('ADMIN_SUB_USER') || define('ADMIN_SUB_USER', 6); // Super Admin Sub user

define('USER_UPLOAD_IMAGE', FCPATH.'uploads/user_profile/');

define('SITE_DOCUMENT_UPLOAD_IMAGE', FCPATH.'uploads/site_documents/');
// Image store paths
defined('SITE_DOCUMENT') || define('SITE_DOCUMENT', $imgrouteapp.'uploads/site_documents/'); // site document image

defined('USER_IMAGE') || define('USER_IMAGE', $imgrouteapp.'uploads/user_profile/'); // user image

defined('LABOUR_ATTEND') || define('LABOUR_ATTEND', $imgrouteapp.'uploads/labour_attendance/'); // user image

defined('PROFILE_IMAGE') || define('PROFILE_IMAGE', $imgrouteapp.'uploads/user_profile/'); // user image

defined('DOCUMENTS') || define('DOCUMENTS', $imgrouteapp.'upload/documents/'); // user image

defined('CATEGORY_IMAGE') || define('CATEGORY_IMAGE', $baseroute.'uploads/category_images/'); // View admin Category image
defined('CATEGORY_ICON_IMAGE') || define('CATEGORY_ICON_IMAGE', $baseroute.'uploads/category_icon_images/'); // View admin Category image
defined('PDF_PATH') || define('PDF_PATH', $baseroute.'uploads/contents/'); // View admin store image
defined('ASSET_URL') || define('ASSET_URL', $baseroute.'public/'); // View admin Category image

defined('EMAIL_LOGO') || define('EMAIL_LOGO', 'assets/images/logo.jpg'); // Upload admin category image

// resert password link
defined('RESET_PASSWORD') || define('RESET_PASSWORD', $baseroute.'password_change?fp_code='); // Upload admin category image

defined('SMTP_EMAIL_HOST') || define('SMTP_EMAIL_HOST', 'smtp.gmail.com');
defined('SMTP_EMAIL_USER') || define('SMTP_EMAIL_USER', '');
defined('SMTP_EMAIL_PASSWORD') || define('SMTP_EMAIL_PASSWORD', '');
