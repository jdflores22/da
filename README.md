# AgriCheck Monitoring and Tracking System

A comprehensive web-based solution for monitoring and tracking agricultural activities, built with Symfony framework.

## System Requirements

### Server Requirements
- PHP 8.1 or higher
- MySQL 8.0 or higher
- Apache/Nginx web server
- Composer 2.x
- Node.js 16.x or higher
- npm 8.x or higher

### Framework & Technologies
- Symfony 6.x
- Doctrine ORM
- Twig Template Engine
- Bootstrap 5.x
- jQuery 3.x
- Webpack Encore

## Installation

1. Clone the repository:
```bash
git clone [your-repository-url]
cd [project-directory]
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
# or
yarn install
```

4. Configure your environment:
- Copy `.env` to `.env.local`
- Update the database configuration in `.env.local`

5. Create the database:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. Start the development server:
```bash
symfony server:start
```

## Development

- Run tests: `php bin/phpunit`
- Build frontend assets: `npm run dev` or `yarn dev`
- Clear cache: `php bin/console cache:clear`

## License

[Your License]

## Contributing

[Your contribution guidelines] 