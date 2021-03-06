<?php

namespace App;

use App\Model\UsersManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;

/**
 * Class SignPresenter
 * @package App\Presenters
 */
class SignPresenter extends Nette\Application\UI\Presenter
{
    /** @var UsersManager @inject */
    public $userManager;

    public function actionDefault()
    {

    }

    /**
     * @return IComponent|null
     */
    protected function createComponentSignInForm()
    {
        $form = new Form();
        $form->addText('email', '')
            ->setHtmlAttribute('placeholder', 'jméno')
            ->setRequired(true);
        $form->addPassword('password', '')
            ->setHtmlAttribute('placeholder', 'heslo')
            ->setRequired(true);
        $form->addSubmit('submit', 'Přihlásit');
        $form->addProtection('Error time limit fail.');
        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }

    /**
     * @param Form $form
     * @param \stdClass $values
     * @throws Nette\Application\AbortException
     * @throws Nette\Security\AuthenticationException
     */
    public function signInFormSucceeded(Form $form, \stdClass $values)
    {
        $values = $form->getValues();
        try {
            $this->getUser()->login($values->email, $values->password);
            $this->getUser()->setExpiration("1 day");
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), "danger");
            $this->redirect('this');
        }

    }

    /**
     * @throws Nette\Application\AbortException
     */
    public function renderLogout()
    {
        $this->getUser()->logout(true);
        $this->redirect("Sign:");
    }

    /**
     * @return IComponent|null
     */
    protected function createComponentSignUpForm()
    {
        $form = new Form();
        $form->addEmail('email', '')
            ->setHtmlAttribute('placeholder', 'Email')
            ->setRequired(true);
        $form->addPassword('password', '')
            ->setHtmlAttribute('placeholder', 'Heslo')
            ->setRequired(true)
            ->addRule(Form::MIN_LENGTH, 'Minimálna dľžka hesla je %d.', 8);
        $form->addPassword('check', '')
            ->setHtmlAttribute('placeholder', 'Heslo pre kontrolu')
            ->setRequired(true)
            ->addRule(Form::EQUAL, 'Hesla nesúhlasí', $form['password']);
        $form->addProtection('Vypršal časový limit.');
        $form->addSubmit('submit', 'Regitrovať');
        $form->onSuccess[] = [$this, 'signUpFormSucceeded'];
        return $form;
    }

    /**
     * @param Form $form
     * @param \stdClass $values
     * @throws Nette\Application\AbortException
     */
    public function signUpFormSucceeded(Form $form, \stdClass $values)
    {
        $values = $form->getValues();

        $domain = 'tuke.sk';

        if (strpos($values->email, $domain) !== false) {
            $this->userManager->insert($values->email, $values->password);
            $this->flashMessage('Registrácia bola úspešná', 'success');
        } else {
            $this->flashMessage('Iba školský email z tuke.sk je povolený.', 'danger');
        }

        $this->redirect('this');
    }
}
