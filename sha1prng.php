class SHA1PRNG
{
    public static function sha1prng($seed)
    {
        $btLength = 16; //key length
        //bt = new Buffer(btLength),
        $bt = [];
        $index = 0;
        $DIGEST_SIZE = 20;
        $output = "";
        $remCount = 0;

        //var sha = crypto.createHash('sha1'),
        //sha.update(seed);
        //var state = sha.digest('buffer');
        $state = self::getBytes(openssl_digest($seed, 'sha1', true));

        while ($index < $btLength) {
            //sha = crypto.createHash('sha1');
            //sha.update(state);
            //output = sha.digest('buffer');
            $output = self::getBytes(openssl_digest(self::toStr($state), 'sha1', true));

            $state = self::updateState($state, $output);
            $tdo = ($btLength - $index) > $DIGEST_SIZE ? $DIGEST_SIZE : $btLength - $index;
            // Copy the bytes, zero the buffer
            for ($i = 0; $i < $tdo; $i++) {
                $bt[$index++] = $output[$i];
                $output[$i] = 0;
            }
        }

        return self::toStr($bt);
    }

    private static function updateState($state, $output)
    {
        $last = 1;
        $v = 0;
        $t = 0;
        $zf = false;
        // state(n + 1) = (state(n) + output(n) + 1) % 2^160;
        for ($i = 0; $i < count($state); $i++) {
            // Add two bytes
            $v = self::getInt8($state[$i]) + self::getInt8($output[$i]) + $last;
            // Result is lower 8 bits
            $t = $v & 255;
            // Store result. Check for state collision.
            $zf = $zf | ($state[$i] != $t);
            $state[$i] = $t;
            // High 8 bits are carry. Store for next iteration.
            $last = $v >> 8;
        }

        // Make sure at least one bit changes!
        if (!$zf)
            $state[0]++;
        return $state;
    }

    private static function getInt8($num)
    {
        if ($num > 127) {
            return $num - 256;
        }
        return $num;
    }

    private static function getBytes($str)
    {
        $bytes = array();
        for($i = 0; $i < strlen($str); $i++){
            $bytes[] = ord($str[$i]);
        }
        return $bytes;
    }

    private static function toStr($bytes)
    {
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }

        return $str;
    }

}
