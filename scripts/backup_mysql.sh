#!/bin/bash

# Configuración
DB_USER="root"
DB_PASSWORD="Di360@23"
DB_NAME="dsa"
BACKUP_DIR="/var/www/dsa/backups_db"
DATE=$(date +"%Y%m%d%H%M%S")
FILENAME="$BACKUP_DIR/backup.sql"

# Comando de respaldo
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME > $FILENAME

# Comprimir el respaldo (opcional)
gzip $FILENAME
