happycms
========

INSTALLATION
------------

Create composer.json file in your project directory with content:
<pre>
{
    "require": {
        "php":">=5.4.0",
        "happycms/happycms":"dev-master"
    },
    
    "repositories":[
        {
            "type":"git",
            "url":"http://github.com/a1essar/happycms"
        }
    ]
}
</pre>

And using the following command:
<pre>
cd path/to/composer.json
composer install
</pre>

Copy files of happycms/lib/Web/ to your www directory
