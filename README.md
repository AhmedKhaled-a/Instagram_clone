# Instagram Clone - Laravel Project

Welcome to the Instagram Clone project built using Laravel! This web application allows users to register, create profiles, share posts with images and captions, follow/unfollow other users, add likes and comments, and much more. The project is designed with various features to mimic the functionality of the popular social media platform, Instagram.

## Live Demo
[![Watch the video](https://img.youtube.com/vi/ftZtqf3u2xg/0.jpg)](https://www.youtube.com/embed/ftZtqf3u2xg)

### register/login demo
[![Watch the video](https://img.youtube.com/vi/QBPCibM9ZiA/0.jpg)](https://www.youtube.com/embed/QBPCibM9ZiA)

## Table of Contents
1. [User](#user)
2. [Posts](#posts)
2. [Home page](#home-page)

## User

### Signup and Login
- Users can sign up using their email or phone, providing necessary information such as Full Name, Username, and Password.
- Email verification is implemented, ensuring the user's email is valid.
- Users can log in using their email and password.
- Forgot/Reset Password functionality is available.

### Profile Management
- Users can edit their profile details, including avatar, bio, gender, and website.
- Changing the email triggers email verification for the new email.
- Users can change their password.

### Profile View page
- Displays user information such as username, avatar, bio, gender, and website.
- Shows counts of user's posts, followers, and following.
- Lists user's followers and following.
- Displays published posts with the ability to navigate to the post view page.
- Users can follow/unfollow and block other profiles.

### My Profile Page
- Similar to the Profile View page with the addition of a tab for saved posts.
- Allows users to edit their profile.


## Posts

#### New Post page
- Users can add posts with one or more images and captions.
- Captions can include tags (words preceded by #). Tags can't contain spaces.
- Images are required, captions are optional.

#### Post view page
- Displays post image with caption.
- Clickable tags navigate to the tag page.
- Users can comment and like any post.
- Comments display owner name, avatar, and time.
- Users can add the post to their saved list.

#### Tags Page
- Users can see posts related to the selected tag.
- Posts are shown in rows with three posts each.
- Clicking a post image navigates to the post view page.

## Home Page
- Users see the latest posts from profiles they follow with likes/comments (max 3 comments).
- Users can add likes/comments to the posts.
- Includes a search box for posts.

## Getting Started
1. Clone the repository.
2. Install dependencies using `composer install`.
3. Install dependencies using `npm install`.
4. Set up your database and configure the `.env` file.
5. Run migrations and seed the database with `php artisan migrate --seed`.
6. uncomment ;extention=gd by removing the ";" in the php.ini file.
7. Start the development server with `php artisan serve`.
8. `npm run dev` to compile and build the assets.
9. run `php artisan storage:link` to upload and use the images correctly.
