<?php
define('ABSPATH', '/var/www/app' );
define('PAGETITLE', 'Php-Syslog-NG' );
define('VERSION', '2.9.9');
define('COUNT_ROWS', TRUE);
define('DEFAULTLOGTABLE', 'logs');
define('MERGELOGTABLE', 'all_logs');
define('USETABLE', DEFAULTLOGTABLE); // This tells the main page to calculate hostcount based on "all_logs" or "logs"
define('LOGROTATERETENTION', 30);
define('DBUSER', $_ENV['SQL_USER']);
define('DBUSERPW', $_ENV['SQL_PASSWORD']);
define('DBADMIN', $_ENV['SQL_ADMIN_USER']);
define('DBADMINPW', $_ENV['SQL_ADMIN_PASSWORD']);
define('DBNAME', $_ENV['SQL_DATABASE']);
define('DBHOST', $ENV_['SQL_HOST']);
define('DBPORT', '3306');
define('REQUIRE_AUTH', TRUE);
define('AUTHTABLENAME', 'users');
define('RENEW_SESSION_ON_EACH_PAGE', TRUE);
define('SESSION_EXP_TIME', '3600');
define('TAIL_REFRESH_SECONDS', '25');
define('USE_ACL', TRUE);
define('USER_ACCESS_TABLE', 'user_access');
define('ACTION_TABLE', 'actions');
define('USE_CACHE', TRUE);
define('CACHETABLENAME', 'search_cache');
define('SITEADMIN', 'admin');
define('SITENAME', 'syslog.moon');
define('ADMINEMAIL', 'none@nowhere.com');
define('CEMDB', 'ON');
define('CISCO_TAG_PARSE', TRUE);
define('CISCO_ERROR_TABLE', 'cemdb');
define('DEBUG', TRUE);
define('SITEURL', '/');
$regExpArray = array(
                        // "username"=>"(^\w{4,}\$)",
                        // Cdukes - 05/10/08: Modified username to allow email address as username
                        // This is an enhancement change for
                        // http://code.google.com/p/php-syslog-ng/issues/detail?id=62
                        "username" => "(^[A-Za-z_.@]{4,}\$)",
                        "password"=>"(^.{4,}\$)",
                        "pageId"=>"(^\w+$)",
                        "sessionId"=>"(^\w{32}\$)",
                        // "date"=>"/^yesterday$|^today$|^now$|^(\d){4}-([01]*\d)-([0123]*\d)$/i",
                        "date"=>"/^yesterday$|^today$|^now$|^([0123]*\d)-([012]*\d)-(\d){4}$/i",
                        "time"=>"/^now$|^([012]*\d):([012345]*\d):([012345]*\d)$/i",
                        "limit"=>"(^\d+$)",
                        "topx"=>"(^\d+$)",
                        // BPK added program to orderby filter
                        "orderby"=>"/^id$|^seq$|^counter|^host$|^program$|^facility$|^priority$|^msg$|^fo$|^lo$|^counter$/i",
                        "order"=>"/^asc$|^desc$/i",
                        "offset"=>"(^\d+$)",
                        "collapse"=>"/^1$/",
                        "table"=>"(^\w+$)",
                        "excludeX"=>"(^[01]$)",
                        /* BEGIN: changes by BPK to allow for regexp matching, lists of hosts, and programs
                        "host"=>"(^[\w-.]+$)",
                        */
                        "regexpX"=>"(^[01]$)",
                        "host"=>"(^([\w_.%-]+[,;]\s*)*[\w_.%-]+$)",
                        "program"=>"(^([\w/_.%-]+[,;]\s*)*[\w/_.%-]+$)",
                        "hostRegExp"=>"(^\S+$)",
                        "programRegExp"=>"(^\S+$)",
                        /* END: changes by BPK to allow for regexp matching, lists of hosts, and programs */
                        "facility"=>"(^\w+$)",
                        "priority"=>"/^debug$|^info$|^notice$|^warning$|^err$|^crit$|^alert$|^emerg$/i",
                        // Cdukes - 05/10/08: Below is an enhancement addition for SqueezeDB duplicate searching
                        "dupop"=>"(^lt|gt|eq$)",
                        "dupcount"=>"(^\d+$)",
                        // Cdukes - 05/07/09: Below is an enhancement addition for graph types
                        "graphtype"=>"/^tophosts$|^topmsgs$|^pri$|^fac$|^prog$/i",
                        );
//------------------------------------------------------------------------
// CDUKES - BEGIN jpgraph Addon
//------------------------------------------------------------------------

// Enable Graphing
define('JPG_GRAPHS', 'ON');
// Make sure this directory exists and has write permission
define('IMG_CACHE_DIR', 'jpcache/');

// Enable Daily Graph in dropdown on main page
define('JPG_DAILY', 'ON');
// Enable Weekly Graph in dropdown on main page
define('JPG_WEEKLY', 'ON');
// Enable Monthly Graph in dropdown on main page
define('JPG_MONTHLY', 'ON');
// Enable Overall Statistics Graph on main page (This will slow down main page rendering)
define('JPG_MAIN', 'OFF'); // Not implemented yet


//------------------------------------------------------------------------
// CDUKES - END jpgraph Addon
//------------------------------------------------------------------------
//------------------------------------------------------------------------
// CDUKES - Begin LDAP Addon
//------------------------------------------------------------------------
define('LOGIN_URL', SITEURL . "login.php");
define('LOGOUT_URL', SITEURL . "logout.php");
define('INDEX_URL', SITEURL . "index.php");
define('LDAP_ENABLE', "NO");
define('LDAP_SRV', "ldap.company.com");
define('LDAP_BASE_DN', "ou=active, ou=employees, ou=people, o=company.com");
// variable to search for user (container name) - in my case, this is "uid", but normally it is "cn"
define('LDAP_CN', "uid");
// if using MS Active Directory, put it to "sAMAccountName"
// define('LDAP_CN', "sAMAccountName");
// Set to Yes if using MS Active Directory for Authentication
define('LDAP_MSAD', "NO");
// Required when if LDAP_MSAD set to YES and using MS Active Directory, ex. mydomain.com
define('LDAP_DOMAIN', "mydomain.com");

// privilege levels for editing records
// (not implemented yet - this will be used to define RW and RO groups from LDAP)
// use privilege level authentication for record editing?
define  ('LDAP_USEPRIV', 'OFF');
// if USEPRIV is enabled, what LDAP group name is the "privileged" group?
define  ('LDAP_RW_GROUP', 'admin');
define  ('LDAP_RO_GROUP', 'users');
//------------------------------------------------------------------------
// CDUKES - END LDAP Addon
//------------------------------------------------------------------------

//------------------------------------------------------------------------
// cdukes - I added this just in case someone felt generous
// If you don't want it on the menu bar, just disable it here :-)
//------------------------------------------------------------------------
define  ('PAYPAL_ENABLE', 'YES');
//------------------------------------------------------------------------
// CDUKES - Just a simple addition for my demo site at http://php-syslog-ng.gdd.net
//------------------------------------------------------------------------
define  ('DEMO', FALSE);
// Cdukes - 05/10/08: WEBBASIC_ENABLE
// This is an enhancement change for
// http://code.google.com/p/php-syslog-ng/issues/detail?id=62
define('WEBBASIC_ENABLE', FALSE);
//------------------------------------------------------------------------
// CDUKES - Added front page bar graph for daily log count
//------------------------------------------------------------------------
define('GRAPH_LPD', TRUE);
define('LPD_CACHE', TRUE);

//------------------------------------------------------------------------
// CDUKES - Working on a MEMCACHED version
//------------------------------------------------------------------------
define('MEMCACHED', FALSE);

//------------------------------------------------------------------------
// CDUKES - Syslog2Mysql.pl Script variables
//------------------------------------------------------------------------
// As of v2.9.9 we will stop using the php version of Squeeze and will now use the perl version (syslog2mysql.pl)
define('SQZ_ENABLED', FALSE);
// Added LOG_PATH to set log destination for syslog2mysql.pl script (do not include trailing /)
define('LOG_PATH', '/var/log/logzilla');
// Added below to do sql batch inserts from perl script (*much* faster than inserting individual rows)
define('SQL_BULK_INS', '100');
// Added below for scripts/syslog2mysql.pl to allow for data deduplication based on time
// The script will deduplicate data based on now minus X seconds (default 300)
define('SQZ_TIME', '300');
// Set the Squeeze Distance
// the higher the number, the more likely rows will match
define('SQZ_DIST', '5');

//------------------------------------------------------------------------
// Added to allow filtering of individual message pieces in search results
//------------------------------------------------------------------------
define('MSG_EXPLODE', TRUE);
//------------------------------------------------------------------------
// CDUKES - Added for Excel Exporting
//------------------------------------------------------------------------
// Set Colors for Web Interface and Excel Reports
define('HEADER_COLOR', '96AED2');
define('DARK_COLOR', 'C0C0C0');
define('LIGHT_COLOR', 'E0E0E0');
//------------------------------------------------------------------------
// CDUKES - Added to filter off SEQ field from display - it's being deprecated since not all systems use it
//------------------------------------------------------------------------
define('SEQ', FALSE);

?>

