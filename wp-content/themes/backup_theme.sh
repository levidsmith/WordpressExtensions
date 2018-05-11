FILENAME="backups/twentyseventeen-child-"$(date +"%Y%m%d")".tar.gz"
echo $FILENAME
tar -cvzf $FILENAME twentyseventeen-child
