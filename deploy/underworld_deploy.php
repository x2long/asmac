#!/usr/bin/php
<?php
/*********************************
/* xwars all-in-one development deploy script
/* 
/* USAGE: dev_deploy [username] [gamename] [build number]
/*
/* This script will build an xwars application from the current source, 
/* then distribute it to all of the relevant app servers for that game.
/*
/**********************************/

// General Configuration
//$repo = "https://69.164.199.119/fnx/repo1/trunk/game";
$repo = "https://svn-pa.castleagegame.com/fnx/repo1/underworld/branches/localization/server";

$extjsarchive="/data/ext-4.1.1a-gpl.zip";
$extjsdir="ext-4.1.1a";

// Verify commandline usage
$argv = $_SERVER['argv'];
if( count( $argv ) < 3 )
{
	die( "USAGE: dev_deploy [username] [gamename] [use_graphics] [build number]\n" );
}

$player_name = $argv[1];
$game_name = $argv[2];

$use_graphics = true;
$build_number = false;

if( isset( $argv[3] ) && $argv[3]=='false' )
{
        $use_graphics = false;
}


if( isset( $argv[4] ) )
{
	$build_number = $argv[4];
}

$app_names = GetAppNames();

echo "\n";	// To make later output easier to distinguish


// Verify valid options
if( !in_array( $game_name, $app_names ) )
{
	$err = "Invalid app name - you probably mistyped the game name: $game_name.\nAvailable names:\n";
	foreach( $app_names as $key )
	{
		$err .= "  $key\n";
	}
	$err .= "\n";
	die( $err );
}

if( $build_number !== false && !is_numeric( $build_number ) )
{
	die( "We'll need the numeric build number you want to build.\n" );
}

if( !file_exists( "/home/$player_name/" ) )
{
	die( "The user $player_name does not have a home directory, it seems.  Aborting dev deploy.\n" );
}

// Get the current revision number
$handle = popen( "svn info $repo", "r" );
while( $line = fgets( $handle ) )
{
	if( preg_match( '/Revision: (\d+)/', $line, $rev_matches ) )
	{
		$rev = (int)$rev_matches[1];
		if( $rev <= 0 )
		{
			die( "Unable to retrieve the current build number from SVN.\n" );
		}
		break;
	}
}
pclose( $handle );

if( $build_number === false )
{
	echo "No build number given.  Defaulting to the most current ( $rev ).\n\n";
	$build_number = $rev;
}

// Configure our paths, etc.
$graphics_path = "/home/$player_name/graphics_$game_name";
$release_path = "/home/$player_name/builds/$game_name";

// Remove the current build
// Check for a valid override file
$override_path = "/home/$player_name/overrides/override_$game_name.php";
if( !file_exists( $override_path ) )
{
	die( "Cannot proceed with build - local dev override file '$override_path' doesn't exist.\n" );
}

if( file_exists( $release_path ) )
{
	echo "Now deleting existing build for $game_name...\n";
	// Sadly, this is the cleanest way in PHP to remove a directory and its children
	system( "rm -rf $release_path" );
}

echo "Now creating build for $build_number in '$release_path'\n\n";
$temp_build_path = "/home/$player_name/temp_build/";

// Remove the temp directory if it already exists
if( file_exists( $temp_build_path ) )
{
	echo "Now deleting temporary build directory at $temp_build_path...\n";
	// Sadly, this is the cleanest way in PHP to remove a directory and its children
	system( "rm -rf $temp_build_path" );
}

//$build_path = "$release_path/builds/$game_name";
$build_path = "$release_path/view";

// Create the final build path
echo "Creating '$build_path'\n";
$status = mkdir( $build_path, 0777, true );
if( $status !== true )
{
	die( "Unable to create directory '$build_path'.  Probably a permissions issue.\n" );
}

// Create the temporary build path
echo "Creating '$temp_build_path'\n";
$status = mkdir( $temp_build_path, 0777, true );
if( $status !== true )
{
	die( "Unable to create directory '$temp_build_path'.  Probably a permissions issue.\n" );
}

// Non-merging directories can be exported directly to the destination path
echo "Exporting plat...\n";
system( "svn -r $build_number --quiet export $repo/plat $release_path/plat" );
echo "Exporting util...\n";
system( "svn -r $build_number --quiet export $repo/util $release_path/util" );
echo "Exporting locale...\n";
system( "svn -r $build_number --quiet export $repo/locale $release_path/locale" );
echo "Exporting adm...\n";
system( "svn -r $build_number --quiet export $repo/adm $release_path/adm" );
system( "unzip $extjsarchive -d $release_path/adm" );
system( "cd $release_path/adm ; ln -s $extjsdir extjs" );
echo "Exporting pstats...\n";
system( "svn -r $build_number --quiet export $repo/pstats $release_path/pstats" );
echo "Exporting cron_scripts...\n";
system( "svn -r $build_number --quiet export $repo/cron_scripts $release_path/cron_scripts" );
echo "Exporting class...\n";
system( "svn -r $build_number --quiet export $repo/apps/$game_name"."_class $release_path/class" );

// Merging directories need to go to the temporary directory first
echo "Exporting apps/base to temp...\n";
system( "svn -r $build_number --quiet export $repo/apps/base $temp_build_path/apps/base" );
echo "Exporting apps/$game_name"."_view to temp...\n";
system( "svn -r $build_number --quiet export $repo/apps/$game_name"."_view $temp_build_path/apps/$game_name"."_view" );

if ($use_graphics) {
	if( file_exists( $graphics_path ) )
	{
	        echo "Now deleting temporary build directory at $graphics_path...\n";
	        // Sadly, this is the cleanest way in PHP to remove a directory and its children
	        system( "rm -rf $graphics_path" );
	}


	echo "Exporting apps/$game_name"."_view_graphics to temp...\n";
	system( "svn -r $build_number --quiet export $repo/apps/$game_name"."_view_graphics/graphics $graphics_path" );
}

// Merge the directories in turn by copying them into the build directory
echo "Copying base to build...\n";
MergeIfExists( "$temp_build_path/apps/base", $build_path );

echo "Merging game to build...\n";
MergeIfExists( "$temp_build_path/apps/$game_name"."_view", $build_path );

//echo "Merging graphics to build...\n";
//MergeIfExists( "$temp_build_path/apps/$game_name"."_view_graphics", $build_path );

//echo "Merging social network to build...\n";
//MergeIfExists( "$temp_build_path/apps/$game_name"."_class", $build_path );

// Create the symlink for the build number pseudopath

system( "ln -s $build_path $build_path/$build_number" );
system( "ln -s $graphics_path $build_path/$build_number/graphics");

// Copy the appropriate override file in
system( "cp /home/$player_name/overrides/override_$game_name.php $release_path/class/conf/test_config.php" );

// Create the build number include file
$build_number_inc = fopen( "$release_path/class/conf/version", 'w' );
if( $build_number_inc === false )
{
	die( "Unable to open build number include file '$build_path/version' for writing.  Probably a permissions issue.\n" );
}

$build_number_file_contents = '<? global $version_number; $version_number = ' . $build_number . '; ?>';

fwrite( $build_number_inc, $build_number_file_contents );

fclose( $build_number_inc );

// Remove the temporary directory
// Sadly, this is the cleanest way in PHP to remove a directory and its children
system( "rm -rf $temp_build_path" );

// Done!
echo "\n\nComplete.\n$player_name's copy of $game_name ( build $build_number ) is now ready for use.\n\n";


///////////////////Functions/////////////////////

// Returns a list of game/app names
// NOTE: THIS FUNCTION MUST BE KEPT UP TO DATE WITH THE GAME LIST
function GetAppNames()
{
	$app_names = array(
			"underworld",
		);

	return $app_names;
}

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
