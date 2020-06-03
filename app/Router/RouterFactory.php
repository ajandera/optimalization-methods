<?php

namespace App;

use Nette\Application\IRouter;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

/**
 * Router factory.
 */
class RouterFactory
{

    /**
     * @return IRouter
     */
    public function createRouter()
    {
        $router = new RouteList();

        $router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);

        $router[] = new Route('<presenter>[/<action>]', [
            'presenter' => [
                Route::VALUE => 'Homepage',
                Route::FILTER_TABLE => [
                    'vypocty' => 'Computation',
                    'chyba' => 'error',
                    'modelovy-priklad' => 'Example',
                    'prihlaseni' => 'Sign',
                    'teoria' => 'Theory'
                ],
                Route::FILTER_STRICT => true,
            ],
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    'stranka-nenalezena' => '404',
                    'registrace' => 'register',
                    'potvrzeni' => 'confirm',
                    'odhlasenie' => 'logout'
                ],
                Route::FILTER_STRICT => true,
            ],
        ]);

        return $router;
    }
}
