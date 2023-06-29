<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
</head>
<body>
    <?php
    // Connect to the MySQL database
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'blog';

    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Fetch blog posts from the database
    $query = 'SELECT * FROM blog_posts';
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Check if a specific blog post is requested
        if (isset($_GET['post'])) {
            $postId = $_GET['post'];

            // Fetch the individual blog post from the database
            $query = "SELECT * FROM blog_posts WHERE id = $postId";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $post = mysqli_fetch_assoc($result);

                // Display the individual blog post content
                echo '<h2>' . $post['title'] . '</h2>';
                echo '<p>' . $post['content'] . '</p>';
                echo '<p>Author: ' . $post['author'] . '</p>';
                echo '<p>Date: ' . $post['date'] . '</p>';
                echo '<a href="index.php">Return to Blog List</a>';
            } else {
                echo '<h2>Post not found.</h2>';
            }
        } else {
            // Display the list of blog posts
            echo '<h1>My Blog</h1>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<h2><a href="?post=' . $row['id'] . '">' . $row['title'] . '</a></h2>';
                echo '<p>' . $row['content'] . '</p>';
                echo '<hr>';
            }
        }
    } else {
        echo '<h2>No blog posts found.</h2>';
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
