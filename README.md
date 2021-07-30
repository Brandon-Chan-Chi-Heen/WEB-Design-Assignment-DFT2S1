# WEB-Design-Assignment-DFT2S1

Regarding SCSS
If you dont know how to setup SASS and compile, just edit the index.css file directly. I'll fix that later

I'm using VS code instead of Netbeans so if you wanna setup in VS code I can help you.

edit 1:
Ignore the above. 

#NOTE 1
Please require env_variables.php in all your files. 

change sevRoot accordingly
sevRoot : use this for any href links or resource(images) hyperlinks
ex: 
```"<img src="$sevRoot/resources/user_icon.png" alt="user" width="32" height="32" class="rounded-circle mx-2">```

docRoot: use this for php functions such as include, require, etc

things can turn out very weird if you try something like
require("/utility/utility.php");

above will break because php will search from your pc instead of server path

