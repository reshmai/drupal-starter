## To check my subscribe code, pull (main) branch.
follow below steps:   
- `ddev drush en og -y`
- `ddev drush en og_ui -y`
- Create Group Content type<br>
  <img width="1512" height="982" alt="Screenshot 2025-09-05 at 11 02 36 AM" src="https://github.com/user-attachments/assets/988e893f-10db-41b6-bc0f-18528209161b" />
- Create New content of Group content type
- Create new user
- Login with new user and open newly created Group type content link
- You will see message for subscribe, click on "here"<br>
  <img width="1512" height="982" alt="Screenshot 2025-09-05 at 11 06 58 AM" src="https://github.com/user-attachments/assets/aa8204f2-ccf0-4f19-a94d-33467eddf65e" />
- Go to admin and check newly created content members list<br>
  <img width="1512" height="982" alt="Screenshot 2025-09-05 at 11 07 52 AM" src="https://github.com/user-attachments/assets/1a851fda-be45-43ae-b8b0-39088a1b3117" /><br>
- You will see newuser has been added into group
- Run my test using
  `ddev phpunit web/modules/custom/server_general/tests/src/ExistingSite/GroupSubscriptionFunctionalTest.php`<br><br>

*_Note : Once click on subscribe, messgae should be disappear or changed (Not working)_*

## To check my person card in style guide
- Check pull request from branch feature/person-card
- Added cards into Style guide.
- Responsive design is implemented
- Here are the screenshots of mobile screen, Tablet, and desktop <br>
<img width="1512" height="982" alt="Screenshot 2025-09-05 at 10 20 27 AM" src="https://github.com/user-attachments/assets/493817fc-b2d4-4b58-962c-fa659426582f" /><br>
<img width="1512" height="982" alt="Screenshot 2025-09-05 at 10 20 49 AM" src="https://github.com/user-attachments/assets/5bca7ac2-7023-41a5-adb6-b8a7c0cfa601" /><br>
<img width="1512" height="982" alt="Screenshot 2025-09-05 at 10 21 16 AM" src="https://github.com/user-attachments/assets/50713202-3d62-49f9-8b36-7386b3a72ff6" />
