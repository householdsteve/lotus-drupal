namespace :deploy do
  task :finalize_update, :except => { :no_release => true } do
    run "chmod -R g+w #{latest_release}" if fetch(:group_writable, true)
  end
  
  task :cold do
    update
    start
  end
  
  task :restart do
  end
  
  task :start do
  end
end