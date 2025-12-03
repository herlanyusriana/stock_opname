#!/bin/bash

###############################################################################
# Stock Opname - VPS Deployment Script
# 
# Usage: 
#   ./deploy.sh        - Deploy to VPS
#   ./deploy.sh setup  - First time setup on VPS
###############################################################################

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="stock_opname"
REMOTE_USER="root"
REMOTE_HOST="43.157.248.25"
REMOTE_PATH="/var/www/${PROJECT_NAME}"
REMOTE_BRANCH="main"

echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}  Stock Opname Deployment Script${NC}"
echo -e "${GREEN}======================================${NC}"

# Function to print colored messages
print_message() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# Check if running setup or deploy
if [ "$1" == "setup" ]; then
    echo -e "${YELLOW}Running first-time setup on VPS...${NC}"
    
    ssh ${REMOTE_USER}@${REMOTE_HOST} << 'ENDSSH'
        # Update system
        echo "Updating system packages..."
        sudo apt update && sudo apt upgrade -y
        
        # Install required packages
        echo "Installing required packages..."
        sudo apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-mbstring \
            php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-redis \
            composer git curl unzip supervisor redis-server
        
        # Install Node.js (LTS)
        echo "Installing Node.js..."
        curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
        sudo apt install -y nodejs
        
        # Create project directory
        echo "Creating project directory..."
        sudo mkdir -p /var/www/stock_opname
        sudo chown -R $USER:$USER /var/www/stock_opname
        
        # Configure MySQL (basic security)
        echo "Configuring MySQL..."
        sudo mysql -e "CREATE DATABASE IF NOT EXISTS stock_opname;"
        sudo mysql -e "CREATE USER IF NOT EXISTS 'stock_opname'@'localhost' IDENTIFIED BY 'change_this_password';"
        sudo mysql -e "GRANT ALL PRIVILEGES ON stock_opname.* TO 'stock_opname'@'localhost';"
        sudo mysql -e "FLUSH PRIVILEGES;"
        
        echo "Setup completed! Please configure Nginx manually."
ENDSSH
    
    print_message "VPS setup completed!"
    print_warning "Don't forget to:"
    echo "  1. Configure Nginx (see nginx.conf example)"
    echo "  2. Update MySQL password"
    echo "  3. Setup SSL certificate (Let's Encrypt)"
    echo "  4. Configure firewall (UFW)"
    
    exit 0
fi

# Regular deployment
print_message "Starting deployment process..."

# Build assets locally
print_message "Building production assets..."
npm install
npm run build

# Create deployment package
print_message "Creating deployment package..."
tar -czf deploy.tar.gz \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='.env' \
    --exclude='deploy.tar.gz' \
    .

# Upload to VPS
print_message "Uploading to VPS..."
scp deploy.tar.gz ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_PATH}/

# Execute deployment on VPS
print_message "Executing deployment commands on VPS..."
ssh ${REMOTE_USER}@${REMOTE_HOST} << ENDSSH
    cd ${REMOTE_PATH}
    
    # Extract files
    echo "Extracting files..."
    tar -xzf deploy.tar.gz
    rm deploy.tar.gz
    
    # Install PHP dependencies
    echo "Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader
    
    # Set permissions
    echo "Setting permissions..."
    chmod -R 755 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    
    # Run migrations
    echo "Running database migrations..."
    php artisan migrate --force
    
    # Clear and cache config
    echo "Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    
    # Restart services
    echo "Restarting services..."
    sudo systemctl reload php8.2-fpm
    sudo systemctl reload nginx
    
    # Restart queue workers (if using supervisor)
    if [ -f /etc/supervisor/conf.d/stock-opname-worker.conf ]; then
        sudo supervisorctl reread
        sudo supervisorctl update
        sudo supervisorctl restart stock-opname-worker:*
    fi
    
    echo "Deployment completed!"
ENDSSH

# Cleanup local deployment package
rm -f deploy.tar.gz

print_message "Deployment completed successfully!"
print_message "Application is now live at: https://yourdomain.com"

# Optional: Run post-deployment checks
print_message "Running health check..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://yourdomain.com)
if [ "$HTTP_CODE" == "200" ]; then
    print_message "Health check passed! (HTTP $HTTP_CODE)"
else
    print_warning "Health check returned HTTP $HTTP_CODE"
fi
