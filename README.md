# Laravel Short URL Redirect System

This repository contains a Laravel-based system for creating, managing, and redirecting short URLs with advanced features such as user tracking, traffic routing based on user information, custom slug creation, link validity management, multi-tenancy support, and tagging for links.

## Features

- **User Tracking**: Records detailed request information for each shortened URL access, including IP address, user agent, operating system, browser type, country/city, geolocation, browser fingerprint, and the referring URL.
- **Conditional Redirection**: Redirects users to different target URLs based on their information, such as browser type or device.
- **Custom Slug Creation**: Allows the customization of URL slugs, including setting active and expiry dates for each URL.
- **URL Parameter Customization**: Enables the addition of custom UTM parameters or any key-value parameters to the target URLs for enhanced tracking.
- **Multi-Tenant Management**: Supports a multi-tenant architecture, associating each shortened URL with a specific tenant, under which multiple users can operate.
- **Tagging System**: Facilitates the management and categorization of URLs with one or multiple tags.
- **Custom JavaScript**: Ability to add custom JavaScript code for each shortened URL.

## Database Schema

The system's database architecture comprises several tables designed to store users, tenants, links, tags, request logs, and routing rules. Key tables include:

- `users`: Stores user information with roles and status.
- `tenants`: Represents tenants in the multi-tenant system.
- `links`: Contains short URL data, including slugs, target URLs, and validity.
- `tags`: For categorizing links with tags.
- `request_logs`: Logs detailed request information for analytics and routing decisions.
- `rules`: Defines routing rules for dynamic traffic routing based on request information.
- `scripts`: Used to store custom JavaScript code associated with each link.


## Environment Requirements

- PHP 8.3 or higher
- MySQL 8.0 or higher

## Installation

To set up the project, follow these steps:

1. Clone the repository to your local machine.
2. Run `composer install` to install the required PHP dependencies.
3. Set up your `.env` file with the necessary database configurations.
4. Run `php artisan migrate` to create the database schema.
5. Ensure the `MAXMIND_LICENSE_KEY` is set in your `.env` file, then execute `php artisan maxmind:download` to download and update the IP location database.

## Usage

### Creating and Managing Links

Use the provided Eloquent models (`Link`, `Tag`, `Tenant`, etc.) to create and manage short URLs, tenants, and tags programmatically.

### Tracking Requests

The system automatically captures and logs request information when a short URL is accessed. This data powers the dynamic routing and analytics features.

### Dynamic Routing

Define rules for each short URL to route requests based on captured information (e.g., browser type, device). The system evaluates these rules in real-time to determine the target URL.

### Multi-Tenancy

Leverage the multi-tenant architecture to segregate short URLs by tenant, with each tenant having its own users and link management capabilities.

## Contributing

We welcome contributions! Please submit pull requests for any bug fixes, features, or improvements.

## License

This project is open-sourced under the MIT License. See the LICENSE file for more details.
