# SyncSystem - Multiplatform - FTP Pipeline v1
SyncSystem FTP pipeline v1 for SyncSystem Multiplatform PHP / Laravel v1.

## Overview
Simple automated pipeline for FTP deploy with shared server in mind, but could also be set up for dedicated servers.

## Setup
Steps to setup the simple automated pipeline.

### Create Hosting Spaces
Create two separate hosting spaces in the selected server. One for the frontend and one for the backend. Examples:
- mydomain.com (frontend)
- backend.mydomain.com (backend)

**Note:** configure hosting spaces with the PHP version in the project (Currently: PHP 8.0)

Ideally, these domains would also be the FTP access endpoints.
- Create FTP user and password for the hosting spaces

**Note:** We suggest creating distinct user and password for each hosting space, but it can be done with shared user/password for both of the spaces.
- Store FTP access, user and password in a safe place, as they will be used in the configuration files

### DNS Zone Configuration
Be sure to set up the DNS zone configuration so the hosting spaces can be accessed through the official domains.

### Configure SSL Certificated
Each hosting company has its own method for configuring the SSL certificates for the domains. The important aspect here is to be able to access the domains through SSL before proceeding with the steps. Example:

- https://www.mydomain.com or https://mydomain.com (frontend)
- https://backend.mydomain.com (backend)

### Create MySQL Database Instance
- Create the DB instance

**Note:** Be sure that the database can be accessed from outside the server's IP, as there's a step in the initial build process that runs Laravel migrations for Sanctum from inside the GitHub Actions Runner.

### GitHub Repository
- Create a new repository

Suggestion: with only a README.md file in it.

- Create GitHub personal access token

**Note:** classic method or fine-grained targeted to your project's repository.

    Important: must set the following permissions for read & write:
    - actions
    - pull requests
    - secrets
    - variables
    - workflows

- Copy generated token in a safe spot so it can be used later

### Create Local Dev Environment
- Create/navigate to your new project's directory (or use VS code and open the new project's directory)
- Terminal: `git clone https://github.com/jorge-mauricio/laravel8.git`
- Navigate to `laravel8` directory (or use VS code and open the laravel8 directory)
- Terminal: `git remote set-url origin https://github.com/your-user/project-name.git`
- Terminal: `git pull origin main --allow-unrelated-histories`
- Edit your README.md
- Terminal: `git add .`
- Terminal: `git commit -m "Readme file update"`
- Terminal: `git push origin main`

#### Edit Configuration Files
- Make a copy of the .env.example and name it `.env`
- Edit the environment variables in your `syncsystem-laravel8-v1/.env` according to your project (especially the FTP, MySQL configuration variables and GitHub data)
- Edit `syncsystem-laravel8-v1/config-application.php` according to your project
- Delete package-lock.json if present
- Terminal (/syncsystem-laravel8-v1): `npm install`

#### Update environment-variables-remote-set.js File
- Edit file syncsystem-laravel8-v1\devops\environment-variables-remote-set.js
- Edit `const appURLFrontend = 'https://www.mydomain.com'`;
- Edit `const appURLBackend = 'https://backend.mydomain.com'`;
- Terminal (/syncsystem-laravel8-v1): node devops/environment-variables-remote-set.js

Note: If everything was configured correctly, this command will set the secrets in you GitHub repository based on the data in your `.env` file. In the end of the process, will output additional information to be replaced the the GitHub Actions Workflow YML file.

    Tip: if, for whatever reason, you need to delete all GitHub Actions secrets, there's an automated method we set up for it:
    - Terminal: Terminal (/syncsystem-laravel8-v1): node devops/environment-variables-remote-delete-all.js

#### Update GitHub Actions Workflow YML File
The `environment-variables-remote-set.js` file output 3 sets of blocks to replace specific sections of the `.github\workflows\multiplatform-ftp-php-laravel8-deploy-v1.yml` file.
- String with yml file for setting the .env keys: update the section `env:` in the `multiplatform-ftp-php-laravel8-deploy-v1.yml` file (delete the example line and paste the +70 lines)
- String with bash script for setting the .env keys (backend): update the section `name: Upate .htaccess locally (Backend)` in the `multiplatform-ftp-php-laravel8-deploy-v1.yml` file (delete the example line and paste the +70 lines)
- String with bash script for setting the .env keys (frontend): update the section `name: Upate .htaccess locally (frontend)` in the `multiplatform-ftp-php-laravel8-deploy-v1.yml` file (delete the example line and paste the +70 lines)

### Update Repository
- Terminal: `git add .`
- Terminal: `git commit -m "Deploy FTP"`
- Terminal: `git push origin main`

Wait for the steps to finish and check if the deploy was successful by visiting:
- https://www.mydomain.com/system/login-users/ (or whatever configuration you set)
- user: root
- password: ******

## Resources
- SyncSystem - less code, more logic [Website](https://www.syncsystem.com.br)
- Jorge Mauricio (JM) – Full Stack Web Developer / Designer [Website](https://www.fullstackwebdesigner.com)

## Contributing

For contribution, open a pull request.

## Security Vulnerabilities

If you discover a security vulnerability within SyncSystem, please send an e-mail to JM via [contact@fullstackwebdesigner.com](mailto:contact@fullstackwebdesigner.com).

## License

The SyncSystem Multiplatform framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
