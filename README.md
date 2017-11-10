# HappyTravelogue

-----------------------------------------------------------------------------------------------------------------------------
Tips for Testing the Functions:

(username: test, password: test) can be used to test the palnner and forum functions.

(email: ann@123.net, password: 123, manager),
(email: cindy@123.net, password: 123, staff), 
(email: elle@123.net, password: 123, intern) can be used to test the admin functions.

-----------------------------------------------------------------------------------------------------------------------------

Happy Travelogue


Happy Travelogue is a comprehensive web application designed for both users and administrators.
It includes 3 parts: planner, forum and admin. Planner and forum are users service and admin is a service only for employees. Logged in users can switch between planner and forum but have no to access to the admin part. And logged in administrators are not able to enter the planner or forum without log out and log in as an user. 


1. Planner
Users must login to use the service. After logged in, user will be allowed to manage his/her to do lists. 

Function options:
1)	Log in
2)	Register
3)	Review all his/her old to do lists
4)	Delete a list 
5)	Add items into a list
6)	Delete items in a list
7)	Switch the item status between "new", "in progress" and "done" 


2. Forum
Forum does not require users to login. 

Function options without login:
1)	Review all categories, topics and replies
2)	Register

Function options with login:
1)	Log in
2)	Register
3)	Review all categories, topics and replies
4)	Create a new topic
5)	Reply to any topics


3. Admin

Administration operations are only available to employees. Employees must log in to conduct operations and will have access to different functions depends on their job titles. A manager will be granted a higher privilege than a staff. Any staff can review/delete users and manage the forum and a manager is also able to review/delete employees. Interns have no privilege to work on the database system from the front-end.

Function options:
1)	Log in
2)	Review all users
3)	Delete a user
4)	Add categories
5)	Delete topics
6)	Delete replies
7)	Review employees (Only allowed to managers) 
8)	Delete employees (Only allowed to managers)
