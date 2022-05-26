# Instagram


## What is it?

It is a simple instagram clone built using PHP 8  + Symfony 6, MYSQL and HTML + CSS + Docker.

## How it works

The application can be divided into 4 users:

* Guest
  * Can register with email confirmation
  * It can reset its password
  * It can log on
* Registered user
  * Can add new posts
  * Can add new comments
  * Can like someone else's posts
  * Can edit and delete their posts and comments
  * Can search for other users (elasticsearch)
* Moderator
  *  Has all the functionality of a registered user
  *  can delete and edit comments of other users
* Admin
  *  Has all the functionality of a moderator
  *  He has access to the management panel (thanks to the easy admin package) in which he can manage all the things on the website




## Things that I would like to improve/add in the future:

The application that I have created provides functionalities that allow you to fully enjoy the service. However, there are features that I would like to develop in the future:
- adding topic tags, or keywords that will be assigned to the post. This will serve to group the information on similar topics available on the website.
- Introducing the possibility of logging in with your Facebook account.
