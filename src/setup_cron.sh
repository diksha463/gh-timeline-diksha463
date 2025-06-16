#!/bin/bash

CRON_JOB="*/5 * * * * /usr/bin/php $(pwd)/cron.php"

# Write out current crontab
crontab -l > mycron 2>/dev/null

# Echo new cron into cron file
if ! grep -Fxq "$CRON_JOB" mycron
then
    echo "$CRON_JOB" >> mycron
    crontab mycron
    echo "CRON job installed successfully."
else
    echo "CRON job already exists."
fi

rm mycron
