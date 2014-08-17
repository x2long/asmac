#!/usr/bin/php
<?php
/*********************************
*
/**********************************/

// General Configuration
$repo = "https://github.com/x2long/asmac.git";
$download_url = "https://github.com/x2long/asmac/archive/master.zip";

// Verify commandline usage
$argv = $_SERVER['argv'];
if( count( $argv ) < 3 )
{
	die( "USAGE: dev_deploy [temp_dir] [build_dir] [use_git] \n
	    temp_dir used for build temp files,and build_dir is asmac web dir" );
}

$temp_build_path = "/home/webser/asmac_temp_build";
$release_path = "/home/webser/wwwroot/asmac";

$temp_build_path = $argv[1];
$release_path = $argv[2];

if( file_exists( "$temp_build_path" ) )
{
	die( "The user $temp_build_path already exist, do rm it.  Aborting dev deploy.\n" );
}

// Get the current revision number
$handle = popen( "git --version", "r" );
while( $line = fgets( $handle ) )
{
	if( preg_match( '/git version/', $line, $rev_matches ) )
	{
		$use_git = true ;
		break;
	}
}
pclose( $handle );

if( isset( $argv[3] ) && $argv[3]=='false' ){
        $use_git = false;
}

echo "Dowload code from git\n\n";
if( $use_git === true )
{
	echo "Now use git to clone source!\n\n";
	do_with_git($repo,$temp_build_path);
}else{
    echo "Now use wget to download codes!\n\n";
    do_with_wget($download_url,$temp_build_path);
}

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

function do_with_git($repo,$temp_dir){
    echo "Exporting asmac.git...\n";
    system( "git clone $repo $temp_dir" );
}

function do_with_wget($download_url,$temp_dir){
    echo "Exporting asmac.git...\n";
    /*echo "Creating '$temp_dir'\n";
    $status = mkdir( $temp_dir, 0777, true );
    if( $status !== true ){
        die( "Unable to create directory '$temp_dir'.  Probably a permissions issue.\n" );
    }*/
    system( "wget -P $temp_dir --quiet $download_url" );
    echo "mv to zip file\n";
    system( "mv $temp_dir/master $temp_dir/asmac_temp.zip" );
    echo "unzip to $temp_dir\n";
    system( "unzip $temp_dir/asmac_temp.zip -d $temp_dir" );
    echo "mv $temp_dir/asmac-master/* to $temp_dir\n";
    system( "mv $temp_dir/asmac-master/* $temp_dir" );
    echo "rm needless file or directory...\n";
    system( "rm -r $temp_dir/asmac-master" );
    system( "rm $temp_dir/asmac_temp.zip " );
}
