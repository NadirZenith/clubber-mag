=== ClubberMag ===
Theme Name: ClubberMag
Theme URI: http://www.clubber-mag.com
Author: http://www.clubber-mag.com
Author URI: http://www.clubber-mag.com
Description: clubber-mag theme
Version: 1.0
License URI: http://www.clubber-mag.com
Tags: electronic music, 
Text Domain: cm


//change post type names
UPDATE `wp_posts`
SET `post_type` = REPLACE(`post_type`,'old','new')
WHERE `post_type` LIKE '%old%'

//next
UPDATE `wp_posts`
SET `guid` = REPLACE(`guid`,'old','new')
WHERE `guid` LIKE '%old%'
