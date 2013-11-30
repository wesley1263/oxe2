<?php
/**
 * File from config environment
 * @author webdesigner.ibc@gmail.com
 * @link http://www.andwes.com.br
 * */
 
################## PATHS FROM ALL APPLICATION #################
include('dbconfig.php');
define('B',DIRECTORY_SEPARATOR);
define('OXE_PATH',dirname(dirname(__FILE__)).B);


########## VENDOR PATH ############
define('VENDOR_PATH',OXE_PATH.B.'Vendor'.B);
define('CORE_PATH',VENDOR_PATH.B.'Core'.B);
define('HELPERS_PATH',VENDOR_PATH.B.'Helpers'.B);
define('LIBRARY_PATH',VENDOR_PATH.B.'Library'.B);

############ CONFIG PATH ############
define('CONFIG_PATH',OXE_PATH.B.'config'.B);


############# APPLICATION PATH #############
define('APPLICATION_PATH',OXE_PATH.B.'Application'.B);
define('CONTROLLER_PATH',APPLICATION_PATH.B.'Controllers'.B);
define('MODEL_PATH',APPLICATION_PATH.B.'Models'.B);
define('VIEW_PATH',APPLICATION_PATH.B.'Views'.B);


############### CONFIG DATABASE ####################
define('DBNAME',$dbconfig['DBNAME']);
define('DRIVER',$dbconfig['DRIVER']);
define('HOST',$dbconfig['HOST']);
define('USERNAME',$dbconfig['USERNAME']);
define('PASSWORD',$dbconfig['PASSWORD']);
define('CHARSET',$dbconfig['CHARSET']);
############### CONFIG DATABASE ####################