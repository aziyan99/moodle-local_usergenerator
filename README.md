# User Generator

Moodle local plugin to generate users

## Install

### Installing from zipped Repository file

1. Download this Repo as a zipped file
2. Install from Moodle **Site administration**, plugins menu
3. Refresh Moodle web page, and follow the instructions to install and upgrades the DB

### Installing by clonning Repository

1. Copy clonned plugin directory to Moodle local path: **<moodle_base_dir>/local**
2. Refresh Moodle web page, and follow the instructions to install and upgrades the DB

## Usage

To open the generator form, login as **administrator** and go to Site administration > Plugins > Local plugins > User
Generator. Fill the form information and submit the form.

### Form field description

1. Prefix, used to append prefix to generated username and email (ex: metc will produce metc0000, metc0001, ...)
2. Count, total generated users

Every generated user will have default password `Password@12345`.
