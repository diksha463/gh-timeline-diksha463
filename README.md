# gh-timeline-diksha463
# GH-Timeline – Email Verification & GitHub Timeline Notifications

This project is a **PHP-based email verification system** that registers users by verifying their email addresses and keeps them updated with the **latest GitHub timeline** via automated emails every 5 minutes using a CRON job.

---

## 📌 Features Implemented

### ✅ 1. Email Verification System
- Users can input their email to receive a **6-digit verification code**.
- On correct code entry, email is stored in `registered_emails.txt`.
- Code is sent using **PHP's native `mail()` function** in **HTML format**.

### ✅ 2. Unsubscribe Mechanism
- Emails include an **Unsubscribe link**.
- Users confirm unsubscription using a verification code.
- Verified emails are removed from `registered_emails.txt`.

### ✅ 3. GitHub Timeline Updates
- Every **5 minutes**, a CRON job:
  - Fetches GitHub data (dummy/static in this version).
  - Formats it in an HTML table.
  - Sends the data to all registered users via email.

---

## 🗂️ Project Structure
email-system/
├── composer.json
├── composer.lock
├── vendor/
├── src/
│ ├── index.php
│ ├── functions.php
│ ├── cron.php
│ ├── unsubscribe.php
│ ├── setup_cron.sh
│ └── registered_emails.txt


---

## ⚙️ How to Run

### 🔧 Local Setup (XAMPP)

1. Place the `email-system` folder inside `C:\xampp\htdocs`.
2. Start **Apache** in XAMPP Control Panel.
3. Visit: [http://localhost/email-system/src](http://localhost/email-system/src)
4. Enter an email and test the verification process.

---

## ⏱️ CRON Job Setup

1. Use the provided script `setup_cron.sh` to install the CRON job:
   ```sh
   bash setup_cron.sh
This script will register a job that runs cron.php every 5 minutes.

📩 Email Format Requirements
🔹 Verification Email
Subject: Your Verification Code

Body:
<p>Your verification code is: <strong>123456</strong></p>
From: no-reply@example.com

🔹 GitHub Update Email
Subject: Latest GitHub Updates

Body:
<h2>GitHub Timeline Updates</h2>
<table border="1">
  <tr><th>Event</th><th>User</th></tr>
  <tr><td>Push</td><td>testuser</td></tr>
</table>
<p><a href="unsubscribe_url" id="unsubscribe-button">Unsubscribe</a></p>

🔹 Unsubscribe Confirmation Email
Subject: Confirm Unsubscription

Body:
<p>To confirm unsubscription, use this code: <strong>654321</strong></p>

🚫 Restrictions Followed
❌ No use of external libraries (pure PHP only)

❌ No database; using registered_emails.txt as storage

❌ No modification outside the src/ directory

❌ No changes to function names or HTML structure


