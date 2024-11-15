## To run a Laravel project from GitHub that uses Vite, follow these steps:

1. Clone the Repository:
git clone <repository_url>

2. Navigate to the Project Directory:
cd <project_name>

3. Install PHP Dependencies:
composer install

4. Install npm Dependencies:
npm  install

5. Set Up the .env File
If the .env file is missing, create it by copying the .env.example file:
cp .env.example .env

6. Generate the Application Key
php artisan key:generate

7. Configure the .env File

8. Set Up the Database
Run migrations to create the required tables:
php artisan migrate

9. To run the project
	1.Start Vite Dev Server:
		npm run dev
	2.Serve Laravel Backend: In another terminal, start the Laravel server:
		php artisan serve