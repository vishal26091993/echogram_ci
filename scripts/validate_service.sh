#!/bin/bash

# Define directory and file
LOG_DIR="/opt/custom-codedeploy-logs"
LOG_FILE="$LOG_DIR/validate.log"

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

# Validate Nginx service
if systemctl is-active --quiet nginx; then
    log "Nginx is running."
else
    log "Nginx is not running."
fi

# Validate PHP-FPM service
if systemctl is-active --quiet php8.1-fpm; then
    log "PHP-FPM is running."
else
    log "PHP-FPM is not running."
fi
