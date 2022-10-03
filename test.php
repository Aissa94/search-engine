<?php
 /**
 * Author: Aissa BELKAID
 * CreateDate: 02/10/2022
 * Description: the main page to get the results of our SearchEngine.
 */

# Get the domain and the keywords
$domain = isset($_POST['domain']) ? $_POST['domain'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';
$keywords = explode(";", $search); //Breaks the string 'search' into an array 'keywords'

require 'SearchEngine.php';

# Create an instance of SearchEngine() class
$client = new SearchEngine();

# Defining the research domain
$client->setEngine($domain);

# Get {'keyword', 'ranking', 'url', 'title', 'description', 'promoted'} parameters for each keyword
$results = $client->search($keywords);

foreach ($results as $value) {
    var_dump($value);
}

/** Output
 * array (6) {
 * 'keyword' => string 'online courses' (length=14)
 * 'ranking' => int 6
 * 'url' => string 'https://www.edx.org/' (length=20)
 * 'title' => string 'edX | Free Online Courses by Harvard, MIT, &amp; more | edX' (length=59)
 * 'description' => string 'Access 2000 free online courses from 140 leading institutions worldwide. Gain new skills and earn a certificate of completion. Join today.Harvard University   · Language Courses   · English Courses   · Economics Courses  ' (length=224)
 * 'promoted' => int 0
 * }
 */

 ?>
