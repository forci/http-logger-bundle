<?php

/*
 * This file is part of the ForciHttpLoggerBundle package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\HttpLoggerBundle\Entity;

class RequestLogMessageType {

    const ID_URL_ENCODED = 1;
    const ID_HTML = 2;
    const ID_XML = 3;
    const ID_JSON = 4;
    const ID_TEXT_PLAIN = 5;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var RequestLogMessage[] */
    protected $messages;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) {
        $this->name = $name;
    }

    /**
     * @return RequestLogMessage[]
     */
    public function getMessages() {
        return $this->messages;
    }

    public function __construct() {
    }
}
