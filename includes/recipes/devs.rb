task :intinig do
  set :local_mysqldump, "/usr/local/mysql/bin/mysqldump"
  set :local_db_user, "root"
  set :local_db_password, ""
  set :local_db_name, "bio"
end

task :paolo do
  set :local_mysqldump, "/Applications/MAMP/Library/bin/mysqldump"
  set :local_db_user, "root"
  set :local_db_password, "root"
  set :local_db_name, "biotechsol-dev"
end
