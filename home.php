<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawler UI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Add any custom styles here */
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Web Crawler</h2>
            <form id="crawlerForm" action="crawler.php" method="post">
                <div class="form-group">
                    <label for="seedUrl">Seed URL:</label>
                    <input type="url" class="form-control" id="seedUrl" name="seedUrl" required>
                </div>
                <div class="form-group">
                    <label for="maxDepth">Max Depth:</label>
                    <input type="number" class="form-control" id="maxDepth" name="maxDepth" required>
                </div>
                <div class="form-group">
                    <label for="searchString">Search String:</label>
                    <input type="text" class="form-control" id="searchString" name="searchString" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="search()">Search</button>
            </form>

            <div id="searchResults" class="mt-4"></div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    function search() {
        var seedUrl = $('#seedUrl').val();
        var maxDepth = $('#maxDepth').val();
        var searchString = $('#searchString').val();

        $.ajax({
            type: 'POST',
            url: 'crawler.php',
            data: { seedUrl: seedUrl, maxDepth: maxDepth, searchString: searchString },
            success: function () {
                // Wait for the results.json file to be created
                waitForResults();
            },
            error: function (xhr, status, error) {
                console.error("Error during search:", status, error);
                $('#searchResults').html('<p class="mt-4">Error during search.</p>');
            }
        });
    }

    function waitForResults() {
        var intervalId = setInterval(function () {
            $.ajax({
                type: 'GET',
                url: 'results.json',
                dataType: 'json',
                success: function (results) {
                    clearInterval(intervalId);
                    displayResults(results);
                },
                error: function () {
                    // Retry after a short delay
                }
            });
        }, 1000); // Adjust the delay as needed
    }

    function displayResults(results) {
        var searchString = $('#searchString').val();
        var searchResultsDiv = $('#searchResults');

        if (results.length !== 0) {
            // Sort the results based on the length of matchedContents
            results.sort(function(a, b) {
                return b.matchedContents.length - a.matchedContents.length;
            });

            var html = '';  // Initialize an empty string to concatenate the HTML

            // Display "Search Results For" only once
            html += '<div class="mt-4">';
            html += '<h4>Search Results For: ' + htmlspecialchars(searchString) + '</h4>';
            html += '</div>';

            // Modern look using Bootstrap list group
            html += '<ul class="list-group mt-4">';

            for (var url = 0; url < results.length; url++) {
                var title = results[url]['title'];
                var matchedContents = results[url]['matchedContents'];

                html += '<li class="list-group-item">';
                html += '<p>Title: <a href="' + htmlspecialchars(results[url]['url']) + '" target="_blank">' + htmlspecialchars(title) + '</a></p>';
                html += '<ul>';

                $.each(matchedContents, function (index, content) {
                    // Limit the content to no more than 100 characters
                    var limitedContent = content.length > 100 ? content.substring(0, 100) + '...' : content;
                    html += '<li>' + htmlspecialchars(limitedContent) + '</li>';
                });

                html += '</ul>';
                html += '</li>';
            }

            html += '</ul>';
            searchResultsDiv.html(html);  // Set the concatenated HTML to the div

        } else {
            searchResultsDiv.html('<p class="mt-4">No matching results found.</p>');
        }
    }

    function htmlspecialchars(str) {
        return $('<div>').text(str).html();
    }
</script>
</body>
</html>
