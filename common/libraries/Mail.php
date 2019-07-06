<?php
namespace common\libraries;

use yii\swiftmailer\Mailer;

class Mail extends Mailer
{

    public $mainTransport;
    public $defaultTransport;

    private $from;


    public function setfrom($value)
    {
        $this->from = $value;
    }


    public function setTransport($transport)
    {
        if ($transport === false)
            $transport = $this->mainTransport;

        if (!is_array($transport) && !is_object($transport)) {
            if (is_string($transport)) {
                parent::setTransport($this->defaultTransport[$transport]);
            } else {
                throw new InvalidConfigException('"' . get_class($this) . '::transport" should be either object or array or string, "' . gettype($transport) . '" given.');
            }
        } else {
            if (array_key_exists('class', $transport)) {
                parent::setTransport($transport);
            }
            else {
                if(is_null($this->defaultTransport)){
                    $this->defaultTransport = $transport;

                }
                parent::setTransport($transport[$this->mainTransport]);
            }



        }

    }


    //public function getMainTransport


}