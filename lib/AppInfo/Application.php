<?php

namespace OCA\Workspace\AppInfo;

use OCP\AppFramework\App;

use OCP\IURLGenerator;
use OCP\IUser;

use \OCA\Workspace\Middleware\GeneralManagerMiddleware;

class Application extends App {
        public const APP_ID = 'workspace';

        public const GENERAL_MANAGER = "GeneralManager";

        public function __construct(array $urlParams=[] ) {
                parent::__construct(self::APP_ID, $urlParams);

                $container = $this->getContainer();

                $container->registerService('GeneralManagerMiddleware', function($c){
                    return new GeneralManagerMiddleware(
                        $c->query(IURLGenerator::class),
                        $c->query(IUser::class)
                    );
                });

                $container->registerMiddleware('OCA\Workspace\Middleware\GeneralManagerMiddleware');
        }
}