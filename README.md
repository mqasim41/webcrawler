# Web Crawler

This is a simple web crawler project designed to crawl web pages, preprocess HTML content, perform searches, and present the results in a user-friendly interface. The project consists of PHP files for backend functionality and an HTML file for the user interface.

## Table of Contents

- [Features](#features)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Dependencies](#dependencies)
- [Installation](#installation)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Web Crawling:** Crawls URLs up to a specified depth.
- **HTML Content Preprocessing:** Extracts information such as title, paragraphs, and Wikipedia links.
- **Search Functionality:** Performs searches within preprocessed HTML content.
- **User Interface:** Simple and intuitive interface for user interaction.

## Usage

To use the web crawler, follow these steps:

1. Open `index.php` in a web browser.
2. Input the seed URL, max depth, and search string.
3. Click the "Search" button.
4. View the search results dynamically updated on the page.

## Project Structure

The project consists of the following files:

1. **html_processor.php:** Contains the `Preprocessor` class for HTML content preprocessing.
2. **search.php:** Contains the `Search` class for searching within preprocessed content.
3. **crawler.php:** Executes the web crawling process and handles AJAX requests.
4. **index.php:** HTML file for the user interface.

## Dependencies

The project uses the following external libraries:

- **Symfony BrowserKit:** Used for HTTP requests in the `Preprocessor` class.

## Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/your-username/web-crawler.git
   ```

2. Ensure that you have PHP and a web server (e.g., Apache) installed on your machine.

3. Open `index.php` in a web browser to access the web crawler interface.

## Contributing

Contributions are welcome! If you would like to contribute to the project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them with descriptive messages.
4. Push your changes to your fork.
5. Submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

Feel free to customize this README file according to your specific project details and preferences.
