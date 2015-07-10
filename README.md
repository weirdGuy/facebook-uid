# FB-uid
**FB-uid** — it's a small library to getting userid from his username

### Installation
* First of all -- download lib
* require that in your script
```sh
    include_once('fbuid.php');
```
* Init it
```sh
    $fbuid = new FBUID('fbusername', 'fbpass');
```

### Using
For use you need to insert username and password of your account.
After initializing you can use getUid-method

```sh
    $uid = $fbuid->getUid('usernickname');
    echo $uid;
    //will return you digit id of this user
```
### Todo's

 - Make able to scrub all uids from event list etc.

### License
[MIT](https://github.com/I7uoHep/minecraftLibrary/blob/master/LICENSE)
