# ARETE Market WP site


TODO: development and deployment instructions

## Theme

The core functionality from this site is provided by the King Theme (https://kingthemes.net/).

Please note that the King Theme code (in `wp-content/themes/king` and `king-child`) has been extensively modified to include a new post of type 'arlem' or AR Learning Experience Model. Please do not apply any updates to the theme via the wordpress admin menu as this will overwrite any changes.

Modification of King includes:
- Removal of Lists, etc from admin menu


Does not include: 
- AMP support
- Styling
- Multiple template files
- NSFW mode for ARLEM

Modification of Wordpress core files includes:

## Hosting locally

Recommended: download MAMP https://www.mamp.info/en/downloads/ and copy the contents of this folder into the htdocs/wordpress/ folder. 

Data: the file `local.sql` contains a snapshot of the database with the correct settings for the theme, plus the admin user 'admin' (password admin).

## New users

Have to be "authors" to upload content.

# Admin Configuration Options

## Colours and styles

## Cookie text

Go to King -> Layout -> Notifications

## Flagging content

Admin Dashboard: Go to King -> Lists -> Flags. Here are the settings to enable flags for posts, comments, and hide posts after a certain number of flags. The current settings are "yes" to all, and to hide after one flag.

## Licensing Options

Admin Dashboard: Go to King -> Licences 