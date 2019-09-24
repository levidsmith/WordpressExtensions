Creating new site
Install new Wordpress site with twentyseventeen theme
Use GoDaddy's cPanel > Your building tools > Wordpress
cPanel will create a new MySQL database for the new Wordpress site
Use MySQL Databases to change the name to something more friendly
Also update the database user to something more friendly
Make according changes to database name and user in blog/wp-config.php

Use git to pull down twentyseventeen-child from GitHub
  # git clone https://github.com/gatechgrad/WordpressExtensions 
Make sure it puts the new theme in blog/wp-content/themes/twentyseventeen-child
Use Wordpress dashboard to change to twentyseventeen-child
  Appearance > Themes > Activate
This should enable the "Game" content type in the Wordpress dashboard

Export posts from old blog
  Tools > Export
Import into new blog ("Game" content type must be activated in child theme for game posts to successfully transfer)
  Tools > Import 
tar up images from old site
  # cd /blog/wp-content
  # tar -czvf blog_images.tar.gz uploads 
*Move tar to new site (using FTP program such as Filezilla) and extract
  # cd /blog/wp-content
  # tar -xzvf blog_images.tar.gz

Under Settings > General
  Make sure that WordPress Address is set to "http://<domain>/blog" and Site Address is set to "http://<domain>"

Change Settings > Reading in Wordpress dashboard to "Your homepage displays" = ""Your latest posts"
Set "Blog pages show at most to "3" posts
Press "Save Changes"

Remove any extra posts and media that were installed with Wordpress


Ensure that .htaccess is setup correctly
Move blog/index.php up to root folder and edit it according to:
https://codex.wordpress.org/Giving_WordPress_Its_Own_Directory


Under Appearance > Menu, select menu "New Main Menu"
Extra links and positions may need to be changed, if the importer was run multiple times.  Press "Save Menu" after deleting extra menu links
Change menu in Appearance > Customize
Select "New Main Menu", check "Top Menu", press "Publish"

Remove any extra widgets that were activated with the new Wordpress instance such as "Categories" and "Meta" from Appearance > Widgets


If pages don't display, make sure there is only one .htaccess file that is in the base directory, and that there aren't conflicting rewrite rules

Delete any extra About/Portfolio pages that were created by the new Wordpress instance

Copy Supporters widget and content text to new site



Cutover
in new Wordpress (levidsmith.org) set the URLs to levidsmith.com in Settings > General
On web hosting service:
??? Remove SSL cert (or rekey?) levidsmith.com
Change primary domain (used gitcommand.com)
In new cPanel, set primary to levidsmith.com
Go into SSL cert settings, and choose to rekey levidsmith.com (after it has been assigned to the new cPanel host)
Configure email (me@levidsmith.com) for new host

Install other Wordpress plugins (Disqus, Jetpack).  Wait a day or so before re-enabling Yoast and WP SuperCache, just in case anything needs to be debugged

Add back code (.htaccess rules?) to force the site to redirect http pages to https

Move directories (such as web-games and utilities) to new server.  Otherwise there will be infinite embed windoes when going to some pages 


Setup auto-redirect from http to https in .htaccess file
Change Settings > General URL to https

zip podcasts directory and move to server, and extract into public_html

Write script to change <wp:attachment_url> to use directory with images (uploads_migrate in my case).  Be sure to select "download and import file attachments"


In functions.php, update the following line to exclude tags from displaying on the front page (such as hiding podcasts)
    $q->set('tag__not_in', array(86)); 
