<?php

declare(strict_types=1);

namespace OCA\Workspace\Controller\Exceptions;

use OCP\AppFramework\Http;

class AclGroupFolderException extends \Exception {
    public function __construct()
    {
        parent::__construct('GroupFolder API to manage ACL for a groupfolder doesn\'t work.', Http::STATUS_INTERNAL_SERVER_ERROR);
    }
}