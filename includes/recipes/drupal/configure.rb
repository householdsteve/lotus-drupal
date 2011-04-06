namespace :drupal do
  namespace :configure do
    task :stage do
      source = "#{latest_release}/sites/default/settings.#{stage_name}.php"
      dest = "#{latest_release}/sites/default/settings.php"
      run "cp #{source} #{dest}"
    end
  end
end