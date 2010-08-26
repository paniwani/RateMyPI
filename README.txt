NOTES:

activate.php 	- This script activates a new user’s account via email response.
addpi.php		- Add's a PI given a oid and user input. PIs require activation by admin.
checklogin.php  - Checks the current session and cookie for login variables. Creates $login boolean as flag.
db.php			- Connects to and stores all database information.
debug.php		- Outputs all variables in $GLOBALS.
delete.sql		- Delets all SQL tables.
forgot_pass.php - Resets a forgotten password.
login.php 		- This script is responsible for verifying a users login credentials.
logout.php 		- Logs a user out of the application and terminates session.
mailtest.php	- Tests PHPmailer code to send email.
main.php		- Main page seen by user.
numgen.php 		- Generates a verification code for the login form.
register.php 	- Adds new users to the site.
search.php		- Handles organization and PI searches.
selectpi.php	- Show all PIs given an organization.
setup.sql		- Creates SQL tables and inserts default data.
showratings.php - Shows all ratings given a PI.
utils.php 		- Contains validation, email, and captcha functions.

oid - organization id
pid - PI id
rid - rating id
uid - user id

QUESTIONS:

- What if PI belongs to multiple organizations?

TO DO:

- remove image upload							x
- change authorization code						x
- login with email								x
- update captcha								x
- login/logout each pg							x
- use cookies									x
- fix password									x
- add pi w/ and w/o oid active/inactive			x
	- move header code up						x
- create addrating.php					
	- add character counter
- ratings active/inactive						
- add org active/inactive
- admin page to review ratings
- change organization search to dropdown
- fix forget_pass
- fix logout

FUTURE:
- download NED data
- create maintenance page