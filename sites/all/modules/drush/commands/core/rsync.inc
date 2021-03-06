<?php
// $Id: rsync.inc,v 1.11 2010/02/23 18:10:36 greg1anderson Exp $

/**
 * Entrypoint for drush rsync.
 *
 * If --all-paths is specified, and 'source' and 'destination'
 * are alias names without a path component, then this function will
 * call _drush_core_sync for every path in the source and destination
 * alias that exist in both aliases.  Otherwise, _drush_core_sync
 * will be called once, and 'source' and 'destination' will be
 * interpreted as either alias names or 'machine:/path' specifications.
 *
 * TODO:  This function, when called with --all-paths, will call _drush_core_sync
 * repeatedly, which will prompt for a y/n confirmation for every path (unless
 * 'drush -y' is used).  It would be better if it could prompt just once, but if
 * we did that, then the prompt should contain all of the paths that are going to
 * be copied.
 */
function drush_core_rsync($source, $destination) {
  $sync_all_paths = drush_get_option('all-paths');

  // TODO:  this implementation of --all-paths does not work well
  // with multiple sync targets; needs rewriting
  if ((isset($sync_all_paths)) && (strpos($source, ':') === FALSE) && (strpos($destination, ':') === FALSE)) {
    $source_settings = drush_sitealias_get_record($source);
    $destination_settings = drush_sitealias_get_record($destination);

    // If the source and destination paths are both aliases that contain
    // no path component (that is, 'alias', not 'alias:/path'), then we will
    // iterate over all of the path aliases of both, and sync all that are
    // in common to both alias records.
    if ((!empty($source_settings)) && (!empty($destination_settings)) && array_key_exists('path-aliases',$source_settings) && array_key_exists('path-aliases', $destination_settings)) {
      $source_path_aliases = $source_settings['path-aliases'];
      $destination_path_aliases = $destination_settings['path-aliases'];
      $source_root = $source_settings['root'];
      $destination_root = $destination_settings['root'];
      // First call drush sync to rsync the source and destination paths as provided
      $result = _drush_core_sync($source, $destination, array('exclude-sites' => TRUE));
      // After sync-ing with 'exclude-sites', go back and sync the
      // site directory for this installation.
      if ($result !== FALSE) {
        $result = _drush_core_sync($source . ':sites/' . $source_settings['uri'] . '/', $destination . ':sites/' . $destination_settings['uri'] . '/');
      }
      // Iterate over all of the other path aliases
      foreach ($source_path_aliases as $key => $value) {
        // Sync this entry if it exists in both the source and the
        // destination path aliases, unless its value is a path that 
        // is somewhere inside of the root, which we already rsync'ed 
        // at the top of this function.
        if (($result !== FALSE) && (strncmp($source_root, $value, strlen($value)) != 0) && array_key_exists($key, $destination_path_aliases)) {
          $result = _drush_core_sync($source . ':' . $key, $destination . ':' . $key);
        }
      }
    }
  }
  // If we didn't do a special-case rsync (alias-to-alias),
  // then call sync with the original parameters here
  if (!isset($result)) {
    $result = _drush_core_sync($source, $destination);
  }
}

/**
 * Push files from or to the local Drupal install using SSH and RSync
 *
 * @return void
 **/
function _drush_core_sync($source, $destination, $parametric_options = array()) {
  // evaluate file paths
  $source_settings = _drush_core_evaluate_path($source);
  $destination_settings = _drush_core_evaluate_path($destination);
  $source_path = $source_settings['rsync-path'];
  $destination_path = $destination_settings['rsync-path'];

  // Check to see if this is an rsync multiple command (multiple sources and multiple destinations)
  $is_multiple = drush_do_multiple_command('rsync', $source_settings, $destination_settings, TRUE);

  if ($is_multiple === FALSE) {
    // Prompt for confirmation. This is destructive.
    if (!drush_get_context('DRUSH_SIMULATE')) {
      drush_print(dt("You will destroy data from !target and replace with data from !source", array('!source' => $source_path, '!target' => $destination_path)));
      if (!drush_confirm(dt('Do you really want to continue?'))) {
        // was: return drush_set_error('CORE_SYNC_ABORT', 'Aborting.');
        drush_die('Aborting.');
      }
    }

    drush_core_call_rsync($source_path, $destination_path, $parametric_options);
  }
}

function drush_core_call_rsync($source, $destination, $parametric_options = array()) {
  // Merge the options specified by the caller with the options specified on the command line.
  $all_specified_options = array_merge(drush_get_merged_options(), $parametric_options);
  $options = ' --exclude="*.svn*"';
  $mode = '-az';
  // 'exclude-conf' is the default
  if (!array_key_exists('include-conf', $all_specified_options)) {
    $options .= ' --exclude="settings.php" --exclude="robots.txt" --exclude=".htaccess"';
  }
  if (array_key_exists('exclude-sites', $all_specified_options)) {
    $options .= ' --include="sites/all" --exclude="sites/*"';
  }
  if (array_key_exists('mode', $all_specified_options)) {
    $mode = "-" . $all_specified_options['mode'];
  }
  if (drush_get_context('DRUSH_VERBOSE')) {
    // the drush_op() will be verbose about the command that gets executed.
    $mode .= 'v';
    $options .= ' --stats --progress';
  }
  $rsync_available_options = array(
    // unary options
    'archive', // -a
    'recursive', // -r
    'relative', // -R
    'backup', // -b
    'update', // -u
    'checksum', // -c
    'dirs', // -d
    'links', // -l
    'copy-links', // -L
    'copy-dirlinks', // -k
    'keep-dirlinks', // -K
    'hard-links', // -H
    'perms', // -p
    'executability', // -E
    'acls', // -A
    'xattrs', // -X
    'owner', // -o
    'group', // -g
    'times', // -t
    'omit-dir-times', // -O
    'sparse', // -S
    'dry-run', // -n
    'whole-file', // -W
    'one-file-system', // -x
    'prune-empty-dirs', // -m
    'ignore-times', // -I
    'fuzzy', // -y
    'cvs-exclude', // -C
    'compress', // -Z
    'protect-args', // -s
    '8-bit-output', // -8
    'human-readable', // -h
    'itemize-changes', // -i
    'copy-unsafe-links',
    'safe-links',
    'no-implied-dirs',
    'inplace',
    'append',
    'append-verify',
    'existing',
    'remove-source-files',
    'delete',
    'delete-before',
    'delete-during',
    'delete-delay',
    'delete-after',
    'delete-excluded',
    'ignore-errors',
    'force',
    'ignore-existing',
    'partial',
    'delay-updates',
    'numeric-ids',
    'size-only',
    'blocking-io',
    'stats',
    'progress',
    'list-only',
    // options with values
    'block-size',
    'backup-dir',
    'suffix',
    'chmod',
    'rsync-path',
    'modify-window',
    'compare-dest',
    'copy-dest',
    'link-dest',
    'skip-compress',
    'filter',
    'exclude',
    'include',
    'address',
    'port',
    'sockopts',
    'out-format',
    'bwlimit',
    'iconv',
    'checksum-seed',
    'max-delete',
    'max-size',
    'min-size',
    'partial-dir',
    'timeout',
    'temp-dir',
    'compress-level',
    'out-format',
    'protocol',
    );
  foreach ($rsync_available_options as $test_option) {
    if (array_key_exists($test_option, $all_specified_options)) {
      $value = $all_specified_options[$test_option];
      if ($value === TRUE) {
        $options .= " --$test_option";
      }
      elseif (isset($value)) {
        $options .= " --$test_option=" . escapeshellarg($value);
      }
    }
  }

  $ssh_options = @$all_specified_options['ssh-options'];
  $exec = "rsync -e 'ssh $ssh_options' $mode$options $source $destination";

  $exec_result = drush_op('system', $exec) !== FALSE;

  return $exec_result;
}

/**
 * Evaluate a path from its shorthand form to a literal path
 * usable by rsync.
 *
 * A path is "machine:/path" or "machine:path" or "/path" or "path".
 * 'machine' might instead be an alias record, or the name
 * of a site in the 'sites' folder.  'path' might be (or contain)
 * '%root' or some other path alias.  This function will examine
 * all components of the path and evaluate them as necessary to
 * come to the final path.
 *
 * @param path
 *   The path to evaluate
 * @param remote_user
 *   The remote user, as specified in the remote alias or on the command line.
 * @return
 *   The site record for the machine specified in the path, if any,
 *   with the path to pass to rsync (including the machine specifier)
 *   in the 'rsync-path' item.
 */
function _drush_core_evaluate_path($path, $remote_user = '') {
  $site_alias_settings = array();
  $path_aliases = array();
  // Parse site aliases if there is a colon in the path
  $colon_pos = strpos($path, ':');
  if ($colon_pos !== FALSE) {
    $alias = substr($path, 0, $colon_pos);
    $path = substr($path, $colon_pos + 1);
    $site_alias_settings = drush_sitealias_get_record($alias);
    $machine = $alias;
  }
  else {
    // if the path is a site alias or a local site...
    $site_alias_settings = drush_sitealias_get_record($path);
    if (!empty($site_alias_settings) || drush_is_local_host($path)) {
      $alias = $path;
      $path = '';
    }
  }

  if (!empty($site_alias_settings)) {
    // Use 'remote-host' from settings if available; otherwise site is local
    if (array_key_exists('remote-host', $site_alias_settings)) {
      if (array_key_exists('remote-user', $site_alias_settings)) {
        $remote_user = $site_alias_settings['remote-user'] . '@';
      }
      $machine = $remote_user . $site_alias_settings['remote-host'];
    }
    else {
      $machine = '';
    }
  }
  else {
    // Strip the machine portion of the path if the
    // alias points to the local machine.
    if (drush_is_local_host($machine)) {
      $machine = '';
    }
    else {
      $machine = "$remote_user$machine";
    }
  }

  // If there was no site specification given, and the
  // machine is local, then try to look
  // up an alias record for the default drush site.
  if (empty($site_alias_settings) && empty($machine)) {
    $drush_uri = drush_bootstrap_value('drush_uri', drush_get_option(array('l', 'uri'), 'default'));
    $site_alias_settings = drush_sitealias_get_record($drush_uri);
  }

  // Always add transient defaults
  _drush_sitealias_add_transient_defaults($site_alias_settings);

  // Resolve path aliases such as %files, if any exist in the path
  if (!empty($path)) {
    drush_sitealias_resolve_path_references($site_alias_settings, $path);
  }
  
  if (array_key_exists('path-aliases', $site_alias_settings)) {
    $path_aliases = $site_alias_settings['path-aliases'];
  }

  // If site alias does not contain a 'root',
  // then assume that the remote Drupal root is the same
  // as the local Drupal root.
  $drupal_root = array_key_exists('root', $site_alias_settings) ? $site_alias_settings['root'] : drush_get_context('DRUSH_DRUPAL_ROOT');
  // Add a slash to the end of the drupal root, as below.
  if ($drupal_root[strlen($drupal_root)-1] != '/') {
    $drupal_root = $drupal_root . '/';
  }
  foreach ($path_aliases as $key => $value) {
    // Expand all relative path aliases to be based off of the Drupal root
    if (($value[0] != '/') && ($key != '%root')) {
      $path_aliases[$key] = $drupal_root . $value;
    }
    // Rsync is very particular about the meaning of paths that
    // end with a '/' compared to those that do not.  In order to
    // copy from !path to !path without creating an extra spurrious
    // directory, the path alias must end with a '/'.  Therefore
    // we will add a slash to the end of any alias that does not
    // already have one.
    if ($value[strlen($value)-1] != '/') {
      $path_aliases[$key] = $path_aliases[$key] . '/';
    }
  }
  
  // Fill in path aliases in the path.
  $path = str_replace(array_keys($path_aliases), array_values($path_aliases), $path);

  // The path component is just the path part of the full
  // machine:path specification (including the colon).
  $path_component = (!empty($path) ? ':' . $path : '');

  // Next make the rsync path, which includes the machine
  // and path components together.
  // First make empty paths or relative paths start from the drupal root.
  if (empty($path) || ($path[0] != '/')) {
    $path = $drupal_root . $path;
  }

  // If there is a $machine component, to the path, then
  // add it to the beginning
  if (!empty($machine)) {
    $path = $machine . ':' . $path;
  }

  $site_alias_settings['rsync-path'] = $path;
  $site_alias_settings['path-component'] = $path_component;

  return $site_alias_settings;
}

