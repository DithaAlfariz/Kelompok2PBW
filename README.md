# Lapor Project

## Overview
This project is a PHP application designed to handle user complaints and generate PDF documents based on the submitted complaints. It connects to a database to retrieve complaint details and formats them into a structured PDF.

## Project Structure
```
lapor
├── vendor          # Contains all Composer dependencies
├── src             # Directory for PHP source files
├── download_aduan_pdf.php  # Handles PDF generation for complaints
├── koneksi.php     # Database connection logic
├── composer.json   # Composer configuration file
└── README.md       # Project documentation
```

## Setup Instructions

1. **Install Composer**: Ensure that Composer is installed on your system. You can download it from [getcomposer.org](https://getcomposer.org/).

2. **Navigate to Project Directory**:
   Open a terminal and navigate to the project directory:
   ```
   cd path/to/lapor
   ```

3. **Initialize Composer**:
   If you don't have a `composer.json` file, run the following command to create one:
   ```
   composer init
   ```
   Follow the prompts to set up your project details.

4. **Add Dependencies**:
   To add necessary packages, such as `mpdf/mpdf` for PDF generation, run:
   ```
   composer require mpdf/mpdf
   ```

5. **Install Dependencies**:
   After adding packages, install the dependencies into the `vendor` directory:
   ```
   composer install
   ```

6. **Include Autoload File**:
   In your PHP scripts, include the Composer autoload file to access the installed packages:
   ```php
   require_once __DIR__ . '/vendor/autoload.php';
   ```

## Usage
- Use `download_aduan_pdf.php` to generate PDF documents for user complaints.
- Ensure that the database connection details in `koneksi.php` are correctly configured to connect to your database.

## Contributing
Feel free to fork the repository and submit pull requests for any improvements or bug fixes.

## License
This project is open-source and available under the [MIT License](LICENSE).