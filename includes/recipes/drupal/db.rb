namespace :drupal do
  namespace :db do    
    namespace :dump do
      desc "Deletes old database dumps, leaves only the latest on the server"
      task :cleanup, :roles => :db do
        dumps = capture("ls -xt #{shared_path}/dumps").split.reverse
        run "cd #{shared_path}/dumps; rm #{dumps[0..-2].join(" ")}"
      end

      namespace :local do
        desc "Dumps the local database"
        task :default, :roles => :db do
          raise RuntimeError.new("failed dump") unless system "#{local_mysqldump} -u #{local_db_user} --password=#{local_db_password} #{local_db_name} > dump.local.sql"
        end

        namespace :upload do
          desc "Dumps and uploads the local database"
          task :default do
            drupal::db::dump::local::default
            put(File.read("dump.local.sql"), "#{shared_path}/dumps/dump.local.sql")
            run "mysql -u #{db_user} --password=#{db_password} #{db_name} < #{shared_path}/dumps/dump.local.sql"
          end
        end        
      end
      
      namespace :remote do
        desc "Dumps the remote database"
        task :default, :roles => :db do
          filename = "#{Time.now.to_i.to_s}.dump.sql"
          run "cd #{shared_path}/dumps; #{remote_mysqldump} -u #{db_user} --password=#{db_password} #{db_name} > #{filename}"
          run "cd #{shared_path}/dumps; bzip2 #{filename}"
        end          
      
        namespace :download do
          desc "Dumps and downloads the remote database"
          task :default do
            drupal::db::dump::remote::default
            latest
          end
          
          desc "Downloads the latest database dump"
          task :latest, :roles => :db do
            dumps = capture("ls -xt #{shared_path}/dumps").split.reverse
            get("#{shared_path}/dumps/#{dumps.last}", "./#{dumps.last}")
          end
          
        end
      end
            
    end
  end
  
end