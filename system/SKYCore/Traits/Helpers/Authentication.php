<?php

namespace SKYCore\Traits\Helpers;
/**
 * Trait Authentication
 * @package SKYCore\Traits\Helpers
 *
 * @version 1.0
 */
trait Authentication
{
    /**
     * @param string $password
     * @param int $alg
     * @return string
     *
     * @version 1.0
     */
    function hash(string $password, int $alg = PASSWORD_BCRYPT):string {
        return password_hash($password,$alg);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     *
     * @version 1.0
     */
    function check_hash(string $password, string $hash):bool {
        return password_verify($password,$hash);
    }
}