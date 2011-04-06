load File.dirname(__FILE__) + '/drupal/db'
load File.dirname(__FILE__) + '/drupal/configure'

# Callbacks
after 'deploy:setup', 'drupal:setup'
after 'deploy:symlink', 'drupal:symlink'
before 'deploy:start', 'drupal:db:import:production'

before 'deploy:restart', 'drupal:configure:stage'
before 'deploy:start', 'drupal:configure:stage'

namespace :drupal do
  task :setup, :except => { :no_release => true } do
    run "mkdir -p #{shared_path}/files"
    run "chmod a+w #{shared_path}/files"
    
    run "mkdir -p #{shared_path}/dumps"
    
    run "chown -R #{user}:#{user} #{deploy_to}"
  end
  
  task :symlink, :except => { :no_release => true } do
    run "ln -s #{shared_path}/files #{latest_release}/sites/default/"
  end
end
