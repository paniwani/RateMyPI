NOTES:

login.php 		- This script is responsible for verifying a users login credentials.
logout.php 		- Simply logs a user out of the application and terminates any sessions that were created for the user.
register.php 	- Adds new users to the site.
activate.php 	- This script activates a new user’s account via email response.
forgot_pass.php - Resets a forgotten password.
numgen.php 		- Generates a verification code for the login form.

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
- add pi w/ and w/o oid active/inactive
	- move header code up
- ratings active/inactive
- add org active/inactive
- admin page to review ratings
- change organization search to dropdown
- fix logout