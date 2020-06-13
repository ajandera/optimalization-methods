<?php



namespace App;

use Nette;

/**
 * Class ExamplePresenter
 * @package App\Presenters
 */
class ExamplePresenter extends BasePresenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:');
        }
    }

    public function renderDefault()
    {

    }
}
