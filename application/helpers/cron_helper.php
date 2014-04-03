<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a helper that is going to check if the MP3 deletions cron exists
 * If it doesn't exist, it is going to create the required cron job to run
 * every 5 minutes and do it's work. Yay!
 */
/** Get CI Instance */
$_this =& get_instance();

/** Check if the crontab exists */
$ct = exec('crontab -l'); //Get the cron
if(strpos($ct,'#_zong_cron')===FALSE): //Check if our cron job exists
    //Our cron job doesn't exist. Create it
    $bp = explode('/system',BASEPATH);
    $ct .= '* * * * * php '.$bp[0].'/cron.php /crons/index #_zong_cron'.PHP_EOL;
    //Edit the crontab and add the current created crontab
    file_put_contents('.crontab',$ct);
    //Execute crontab
    exec('crontab .crontab');
    log_message('info','New crontab created. Added cron job to /cron/index every 5 mins.');
else:
    //Our cron job exist. Skip
    log_message('info','Cron job already exists');
endif;