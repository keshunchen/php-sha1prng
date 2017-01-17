# php-sha1prng

## AES 128 bit, you can use this php code:

        $key = substr(openssl_digest(openssl_digest($password, 'sha1', true), 'sha1', true), 0, 16);

## to generate the AES KEY from the Password

        KeyGenerator _generator = KeyGenerator.getInstance("AES");
        SecureRandom secureRandom = SecureRandom.getInstance("SHA1PRNG");
        secureRandom.setSeed(strPassword.getBytes());
        _generator.init(128, secureRandom);
        return _generator.generateKey();
      
## if not aes 128, you can you this php file.
