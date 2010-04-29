load 'deploy' if respond_to?(:namespace) # cap2 differentiator

load 'includes/recipes/stages'
load 'includes/recipes/mikamai'
load 'includes/recipes/drupal'
load 'includes/recipes/overrides'
load 'includes/recipes/devs'

# SCM Stuff configure to taste, just remember the repository
set :repository,  "git@github.com:mikamai/quice.git"
set :scm, :git
set :branch, "master"
set :repository_cache, "git_master"
set :deploy_via, :remote_cache
set :scm_verbose, true
set :keep_releases, 3
set :ssh_options, {:forward_agent => true}
set :use_sudo, false