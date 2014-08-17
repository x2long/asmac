#!/usr/bin/php
<?php
/*********************************
 *
/**********************************/

$argv = $_SERVER['argv'];
if( count( $argv ) < 4 )
{
    die( "USAGE: dev_deploy [temp_dir] [build_dir] [package] \n
	    temp_dir used for build temp files,and build_dir is asmac web dir" );
}

$temp_build_path = "/home/webser/asmac_temp_build";
$release_path = "/home/webser/wwwroot/asmac";
$package_name = "/home/webser/wwwroot/asmac-master.zip";

$temp_build_path = $argv[1];
$release_path = $argv[2];
$package_name = $argv[3];

if( file_exists( "$temp_build_path" ) ){
    die( "The $temp_build_path already exist, do rm it.  Aborting dev deploy.\n" );
}

if( !file_exists( $package_name ) ){
    die( "The file $package_name dosn't exist. Aborting dev deploy.\n" );
}

echo "unzip to $temp_dir\n";
system( "unzip $package_name -d $temp_dir" );
echo "mv $temp_dir/asmac-master/* to $temp_dir\n";
system( "mv $temp_dir/asmac-master/* $temp_dir" );
echo "rm needless file or directory...\n";
system( "rm -r $temp_dir/asmac-master" );
system( "rm $package_name " );
// Merge the directories in turn by copying them into the build directory
echo "Copying temp to build...\n";
MergeIfExists( $temp_build_path, $release_path );


// Remove the temporary directory
// Sadly, this is the cleanest way in PHP to remove a directory and its children
system( "rm -rf $temp_build_path" );

// Done!
echo "\n\nComplete.\n $release_path is now ready for use.\n
    Before you use ,make sure infos below are right:\n
     -- $release_path/conf/db_config.php : db connection ;\n
     -- $release_path/protected/config/main.php : environment var ;\n
     -- $release_path/lib/activeRecord/* : db connection, directed in \n
     +----------------------------------------------------------------+\n
     | https://github.com/x2long/asmac/tree/master/lib/activeRecord   |\n
     +----------------------------------------------------------------+\n";

// Merges/overwrites files from one directory to another
function MergeIfExists( $from_dir, $to_dir )
{
    if( !is_dir( $from_dir ) )
    {
        die( "Unable to open directory to copy files: '$from_dir' is not a directory or does not exist.\n" );
    }

    $handle = opendir( $from_dir );

    if( $handle === false )
    {
        die( "Unable to open directory '$from_dir'.  Probably a permissions issue.\n" );
    }

    // Find the first non-./.. directory, copy that, then return.
    while( ( $name = readdir( $handle ) ) !== false )
    {
        if( $name != '.' && $name != '..' )
        {
            system( "rsync -a {$from_dir}/* {$to_dir}" );
            return true;
        }
    }

    echo "WARNING: '$from_dir' was empty.\n";
    return false;
}