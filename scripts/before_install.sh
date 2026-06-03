#!/bin/bash

# Define directory and file
LOG_DIR="/opt/custom-codedeploy-logs"
LOG_FILE="$LOG_DIR/before_install.log"

# Log function
log() {
    echo "$(date) - $1" >> "$LOG_FILE"
}

# Ensure the log directory exists and set permissions
if [ ! -d "$LOG_DIR" ]; then
    sudo mkdir -p "$LOG_DIR"
    sudo chown -R ubuntu:ubuntu "$LOG_DIR"
    sudo chmod -R 755 "$LOG_DIR"
    log "Created log directory: $LOG_DIR"
else
    log "Log directory already exists: $LOG_DIR"
fi

# Clear old log file
> "$LOG_FILE"
log "Cleared old log file: $LOG_FILE"

# Install composer dependencies
PROJECT_PATH="/var/www/html/cms"
cd $PROJECT_PATH
log "Installing Composer dependencies..."
composer install --no-interaction
log "Composer dependencies installed."
