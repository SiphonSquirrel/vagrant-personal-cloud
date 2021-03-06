README
======

Install
-------

1. Place all files in subdirectory with PHP enabled.
2. Edit `config.php`.

Adding Images
-------------

In your repo directory (specified in `config.php` as `$repo`), create the following layout:
* user1
  * image1
    * meta.json
    * v0.1
      * provider1
        * package.box
      * provider2
        * package.box
    * v0.2
      * provider1
        * package.box
      * provider3
        * package.box
* user2
  * ...

The first level of directories represent each user's directory. The next level is the image for that user. The image directory then contains a `meta.json` and a subdirectory for each version. The image `meta.json` looks like this:
```
{
  "description_markdown":"This is the long description (in Markdown)",
  "short_description":"short description"
}
```
Then each version directory contains subdirectories for each provider the image is available in and optionally a `meta.json`. The version `meta.json` looks like this:
```
{
  "description_markdown":"This is a description of the version."
}
```
The provider directory contains a single file, the package.box.

Using the Cloud
---------------

You need to make sure Vagrant 1.5 or greater is installed and need to set the environment variables `VAGRANT_SERVER_URL` to the base URL where the cloud is accessible.
