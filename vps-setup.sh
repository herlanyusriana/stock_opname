#!/bin/bash

###############################################################################
# Quick Setup Script - Run this FIRST on your VPS
###############################################################################

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}==================================${NC}"
echo -e "${GREEN}  Stock Opname VPS Quick Setup${NC}"
echo -e "${GREEN}==================================${NC}"

# Update system
echo -e "${YELLOW}Updating system...${NC}"
sudo apt update && sudo apt upgrade -y

# Install required packages
echo -e "${YELLOW}Installing required packages...${NC}"
sudo apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-redis \
    composer git curl unzip supervisor redis-server certbot python3-certbot-nginx ufw

# Install Node.js
echo -e "${YELLOW}Installing Node.js LTS...${NC}"
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs

# Configure MySQL
echo -e "${YELLOW}Configuring MySQL...${NC}"
DB_PASSWORD=$(openssl rand -base64 16)
sudo mysql << MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS stock_opname;
CREATE USER IF NOT EXISTS 'stock_opname'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON stock_opname.* TO 'stock_opname'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

# Create project directory
echo -e "${YELLOW}Creating project directory...${NC}"
sudo mkdir -p /var/www/stock_opname
sudo chown -R $USER:$USER /var/www/stock_opname

# Configure firewall
echo -e "${YELLOW}Configuring firewall...${NC}"
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
echo "y" | sudo ufw enable

# Save credentials
echo -e "${YELLOW}Saving credentials...${NC}"
cat > ~/stock_opname_credentials.txt << EOF
Stock Opname Database Credentials
==================================
Database: stock_opname
Username: stock_opname
Password: ${DB_PASSWORD}

IMPORTANT: Save this file securely and delete it after copying the password!
EOF

echo -e "${GREEN}==================================${NC}"
echo -e "${GREEN}Setup completed!${NC}"
echo -e "${GREEN}==================================${NC}"
echo ""
echo -e "${YELLOW}Database credentials saved to: ~/stock_opname_credentials.txt${NC}"
echo ""
echo "Next steps:"
echo "1. Read the credentials file: cat ~/stock_opname_credentials.txt"
echo "2. Configure your domain DNS to point to this VPS IP"
echo "3. Follow DEPLOYMENT.md for the next steps"
