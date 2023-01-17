# LibraryWebApp
Databases used: Books, students, staffs, Reserved_Books, Borrowed_Books

Fields used in Books: ISBN (Primary Key), Title, Author, Genre, Copies, Stock, Publisher, Published, Summary

Fields used in Students: Email (Primary Key), Username, Pass

Fields used in Staffs: Email (Primary Key), Username, Pass

Fields used in Borrowed_Books: ID (Auto Incremented, Primary Key), ISBN, Email, Due, Book_Status

Fields used in Reserved_Books: ID (Auto Incremented, Primary Key), ISBN, Email, Available, Due

Use the book (3).sql file for local php database.
If heroku still allow user for free database then the website link is: https://university-lib-app.herokuapp.com/

Account Login Available: 
Staffs:  
Email: coco@staffs.com 
Pass: 12345678 

Students: 
Email: coco@students.com, coco1@students.com, coco2@students.com 
Pass: 12345678 
