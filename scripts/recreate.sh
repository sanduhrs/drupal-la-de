#!/usr/bin/env bash

# Install from config folder.
ddev drush -y si --existing-config --account-pass=admin
# Import default content
ddev drush -y pm:install default_content la_eu_default_content
# Disable content modules
ddev drush -y pm:uninstall default_content la_eu_default_content