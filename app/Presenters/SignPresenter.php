<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\UsersManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;

/**
 * Class SignPresenter
 * @package App\Presenters
 */
final class SignPresenter extends Nette\Application\UI\Presenter
{
    /** @var UsersManager @inject */
    public $userManager;

    public function actionDefault(): void
    {

    }

    /**
     * @return IComponent|null
     */
    protected function createComponentSignInForm(): ?IComponent
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
    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        $values = $form->getValues();
        $this->getUser()->login($values->email, $values->password);
        $this->getUser()->setExpiration("1 day");
        $this->redirect('Homepage:');
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
    protected function createComponentSignUpForm(): ?IComponent
    {
        $form = new Form();
        $form->addEmail('email', '')
            ->setHtmlAttribute('placeholder', 'Email')
            ->setRequired(true);
        $form->addPassword('password', '')
            ->setHtmlAttribute('placeholder', 'Password')
            ->setRequired(true)
            ->addRule(Form::MIN_LENGTH, 'Minimal password length is %d.', 8);
        $form->addPassword('check', '')
            ->setHtmlAttribute('placeholder', 'Password Again')
            ->setRequired(true)
            ->addRule(Form::EQUAL, 'Password don\'t match', $form['password']);
        $form->addProtection('Error time limit fail.');
        $form->addSubmit('submit', 'Sign Up');
        $form->onSuccess[] = [$this, 'signUpFormSucceeded'];
        return $form;
    }

    /**
     * @param Form $form
     * @param \stdClass $values
     * @throws Nette\Application\AbortException
     */
    public function signUpFormSucceeded(Form $form, \stdClass $values): void
    {
        $values = $form->getValues();
        $this->userManager->insert($values->email, $values->password);
        $this->flashMessage('Registrácia bola úspešná', 'success');
        $this->redirect('this');
    }
}
