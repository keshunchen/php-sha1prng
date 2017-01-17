# PHP-SHA1PRNG

## You can use this php code to generate the 128bit AES KEY from the password
```
$key = substr(openssl_digest(openssl_digest($password, 'sha1', true), 'sha1', true), 0, 16);
```

## like this java code.
```
        KeyGenerator _generator = KeyGenerator.getInstance("AES");
        SecureRandom secureRandom = SecureRandom.getInstance("SHA1PRNG");
        secureRandom.setSeed(strPassword.getBytes());
        _generator.init(128, secureRandom);
        return _generator.generateKey();
```
      
## Notes

* It's **not** a complete implemention.
* reference [https://github.com/bombworm/SHA1PRNG]
