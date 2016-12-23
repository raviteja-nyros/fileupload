# fileupload

This is all about Uploading the files using AJAX and PHP , MYSQL.

  Important Points:

         *Storing the files into the path with radom names.
 
         *Ajax pagination.
 
         *Easy to understand the each and every part of code.


  Just changes should be done if any in database.php



          Database: `crud_tutorial`

          Table structure for table `customers`


          CREATE TABLE IF NOT EXISTS `customers` (
                   `id` int(11) NOT NULL AUTO_INCREMENT,
                   `name` varchar(202) NOT NULL,
                   `Size` varchar(40) NOT NULL,
                   `image` varchar(100) NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `name` (`name`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



*****create and enjoy uploading files*****
