# CLI WEB Parser

Script that finds all values of attributes href/src from tags:
- `<а href> links`
- `<img href> images`
- `<script src> scripts`
- `<link href> styles`

Output data will be saved in output.json file, where each TAG has a lost of all values.

___

### How to run script

* run command `composer install`
* run command `php artisan cliWebParser url` - replace url with URL you want to parse.
* output data will be saved in output.json file
