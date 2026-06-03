LOG_DIR="/opt/custom-codedeploy-logs"
LOG_FILE="$LOG_DIR/application_start.log"

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

# Change permissions of the project directory
PROJECT_PATH="/var/www/html/cms"
log "Changing permissions for $PROJECT_PATH to www-data:www-data..."
sudo chown -R www-data:www-data "$PROJECT_PATH"
sudo chmod -R 775 "$PROJECT_PATH"/vendor
sudo chmod -R 775 "$PROJECT_PATH"/writable
log "Permissions changed for $PROJECT_PATH."

# Reload services
log "Reloading nginx..."
sudo systemctl reload nginx
log "Nginx reloaded."

log "Reloading php8.1-fpm..."
sudo systemctl reload php8.1-fpm
log "PHP-FPM reloaded."
