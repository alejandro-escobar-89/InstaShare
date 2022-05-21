<h1 align="center">InstaShare</p>

<p>Rest API for easily sharing files in a comunity.</p>

<hr>

<h3>Tips to test in a local environment</h3>

<ol>
	<li>Create a virtual host in Apache/Nginx with this URL: api.instashare.com</li>
	<li>Clone the repo to your local staging area</li>
	<li>Create a ".env" file in the root of the project (you can copy the ".env.example")</li>
	<li>In the command line write the following commands: <br> <code>composer install</code> to install dependencies. <br> <code>php artisan key:generate</code> to create a new key for the project. <br> <code>php artisan passport:install</code> to set up Passport authentication module. <br> <code>php artisan migrate</code> to create the database and the necesary tables. <br> <code>php artisan queue:work</code> to start processing server jobs. <br> <code>php artisan db:seed</code> to populate the DB with dummy data. <br> <code>php artisan test</code> if you intend to see Unit and Feature test results.</li>
</ol>

<p>If you go to "api.instashare.com" in your browser, you should see a list of available API endpoints</p>

<p><strong>Note:</strong> It's important to be consistent with the API and client base URLs as these are registered in the ".env" file with the exact fully qualified names in order for the Sanctum authentication system to work. If you decide to change the API or the client's URL, you need to update the environment variables accordingly.</p>