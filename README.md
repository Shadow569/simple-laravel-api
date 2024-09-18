## Blog API

This is a very simple API for blogs that allows for user authentication, posting
and commenting on individual posts.

This is implemented using Laravel.

### Installation

The process for installing the application are the same steps as installing
any laravel application, composer install, setting up the .env file with
the required credentials to connect with your mysql database, migrating
and seeding the database to build the necessary structures.

### Endpoints
`/api/users/tokens`(`POST`) is used to login and receive an access token to be used
for posting and commenting on the blog posts. It takes the following parameters:

`email` is the email registered for the account\
`password` is the password to access the account

`/api/users/register`(`POST`) is used to register a new account. It receives the following
parameters:

`email` is the email to be registered for the account and must be unique\
`password` is the login password, it must be at least 8 characters long\
`name` is the name you prefer to use and will be displayed as "author" under
posts and comments.

>The following endpoints can be accessed only with a valid access token, which should be placed 
>on the Authorization request headers like this: `Authorization: Bearer <access token>`

`/api/posts/post/{post_id}`(`GET`) can be used to display a single post by post id 
with all the related comments, categories and tags

`/api/posts/slug/{slug}`(`GET`) can be used to display a single post by slug with
all the related comments, categories and tags

`/api/users/posts`(`GET`) can be used to display all posts made by the logged in
user.

`/api/posts`(`GET`) can be used to retrieve all posts, it has a simple filtering
mechanism that can be used to find a specific post based on a specific parameter:

`filters` are the simple filters that can be in the format of:\
>[\
> &nbsp;&nbsp;&nbsp;&nbsp;{field1: value1},\
> &nbsp;&nbsp;&nbsp;&nbsp;{field3: value3}\
> ]

`order` can be used to modify the sorting of the results:
> {\
> &nbsp;&nbsp;&nbsp;&nbsp;direction: "asc|desc",\  
> &nbsp;&nbsp;&nbsp;&nbsp;field: "your_desired_field"\
> }
