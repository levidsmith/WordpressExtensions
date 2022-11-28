SOURCE_DIR=~/public_html/blog/wp-content
rm -rf wp-content/themes
mkdir -p wp-content/themes
cp -R $SOURCE_DIR/themes/twentyseventeen-child wp-content/themes

rm -rf wp-content/plugins
mkdir -p wp-content/plugins
cp -R $SOURCE_DIR/plugins/levidsmith-gameindex wp-content/plugins


SOURCE_DIR=~/public_html/scores
rm -rf scores
cp -R $SOURCE_DIR . 
