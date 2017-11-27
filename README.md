# secure_login_script

Following this guide will help guard against many types of attack that crackers can use to gain control of other users' accounts, delete accounts and/or change data. Below is a list of possible attacks this guide tries to defend against:
SQL Injections
Session Hijacking
Network Eavesdropping
Cross Site Scripting
Brute Force Attacks
Covert Timing Channel Attacks

Log into your database as an administrative user (usually root)
In this guide we will create a database called "secure_login".
See how to Create-a-Database-in-Phpmyadmin

Create a user with only SELECT, UPDATE and INSERT privileges.
