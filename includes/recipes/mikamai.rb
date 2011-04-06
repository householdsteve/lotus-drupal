before 'deploy:restart', 'mikamai:permissions:fix'
before 'deploy:start', 'mikamai:permissions:fix'

namespace :mikamai do
    
  namespace :permissions do
    task :fix, :except => { :no_release => true } do
      # sudo "chown -R www-data:www-data #{latest_release}"
    end
  end
  
end
