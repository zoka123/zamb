<?php

namespace Zantolov\Zamb\Model;

use Zantolov\ZambEcommerce\Models\Shopper;
use Zizaco\Confide\Facade as ConfideFacade;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends BaseModel implements ConfideUserInterface
{
    use HasRole;

    protected $table = 'users';

    /** @var Shopper $shopper */
    protected $shopper = null;

    protected $fillable = array('username', 'email', 'confirmed', 'password', 'password_confirmation');

    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    public static $rules = array(
        'username'              => 'required|between:4,16|unique:users',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|between:4,255|confirmed',
        'password_confirmation' => 'required|between:4,255',
    );

    public static $updateRules = array(
        'username'              => 'unique|required|between:4,16',
        'email'                 => 'unique|required|email',
        'password'              => 'between:4,255|confirmed',
        'password_confirmation' => 'between:4,255',
    );

    public static $updateRulesWithoutPasswordConfirmation = array(
        'username' => 'unique|required|between:4,16',
        'email'    => 'unique|required|email',
        'password' => 'between:4,255',
    );

    public $relatedIds = array(
        'roles' => array()
    );

    /* RELATED MODELS START */
    /**********************/
    public function rolesLoadIds()
    {
        $this->relatedIds['roles'] = $this->roles()->lists('role_id');
    }

    public function rolesSave($roles)
    {
        $this->roles()->sync($roles);
    }
    /**********************/
    /* RELATED MODELS END */


    public function beforeSave()
    {
        if ($this->isDirty('password')) {
            $this->password = Hash::make($this->password);
        }

        if (isset($this->password_confirmation)) {
            unset($this->password_confirmation);
        }

        return true;
    }


    /**
     * Confirm the user (usually means that the user)
     * email is valid. Sets the confirmed attribute of
     * the user to true and also update the database.
     *
     * @return bool Success.
     */
    public function confirm()
    {
        $this->confirmed = true;

        return ConfideFacade::confirm($this->confirmation_code);
    }

    /**
     * Generates a token for password change and saves it in the
     * 'password_reminders' table with the email of the
     * user.
     *
     * @return string $token
     */
    public function forgotPassword()
    {
        return ConfideFacade::forgotPassword($this->email);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @see \Illuminate\Auth\UserInterface
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        // Get the value of the model's primary key.
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @see \Illuminate\Auth\UserInterface
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @see \Illuminate\Auth\UserInterface
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @see \Illuminate\Auth\UserInterface
     *
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @see \Illuminate\Auth\UserInterface
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @see \Illuminate\Auth\Reminders\RemindableInterface
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Checks if the current user is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        $errors = $this->errors();
        if ($errors) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Returns an instance of related Shopper or empty Shopper model
     * @return Shopper
     */
    public function getShopper()
    {
        if (empty($this->shopper)) {
            $this->shopper = Shopper::where(array('user_id' => $this->id))->first();
        }

        if (empty($this->shopper)) {
            $this->shopper = new Shopper();
        }

        return $this->shopper;
    }


    public function orders()
    {
        return Order::where(array('shopper_id' => $this->getShopper()->id));
    }
}