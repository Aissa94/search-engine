# search-engine
The package is a library for crawling search engine results and extracting metadata for a set of keywords for the first 5 pages. The compatible search engine would be "google. ae" and "google.com".

[SearchEngine](https://github.com/Aissa94/search-engine)

### 2.How to Use?
This project can be installed via composer by requiring the `aissa94/search-engine` package in `composer.json`:

``` json
{
    "require": {
        "aissa94/search-engine": "1.0"
    }
}
```

You can also simply download the project from https://github.com/Aissa94/search-engine and start it directly from the "index.html" page.

![alt text](https://github.com/Aissa94/search-engine/blob/main/images/astrolabs.png)

**Example**

``` php


# Create an instance of SearchEngine() class
$client = new SearchEngine();

# Defining the research domain
$client->setEngine("google.ae");

# Get {'keyword', 'ranking', 'url', 'title', 'description', 'promoted'} parameters for each keyword
$results = $client->search(["astrolabs", "Fullstack Role"]);

foreach ($results as $value) {
    var_dump($value);
}

```

**Output**
![image](https://user-images.githubusercontent.com/26188934/193887169-49f04e73-1a2d-4ac7-bc40-dce9705dabe0.png)

``` php
  
array (6) {
  'keyword' => string 'astrolabs' //keyword being searched
  'ranking' => int 0 //ranking where the result was found on the search engine, the topmost result would be 0 and the last would be 50
  'url' => string 'https://astrolabs.com/' //url of the page as it appears in google search
  'title' => string 'AstroLabs: Building Digital Capabilities - AstroLabs' //title of the page as it appears in google search
  'description' => string 'AstroLabs serves as a trusted partner to the largest corporates and universities in the region, running customized programs for capability development. Starting ...About AstroLabs  Dubai Coworking Space  Jobs  Open Academy  ' //description as it appears in google search
  'promoted' => int 0 //promoted is a boolean value indicating whether the result is an ad or organic result
}
...

array (size=6) {
  'keyword' => string 'Fullstack Role' (length=14)
  'ranking' => int 15
  'url' => string 'https://www.michaelpage.com.sg/advice/job-description/technology/fullstack-developer' (length=84)
  'title' => string 'Full Stack Developer - Job Description - Michael Page Singapore' (length=63)
  'description' => string '20 Jan 2022  ·  Duties and responsibilities - What does a Full Stack Developer do? · Planning major projects with input and consultation with end users, clients ...' (length=167)
  'promoted' => int 0
}
...
```

