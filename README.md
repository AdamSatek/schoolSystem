# schoolSystem
This is my first PHP project. Web page using HTML to show some basic informations, PHP and datebase to show and upload photogallery and some news, basic login system with 2 types of account (teacher, student) and at student you can generate PDF file, something like a students index.

In this project you can find simple page of random school where everybody can see index page, photogallery and news section and only students and teachers can log in.

(system is set up for only 4 subjects, positive and negative rating by teacher and apologies sent by student)

As student, you can see your profile page where you can find students grades and ratings.
As student, you can send Apology text, to be seen by all teachers.
As student, you can generate your index in PDF (using TCPDF).

As teacher, you can see in your profile page all apologies sent by students.
As teacher, you can add grades to students, positive and negative ratings, create new user, add pictures to photogallery and add news to news section.

First user have to be added manually to database, because only teacher can create new user accounts.

Use SQL stored in CreateDatabase file, to set database and create first user.

