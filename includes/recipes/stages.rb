desc "deploy to development environment"
task :development do
  set :application, "quice.mikamai.com"
  set :stage_name, "development"

  role :web, "quice.mikamai.com", :primary => true
  role :db, "quice.mikamai.com", :primary => true
  set :user, "drupal"
  set :remote_mysqldump, "/usr/bin/mysqldump"
  set :deploy_to, "/var/apps/#{application}"
  set :db_user, "quice"
  set :db_password, "z3pp0l4"
  set :db_name, "quice"
end

desc "deploy to staging environment"
task :staging do 
  set :stage_name, "staging"
end

desc "deploy to production"
task :production do
  set :stage_name, "production"
end