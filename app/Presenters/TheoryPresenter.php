<?php



namespace App;

use Nette;

/**
 * Class TheoryPresenter
 * @package App\Presenters
 */
class TheoryPresenter extends BasePresenter
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
