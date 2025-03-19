
# StudentUI 

MySQL and PHP Based Webapp for Simple Registration and Login System Demo




## 🚀 Deploy on AWS with EC2 and RDS

### Step 1: WarmUP EC2 Instance
```bash
# Install Apache (httpd), PHP, and MySQL client
sudo dnf install -y httpd php php-mysqlnd git

# Start and enable Apache service
sudo systemctl enable --now httpd
sudo systemctl start httpd

# Set permissions for web directory
sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www
sudo chmod 2775 /var/www

find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;
```

### Step 2: Clone Your Web Application


```bash
  # Go to the web directory
  cd /var/www/html
  
  # Clone your repository (or copy your files)
  git clone https://github.com/srngx/studentUI.git .

```

### Step 3: Configure Your Database Connection
```bash
   nano /var/www/html/db_config.php
```

### Step 4: Update the database connection settings

```php
<?php
// db_config.php - Central configuration file for database credentials

// Database connection parameters
define('DB_HOST', 'your-rds-endpoint.rds.amazonaws.com'); // Get this from your RDS console
define('DB_USERNAME', 'admin'); // Use the username you set in RDS
define('DB_PASSWORD', 'your-rds-password'); // Use the password you set in RDS
define('DB_NAME', 'mydb');
```

### Step 5: Create the Database Tables

1. Connect to your RDS database from your EC2 instance:

```bash
mysql -h your-rds-endpoint.rds.amazonaws.com -u admin -p
```

2. Enter your RDS password when prompted
Create the necessary tables:
```sql
USE mydb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

EXIT;
```

### Step 6: Test Your Application

- Open your web browser and navigate to your EC2 instance's public DNS or IP address:

`http://your-ec2-public-dns/index.html`


Try registering a new user and logging in to confirm that everything works

### Troubleshooting Tips

If the application doesn't connect to the database, check:

RDS security group inbound rules
Database credentials in `db_config.php`
RDS endpoint is correct


**For permission issues:**

```bash
sudo chmod -R 755 /var/www/html
sudo chown -R apache:apache /var/www/html
```

Check Apache logs for errors:
```bash
sudo cat /var/log/httpd/error_log
```