#!/bin/sh
#
# This script is automatically run on the remote server
# after a change is pushed using git
#

echo "Running post-receive hook"

# Discard any local changes
unset GIT_DIR
git reset --hard HEAD

# Update dependencies
composer --no-ansi --verbose --no-interaction install
