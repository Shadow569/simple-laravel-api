## Blog API

This is a very simple API for blogs that allows for user authentication, posting
and commenting on individual posts.

This is implemented using Laravel.

### Installation

The process for installing the application are the same steps as installing
any laravel application:

first we install the required composer packages by running `composer install`.\
then we setup the .env file with the necessary credential for connecting to the mysql server.\
then we clear the configuration cache by running `php artisan config:clear`.

the next step is to migrate and seed our database by running the following commands:
>php artisan migrate

to seed the tags and categories we run:
>php artisan db:seed --class=TagSeeder\
>php artisan db:seed --class=CategorySeeder

we can now try with postman to login using the api using the endpoint provided
in the **Endpoints** section. If it's not working, sanctum might not be installed, for that
we need to run the following commands:

>composer require laravel/sanctum\
>php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"\
>php artisan migrate

this last part should not be required as this application is developed for Laravel 11.x
and sanctum is installed as part of the regular laravel installation.

### Endpoints
`/api/users/tokens`(`POST`) is used to login and receive an access token to be used
for posting and commenting on the blog posts. It takes the following parameters:

`email` is the email registered for the account.\
`password` is the password to access the account.

`/api/users/register`(`POST`) is used to register a new account. It receives the following
parameters:

`email` is the email to be registered for the account and must be unique.\
`password` is the login password, it must be at least 8 characters long.\
`name` is the name you prefer to use and will be displayed as "author" under
posts and comments.

>The following endpoints can be accessed only with a valid access token, which should be placed 
>on the Authorization request headers like this: `Authorization: Bearer <access token>`.

`/api/posts/post/{post_id}`(`GET`) can be used to display a single post by post id 
with all the related comments, categories and tags.

`/api/posts/slug/{slug}`(`GET`) can be used to display a single post by slug with
all the related comments, categories and tags.

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


`/api/posts`(`POST`) can be used to create a new post, the parameters 
that can be passed are the following:

`title` is the title of the post and is required.\
`slug` is the slug or the SEO friendly unique identifier for the post and is required.\
`content` is the content of the post, it can be empty, this is so that the
post can be created and further edited in a separate step in the application.\
`tags` is an array of ids of related tags, it is optional and should be an array of
existing tag ids.\
`categories` is an array of ids of related categories, it is optional and should be an array of
category ids.

`/api/posts/{post_id}`(`PUT`) can be used to update a post, the parameters
that can be passed are the following:

`title` is the title of the post and should not be empty.\
`slug` is the slug or the SEO friendly unique identifier for the post and should not be empty.\
`content` is the content of the post, it can be empty.\
`tags` is an array of ids of related tags, it is optional and should be an array of
existing tag ids.\
`categories` is an array of ids of related categories, it is optional and should be an array of
category ids.

`/api/posts/{post_id}`(`DELETE`) can be used to delete a post.

`/api/posts/{post_id}/comment`(`POST`) can be used to add a comment to a post,
with the following parameters:

`comment` which is required and is the body of the comment.

`/api/comments/{comment_id}`(`PUT`) can be used to update a comment,
with the following parameters:

`comment` which is if included should not be empty, it is the body of the comment.

`/api/posts/{comment}`(`DELETE`) can be used to delete a comment.

`/api/categories`(`GET`) can be used to retrieve all existing categories.

For examples there is the postman collection `Blog Laravel API.postman_collection.json`