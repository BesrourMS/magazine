# Magazine
Magazine : Blogging Theme for Pico CMS

## Installation
Download the magazine folder, upload it in the themes folder of your pico installation and change the following setting within your config.php:
```sh
 $config['theme'] = 'magazine'; 
 $config['pages_order_by'] = 'date'; 
```

You must add these custom settings in your config file 
```sh
$config['author'] = 'Your Name';  
$config['authordescription'] = 'Web Developer';
$config['authortwitter'] = 'https://twitter.com/YourUsername'; 
$config['authorfacebook'] = 'https://facebook.com/YourPage';
$config['authorinstagram'] = 'https://www.instagram.com/YourUsername';
$config['authorimage'] = 'http://yoursite.com/images/yourphoto.jpg';
$config['numPerPage'] = 16; // Number of posts on front page
```
For Pico CMS >= 2.0 add to config/config.yml
```sh
theme: magazine
```
(If the file does not exist, create it. For more info see config/config.yml.template)

### Search & Categories
To activate search & categories functionalities, Download the plugins folder, upload the two folders : (<a href="https://github.com/c2315147">pico_categories_page</a>, <a href="https://github.com/mwgg/Pico-Search">pico_search</a>) in your plugins folder and download search.md & categories.md from content-sample and upload its to your content folder.

### Front Page & Post Page
Copy index.md & page.md from content-sample to your content folder and change the meta data 

## <a href="http://freehtml5.co/demos/magazine/">Click here for the Demo</a>

