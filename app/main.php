<?php
function getPosts() {
    /* Associative Array to Propogate Posts Section */
    $posts = [
        ["User Name" => "John Smith", 
        "Picture" => "images/image1-300x200-adem-ay.jpg", 
        "Message" => "Hello there! Implement a web application in PHP which displays users comments. A comment has a user (or
        username), users picture, comment and a date.", 
        "Date" => "19/07/2022"],
        
        ["User Name" => "Steve Reed", 
        "Picture" => "images/image2-300x200-priscilla-du-preez.jpg", 
        "Message" => "What's going on? Define an associative array which contains comments. For now, simply hard code at least
        3 comments into the array.", 
        "Date" => "18/07/2022"],

        ["User Name" => "Jane Doe", 
        "Picture" => "images/image3-300x200-brooke-cagle.jpg", 
        "Message" => "How have you been? Iterate through the array to place each comment in an html document for display.", 
        "Date" => "17/07/2022"]
    ];
    return $posts;
}
?> 
